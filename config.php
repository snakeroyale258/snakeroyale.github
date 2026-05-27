<?php
// ============================================================
//  Snake Royale — Configuración de base de datos
//  Edita los valores según tu servidor
// ============================================================

define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'club_deportivo');
define('DB_USER', 'root');    // ← cambia por tu usuario
define('DB_PASS', '');        // ← cambia por tu contraseña
define('DB_PORT', '3306');

try {
    $pdo = new PDO(
        sprintf(
            'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
            DB_HOST, DB_PORT, DB_NAME
        ),
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
            // Evita que PDO convierta enteros a string
            PDO::ATTR_STRINGIFY_FETCHES  => false,
        ]
    );
} catch (PDOException $e) {
    // No exponer detalles del error en producción
    $esModo = ($_SERVER['SERVER_NAME'] ?? '') === 'localhost' || ($_SERVER['REMOTE_ADDR'] ?? '') === '127.0.0.1';
    $detalle = $esModo ? ': ' . $e->getMessage() : '';
    http_response_code(500);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'ok'  => false,
        'msg' => 'No se pudo conectar a la base de datos' . $detalle,
        'data' => null,
    ], JSON_UNESCAPED_UNICODE);
    exit;
}
