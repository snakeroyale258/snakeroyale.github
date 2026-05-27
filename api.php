<?php
// ============================================================
//  Snake Royale — API Backend
//  Maneja: miembros, equipos, torneos, actividades
// ============================================================

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Responde al preflight de CORS y termina
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(200); exit; }

// ── Conexión ─────────────────────────────────────────────────
require_once 'config.php';   // define $pdo

$tabla  = $_GET['tabla']  ?? '';
$accion = $_GET['accion'] ?? 'listar';
$id     = $_GET['id']     ?? null;

// ── Enrutador ────────────────────────────────────────────────
try {
    switch ($tabla) {
        case 'miembros':    handleMiembros($pdo, $accion, $id);    break;
        case 'equipos':     handleEquipos($pdo, $accion, $id);     break;
        case 'torneos':     handleTorneos($pdo, $accion, $id);     break;
        case 'actividades': handleActividades($pdo, $accion, $id); break;
        default:            resp(400, 'Tabla no válida');
    }
} catch (PDOException $e) {
    resp(500, 'Error de base de datos: ' . $e->getMessage());
}

// ════════════════════════════════════════════════════════════
//  MIEMBROS
// ════════════════════════════════════════════════════════════
function handleMiembros(PDO $pdo, string $accion, $id): void
{
    switch ($accion) {
        // ── Listar ──────────────────────────────────────────
        case 'listar':
            $rows = $pdo->query("SELECT * FROM jugadores ORDER BY NOMBRE")->fetchAll();
            resp(200, 'ok', $rows);
            break;

        // ── Guardar (INSERT o UPDATE por nombre) ─────────────
        case 'guardar':
            $d   = jsonBody();
            $req = ['nombre', 'posicion', 'numero', 'equipo', 'estado', 'ingreso'];
            foreach ($req as $f) {
                if (!isset($d[$f]) || trim((string)$d[$f]) === '') {
                    resp(422, "Campo requerido: $f");
                }
            }
            $sql = "INSERT INTO jugadores (NOMBRE, POCISION, `NO°`, EQUIPO, ESTADO, INGRESO)
                    VALUES (:nombre, :posicion, :numero, :equipo, :estado, :ingreso)
                    ON DUPLICATE KEY UPDATE
                      POCISION = VALUES(POCISION),
                      `NO°`    = VALUES(`NO°`),
                      EQUIPO   = VALUES(EQUIPO),
                      ESTADO   = VALUES(ESTADO),
                      INGRESO  = VALUES(INGRESO)";
            $st = $pdo->prepare($sql);
            $st->execute([
                ':nombre'   => trim($d['nombre']),
                ':posicion' => trim($d['posicion']),
                ':numero'   => trim((string)$d['numero']),
                ':equipo'   => trim($d['equipo']),
                ':estado'   => trim($d['estado']),
                ':ingreso'  => trim($d['ingreso']),
            ]);
            resp(200, 'Miembro guardado correctamente');
            break;

        // ── Eliminar ─────────────────────────────────────────
        case 'eliminar':
            // Acepta DELETE o GET (compatibilidad con proxies que no permiten DELETE)
            if (!in_array($_SERVER['REQUEST_METHOD'], ['DELETE', 'GET'], true)) {
                resp(405, 'Método no permitido');
            }
            if (!$id) resp(422, 'Se requiere el nombre (id)');
            $st = $pdo->prepare("DELETE FROM jugadores WHERE NOMBRE = :id");
            $st->execute([':id' => urldecode($id)]);
            if ($st->rowCount() === 0) resp(404, 'Miembro no encontrado');
            resp(200, 'Miembro eliminado');
            break;

        default: resp(400, 'Acción no válida');
    }
}

// ════════════════════════════════════════════════════════════
//  EQUIPOS
// ════════════════════════════════════════════════════════════
function handleEquipos(PDO $pdo, string $accion, $id): void
{
    switch ($accion) {
        case 'listar':
            $rows = $pdo->query("SELECT * FROM equipos ORDER BY nombre")->fetchAll();
            resp(200, 'ok', $rows);
            break;

        case 'guardar':
            $d = jsonBody();
            if (empty(trim($d['nombre'] ?? ''))) resp(422, 'Campo requerido: nombre');
            $sql = "INSERT INTO equipos (nombre, categoria, entrenador, jugadores)
                    VALUES (:nombre, :categoria, :entrenador, :jugadores)
                    ON DUPLICATE KEY UPDATE
                      categoria  = VALUES(categoria),
                      entrenador = VALUES(entrenador),
                      jugadores  = VALUES(jugadores)";
            $st = $pdo->prepare($sql);
            $st->execute([
                ':nombre'     => trim($d['nombre']),
                ':categoria'  => trim($d['categoria']  ?? ''),
                ':entrenador' => trim($d['entrenador'] ?? 'Por asignar') ?: 'Por asignar',
                ':jugadores'  => (int)($d['jugadores'] ?? 0),
            ]);
            resp(200, 'Equipo guardado correctamente');
            break;

        case 'eliminar':
            if (!$id) resp(422, 'Se requiere el id');
            $st = $pdo->prepare("DELETE FROM equipos WHERE id = :id");
            $st->execute([':id' => (int)$id]);
            if ($st->rowCount() === 0) resp(404, 'Equipo no encontrado');
            resp(200, 'Equipo eliminado');
            break;

        default: resp(400, 'Acción no válida');
    }
}

// ════════════════════════════════════════════════════════════
//  TORNEOS
// ════════════════════════════════════════════════════════════
function handleTorneos(PDO $pdo, string $accion, $id): void
{
    switch ($accion) {
        case 'listar':
            $rows = $pdo->query("SELECT * FROM torneos ORDER BY fecha DESC")->fetchAll();
            resp(200, 'ok', $rows);
            break;

        case 'guardar':
            $d = jsonBody();
            if (empty(trim($d['torneo'] ?? ''))) resp(422, 'Campo requerido: torneo');

            // Valida que la fecha tenga formato YYYY-MM-DD
            $fecha = $d['fecha'] ?? date('Y-m-d');
            if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha)) {
                $fecha = date('Y-m-d');
            }

            $estadosValidos = ['Próximo', 'En curso', 'Finalizado'];
            $estado = in_array($d['estado'] ?? '', $estadosValidos, true)
                      ? $d['estado'] : 'Próximo';

            $sql = "INSERT INTO torneos (torneo, categoria, fecha, estado, equipos)
                    VALUES (:torneo, :categoria, :fecha, :estado, :equipos)";
            $st = $pdo->prepare($sql);
            $st->execute([
                ':torneo'    => trim($d['torneo']),
                ':categoria' => trim($d['categoria'] ?? ''),
                ':fecha'     => $fecha,
                ':estado'    => $estado,
                ':equipos'   => max(2, (int)($d['equipos'] ?? 2)),
            ]);
            resp(200, 'Torneo guardado correctamente');
            break;

        case 'eliminar':
            if (!$id) resp(422, 'Se requiere el id');
            $st = $pdo->prepare("DELETE FROM torneos WHERE id = :id");
            $st->execute([':id' => (int)$id]);
            if ($st->rowCount() === 0) resp(404, 'Torneo no encontrado');
            resp(200, 'Torneo eliminado');
            break;

        default: resp(400, 'Acción no válida');
    }
}

// ════════════════════════════════════════════════════════════
//  ACTIVIDADES
// ════════════════════════════════════════════════════════════
function handleActividades(PDO $pdo, string $accion, $id): void
{
    switch ($accion) {
        case 'listar':
            $rows = $pdo->query("SELECT * FROM actividades ORDER BY dia")->fetchAll();
            resp(200, 'ok', $rows);
            break;

        case 'guardar':
            $d = jsonBody();
            if (empty(trim($d['nombre'] ?? ''))) resp(422, 'Campo requerido: nombre');

            $dia = (int)($d['dia'] ?? 1);
            if ($dia < 1 || $dia > 31) resp(422, 'El día debe estar entre 1 y 31');

            $tiposValidos = ['act', 'torneo'];
            $tipo = in_array($d['tipo'] ?? '', $tiposValidos, true) ? $d['tipo'] : 'act';

            $sql = "INSERT INTO actividades (dia, nombre, tipo) VALUES (:dia, :nombre, :tipo)";
            $st = $pdo->prepare($sql);
            $st->execute([
                ':dia'    => $dia,
                ':nombre' => trim($d['nombre']),
                ':tipo'   => $tipo,
            ]);
            resp(200, 'Actividad guardada correctamente');
            break;

        case 'eliminar':
            if (!$id) resp(422, 'Se requiere el id');
            $st = $pdo->prepare("DELETE FROM actividades WHERE id = :id");
            $st->execute([':id' => (int)$id]);
            if ($st->rowCount() === 0) resp(404, 'Actividad no encontrada');
            resp(200, 'Actividad eliminada');
            break;

        default: resp(400, 'Acción no válida');
    }
}

// ── Helpers ──────────────────────────────────────────────────
function jsonBody(): array
{
    $raw = file_get_contents('php://input');
    if ($raw === false || $raw === '') resp(400, 'Cuerpo vacío');
    $d = json_decode($raw, true);
    if (!is_array($d)) resp(400, 'JSON inválido en el cuerpo');
    return $d;
}

function resp(int $code, string $msg, $data = null): never
{
    http_response_code($code);
    echo json_encode(
        ['ok' => $code < 400, 'msg' => $msg, 'data' => $data],
        JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
    );
    exit;
}
