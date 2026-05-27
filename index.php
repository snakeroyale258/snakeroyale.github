<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Snake Royale - Club de Basquetbol</title>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Barlow:wght@400;500;600&display=swap" rel="stylesheet">
  <style>
  .logo-img img {
    width: 50px;
    height: 50px;
    object-fit: contain;
  }
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --blue:       #185FA5;
      --blue-light: #E6F1FB;
      --blue-mid:   #378ADD;
      --blue-dark:  #0C447C;
      --blue-bg:    #042C53;
      --amber:      #BA7517;
      --amber-light:#FAEEDA;
      --amber-dark: #633806;
      --gray:       #5F5E5A;
      --gray-light: #F1EFE8;
      --gray-dark:  #2C2C2A;
      --green:      #3B6D11;
      --green-light:#EAF3DE;
      --green-dark: #27500A;
      --bg:         #f0f4f9;
      --surface:    #ffffff;
      --border:     #c8d4e3;
      --text:       #0d1b2a;
      --text-muted: #5F5E5A;
    }

    body { font-family: 'Barlow', sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; }

    header {
      background: var(--blue-bg); padding: 0 2rem;
      display: flex; align-items: center; gap: 1rem;
      height: 64px; position: sticky; top: 0; z-index: 100;
      box-shadow: 0 2px 10px rgba(4,44,83,0.4);
    }
    .logo-circle {
      width: 44px; height: 44px; border-radius: 50%;
      border: 2px solid var(--blue-mid);
      display: flex; align-items: center; justify-content: center;
      font-family: 'Bebas Neue', cursive; font-size: 17px;
      color: var(--blue-mid); letter-spacing: 1px; flex-shrink: 0;
    }
    .header-title { font-family: 'Bebas Neue', cursive; font-size: 26px; color: #fff; letter-spacing: 3px; }
    .header-sub   { font-size: 12px; color: #85B7EB; margin-left: 2px; }
    .header-badge { margin-left: auto; background: var(--blue); color: #fff; font-size: 11px; font-weight: 600; padding: 4px 12px; border-radius: 20px; letter-spacing: 1px; }

    nav { background: var(--surface); border-bottom: 1px solid var(--border); padding: 0 2rem; display: flex; gap: 4px; }
    .nav-btn { padding: 14px 20px; font-family: 'Barlow', sans-serif; font-size: 14px; font-weight: 500; color: var(--text-muted); background: transparent; border: none; border-bottom: 3px solid transparent; cursor: pointer; transition: all 0.15s; }
    .nav-btn:hover { color: var(--blue-mid); }
    .nav-btn.active { color: var(--blue); border-bottom-color: var(--blue); font-weight: 600; }

    main { max-width: 1100px; margin: 0 auto; padding: 2rem 1.5rem; }
    .section { display: none; }
    .section.visible { display: block; }

    .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(130px, 1fr)); gap: 12px; margin-bottom: 1.5rem; }
    .stat-card { background: var(--surface); border: 1px solid var(--border); border-radius: 10px; padding: 16px 18px; }
    .stat-label { font-size: 12px; color: var(--text-muted); margin-bottom: 4px; }
    .stat-num { font-family: 'Bebas Neue', cursive; font-size: 34px; letter-spacing: 1px; color: var(--blue); line-height: 1; }
    .stat-num.amber { color: var(--amber); }
    .stat-num.gray  { color: var(--gray); }

    .card { background: var(--surface); border: 1px solid var(--border); border-radius: 12px; overflow: hidden; }
    .card-header { display: flex; align-items: center; justify-content: space-between; padding: 16px 20px; border-bottom: 1px solid var(--border); }
    .card-title { font-size: 16px; font-weight: 600; color: var(--text); }

    .btn-add { padding: 8px 18px; background: var(--blue); color: #fff; font-family: 'Barlow', sans-serif; font-size: 13px; font-weight: 600; border: none; border-radius: 8px; cursor: pointer; transition: background 0.15s; }
    .btn-add:hover { background: var(--blue-mid); }

    table { width: 100%; border-collapse: collapse; font-size: 14px; }
    thead { background: #f0f5fb; }
    th { padding: 11px 18px; text-align: left; font-size: 12px; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid var(--border); }
    td { padding: 12px 18px; border-bottom: 1px solid #dde8f3; color: var(--text); }
    tr:last-child td { border-bottom: none; }
    tbody tr:hover td { background: #f0f5fb; }
    .td-id   { color: var(--text-muted); font-size: 12px; }
    .td-bold { font-weight: 600; }
    .td-num  { font-family: 'Bebas Neue', cursive; font-size: 20px; color: var(--blue); }

    .pill { display: inline-block; padding: 3px 11px; border-radius: 20px; font-size: 12px; font-weight: 600; }
    .pill-activo    { background: var(--green-light); color: var(--green-dark); }
    .pill-pendiente { background: var(--amber-light); color: var(--amber-dark); }
    .pill-inactivo  { background: var(--gray-light);  color: var(--gray-dark);  }
    .pill-proximo   { background: var(--blue-light);  color: var(--blue-dark);  }
    .pill-encurso   { background: var(--green-light); color: var(--green-dark); }
    .pill-finalizado{ background: var(--gray-light);  color: var(--gray-dark);  }
    .pill-cat       { background: var(--blue-light);  color: var(--blue-dark);  }

    .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.45); z-index: 200; align-items: center; justify-content: center; }
    .modal-overlay.open { display: flex; }
    .modal-box { background: var(--surface); border-radius: 14px; padding: 28px; width: min(460px, 94vw); box-shadow: 0 20px 60px rgba(0,0,0,0.25); }
    .modal-title { font-size: 18px; font-weight: 600; margin-bottom: 20px; color: var(--text); }
    .form-group { margin-bottom: 14px; }
    .form-label { display: block; font-size: 12px; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; }
    .form-group input, .form-group select { width: 100%; padding: 10px 12px; font-size: 14px; font-family: 'Barlow', sans-serif; border: 1px solid var(--border); border-radius: 8px; background: #f8fafd; color: var(--text); outline: none; transition: border 0.15s; }
    .form-group input:focus, .form-group select:focus { border-color: var(--blue-mid); }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    .modal-footer { display: flex; gap: 10px; justify-content: flex-end; margin-top: 22px; }
    .btn-cancel { padding: 9px 20px; font-size: 14px; font-family: 'Barlow', sans-serif; background: transparent; border: 1px solid var(--border); border-radius: 8px; cursor: pointer; color: var(--text-muted); }
    .btn-cancel:hover { background: var(--gray-light); }
    .btn-save { padding: 9px 22px; font-size: 14px; font-weight: 600; font-family: 'Barlow', sans-serif; background: var(--blue); color: #fff; border: none; border-radius: 8px; cursor: pointer; }
    .btn-save:hover { background: var(--blue-mid); }

    .cal-nav { display: flex; align-items: center; gap: 12px; }
    .cal-month-title { font-family: 'Bebas Neue', cursive; font-size: 22px; letter-spacing: 2px; color: var(--blue-dark); }
    .btn-cal-nav { padding: 5px 13px; font-size: 16px; background: var(--blue-light); color: var(--blue-dark); border: 1px solid var(--border); border-radius: 7px; cursor: pointer; font-weight: 700; }
    .btn-cal-nav:hover { background: var(--blue-mid); color: #fff; }
    .cal-grid-days { display: grid; grid-template-columns: repeat(7, 1fr); gap: 6px; margin-bottom: 6px; }
    .cal-day-name { text-align: center; font-size: 12px; font-weight: 600; color: var(--text-muted); padding: 6px 0; text-transform: uppercase; letter-spacing: 0.5px; }
    .cal-grid { display: grid; grid-template-columns: repeat(7, 1fr); gap: 6px; }
    .cal-cell { min-height: 64px; padding: 6px 8px; border-radius: 8px; border: 1px solid var(--border); background: var(--surface); font-size: 13px; }
    .cal-cell.empty { background: transparent; border-color: transparent; }
    .cal-cell.today { border: 2px solid var(--blue-mid); }
    .cal-num { font-weight: 600; margin-bottom: 3px; color: var(--text); }
    .cal-num.today-num { color: var(--blue); }
    .cal-ev { font-size: 10px; font-weight: 600; background: var(--blue-light); color: var(--blue-dark); border-radius: 4px; padding: 2px 5px; margin-top: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .cal-ev.torneo { background: var(--amber-light); color: var(--amber-dark); }

    .empty-row { text-align: center; padding: 3rem 1rem; color: var(--text-muted); font-size: 14px; }
    .btn-del { padding: 4px 10px; font-size: 12px; font-family: 'Barlow', sans-serif; background: #FCEBEB; color: #A32D2D; border: 1px solid #F7C1C1; border-radius: 6px; cursor: pointer; }
    .btn-del:hover { background: #F09595; color: #fff; }

    /* ── Contacto ─────────────────────────────────── */
    .contact-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 20px; margin-bottom: 2rem; }
    .contact-card { background: var(--surface); border: 1px solid var(--border); border-radius: 14px; padding: 28px 24px; display: flex; flex-direction: column; align-items: center; gap: 14px; text-align: center; transition: box-shadow 0.2s; }
    .contact-card:hover { box-shadow: 0 6px 24px rgba(24,95,165,0.13); }
    .contact-icon { width: 58px; height: 58px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 26px; flex-shrink: 0; }
    .contact-icon.mail  { background: var(--blue-light); }
    .contact-icon.phone { background: var(--green-light); }
    .contact-icon.map   { background: var(--amber-light); }
    .contact-label { font-size: 12px; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; }
    .contact-value { font-size: 16px; font-weight: 600; color: var(--text); word-break: break-all; }
    .contact-link { display: inline-block; margin-top: 6px; padding: 8px 18px; border-radius: 8px; font-size: 13px; font-weight: 600; text-decoration: none; background: var(--blue); color: #fff; transition: background 0.15s; }
    .contact-link:hover { background: var(--blue-mid); }
    .contact-link.green { background: var(--green); }
    .contact-link.green:hover { background: #4a8a15; }
    .contact-map-wrapper { border-radius: 14px; overflow: hidden; border: 1px solid var(--border); box-shadow: 0 2px 12px rgba(4,44,83,0.08); }

    /* ── Módulo 5: Reportes / Email / Imprimir ──────────── */
    .mod5-section { margin-top: 2rem; }
    .mod5-title { font-family: 'Bebas Neue', cursive; font-size: 20px; letter-spacing: 2px; color: var(--blue-dark); margin-bottom: 1rem; display: flex; align-items: center; gap: 8px; }
    .mod5-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 18px; }
    .mod5-card { background: var(--surface); border: 1px solid var(--border); border-radius: 14px; padding: 24px 22px; display: flex; flex-direction: column; gap: 12px; transition: box-shadow 0.2s; }
    .mod5-card:hover { box-shadow: 0 6px 24px rgba(24,95,165,0.12); }
    .mod5-card-header { display: flex; align-items: center; gap: 10px; }
    .mod5-icon { width: 46px; height: 46px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0; }
    .mod5-icon.pdf   { background: #FEE2E2; }
    .mod5-icon.excel { background: var(--green-light); }
    .mod5-icon.email { background: var(--blue-light); }
    .mod5-icon.print { background: var(--gray-light); }
    .mod5-card-title { font-size: 15px; font-weight: 700; color: var(--text); }
    .mod5-card-desc  { font-size: 13px; color: var(--text-muted); line-height: 1.5; }
    .mod5-btn-row    { display: flex; gap: 8px; flex-wrap: wrap; margin-top: 4px; }
    .mod5-btn { padding: 9px 18px; font-size: 13px; font-weight: 600; font-family: 'Barlow', sans-serif; border: none; border-radius: 8px; cursor: pointer; transition: all 0.15s; }
    .mod5-btn.red   { background: #EF4444; color: #fff; }
    .mod5-btn.red:hover   { background: #DC2626; }
    .mod5-btn.green { background: var(--green); color: #fff; }
    .mod5-btn.green:hover { background: #4a8a15; }
    .mod5-btn.blue  { background: var(--blue); color: #fff; }
    .mod5-btn.blue:hover  { background: var(--blue-mid); }
    .mod5-btn.gray  { background: var(--gray); color: #fff; }
    .mod5-btn.gray:hover  { background: var(--gray-dark); }
    .mod5-select { padding: 9px 12px; font-size: 13px; font-family: 'Barlow', sans-serif; border: 1px solid var(--border); border-radius: 8px; background: #f8fafd; color: var(--text); outline: none; width: 100%; }
    .mod5-select:focus { border-color: var(--blue-mid); }
    /* Email form */
    .mod5-input { width: 100%; padding: 9px 12px; font-size: 13px; font-family: 'Barlow', sans-serif; border: 1px solid var(--border); border-radius: 8px; background: #f8fafd; color: var(--text); outline: none; transition: border 0.15s; }
    .mod5-input:focus { border-color: var(--blue-mid); }
    .mod5-textarea { width: 100%; padding: 9px 12px; font-size: 13px; font-family: 'Barlow', sans-serif; border: 1px solid var(--border); border-radius: 8px; background: #f8fafd; color: var(--text); outline: none; resize: vertical; min-height: 80px; transition: border 0.15s; }
    .mod5-textarea:focus { border-color: var(--blue-mid); }
    .mod5-label { font-size: 11px; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; display: block; }

    /* Estilos de impresión */
    @media print {
      header, nav, .carousel-wrapper, #sec-miembros, #sec-equipos, #sec-torneos, #sec-calendario,
      .mod5-section, .stats-grid, .modal-overlay, #toast,
      .btn-add, .btn-del, .card-header button { display: none !important; }
      body { background: #fff !important; }
      #sec-contacto { display: block !important; }
      .contact-grid, .contact-map-wrapper { display: none !important; }
      #print-area { display: block !important; }
    }
    #print-area { display: none; }

    /* ── Carrusel ─────────────────────────────────── */
    .carousel-wrapper {
      position: relative; overflow: hidden; border-radius: 16px;
      margin-bottom: 24px; box-shadow: 0 4px 24px rgba(4,44,83,0.18);
      max-height: 380px; background: #000;
    }
    .carousel-track {
      display: flex; transition: transform 0.45s cubic-bezier(.77,0,.18,1);
    }
    .carousel-slide {
      min-width: 100%; position: relative;
    }
    .carousel-slide img {
      width: 100%; height: 380px; object-fit: cover; display: block;
      filter: brightness(0.88);
    }
    .carousel-btn {
      position: absolute; top: 50%; transform: translateY(-50%);
      background: rgba(4,44,83,0.65); color: #fff;
      border: none; border-radius: 50%; width: 44px; height: 44px;
      font-size: 26px; line-height: 1; cursor: pointer;
      transition: background 0.2s; z-index: 10;
      display: flex; align-items: center; justify-content: center;
    }
    .carousel-btn:hover { background: var(--blue-mid); }
    .carousel-prev { left: 14px; }
    .carousel-next { right: 14px; }
    .carousel-dots {
      position: absolute; bottom: 14px; left: 50%; transform: translateX(-50%);
      display: flex; gap: 8px; z-index: 10;
    }
    .carousel-dot {
      width: 10px; height: 10px; border-radius: 50%;
      background: rgba(255,255,255,0.45); border: 2px solid #fff;
      cursor: pointer; transition: background 0.2s;
    }
    .carousel-dot.active { background: #fff; }

    /* Toast de notificación */
    #toast { position: fixed; bottom: 2rem; left: 50%; transform: translateX(-50%) translateY(20px); background: #1a3a5c; color: #fff; padding: 10px 24px; border-radius: 30px; font-size: 14px; font-weight: 600; opacity: 0; transition: all 0.3s; pointer-events: none; z-index: 9999; }
    #toast.show { opacity: 1; transform: translateX(-50%) translateY(0); }
    #toast.error { background: #8B1A1A; }
  </style>
</head>
<body>

  <header>
    <div class="logo-img">
      <img src="Jaguar real con corona y balón (1).png" alt="Snake Royale Logo">
    </div>
    <div>
      <div class="header-title">Snake Royale</div>
      <div class="header-sub">Club de Basquetbol — Sistema de Gestión</div>
    </div>
    <span class="header-badge">🏀 BASQUETBOL 2026</span>
  </header>

  <nav>
    <button class="nav-btn active" onclick="showSection('miembros', this)">👥 Miembros</button>
    <button class="nav-btn" onclick="showSection('equipos', this)">🏅 Equipos</button>
    <button class="nav-btn" onclick="showSection('torneos', this)">🏆 Torneos</button>
    <button class="nav-btn" onclick="showSection('calendario', this)">📅 Calendario</button>
    <button class="nav-btn" onclick="showSection('contacto', this)">📞 Contacto</button>
  </nav>

  <main>
    <!-- CARRUSEL DE FOTOS -->
    <div class="carousel-wrapper">
      <div class="carousel-track" id="carouselTrack">
        <div class="carousel-slide"><img src="hola1.png" alt="Snake Royale Foto 1"></div>
        <div class="carousel-slide"><img src="hola2.png" alt="Snake Royale Foto 2"></div>
        <div class="carousel-slide"><img src="hola3.png" alt="Snake Royale Foto 3"></div>
        <div class="carousel-slide"><img src="hola4.png" alt="Snake Royale Foto 4"></div>
        <div class="carousel-slide"><img src="Jaguar real con corona y balón (1).png" alt="Snake Royale Foto 5"></div>
      </div>
      <button class="carousel-btn carousel-prev" onclick="moveCarousel(-1)">&#8249;</button>
      <button class="carousel-btn carousel-next" onclick="moveCarousel(1)">&#8250;</button>
      <div class="carousel-dots" id="carouselDots"></div>
    </div>

    <!-- MIEMBROS -->
    <div id="sec-miembros" class="section visible">
      <div class="stats-grid">
        <div class="stat-card"><div class="stat-label">Total miembros</div><div class="stat-num" id="cnt-total">0</div></div>
        <div class="stat-card"><div class="stat-label">Activos</div><div class="stat-num" id="cnt-activos">0</div></div>
        <div class="stat-card"><div class="stat-label">Pendientes</div><div class="stat-num amber" id="cnt-pend">0</div></div>
        <div class="stat-card"><div class="stat-label">Inactivos</div><div class="stat-num gray" id="cnt-inac">0</div></div>
      </div>
      <div class="card">
        <div class="card-header">
          <span class="card-title">🏀 Registro de Miembros</span>
          <button class="btn-add" onclick="openModal('miembro')">+ Nuevo Miembro</button>
        </div>
        <table>
          <thead><tr><th>#</th><th>Nombre</th><th>Posición</th><th>No.</th><th>Equipo</th><th>Estado</th><th>Ingreso</th><th>Acción</th></tr></thead>
          <tbody id="tbody-miembros"></tbody>
        </table>
      </div>
    </div>

    <!-- EQUIPOS -->
    <div id="sec-equipos" class="section">
      <div class="card">
        <div class="card-header">
          <span class="card-title">🏅 Equipos del Club</span>
          <button class="btn-add" onclick="openModal('equipo')">+ Nuevo Equipo</button>
        </div>
        <table>
          <thead><tr><th>#</th><th>Nombre del equipo</th><th>Categoría</th><th>Entrenador</th><th>Jugadores</th><th>Acción</th></tr></thead>
          <tbody id="tbody-equipos"></tbody>
        </table>
      </div>
    </div>

    <!-- TORNEOS -->
    <div id="sec-torneos" class="section">
      <div class="card">
        <div class="card-header">
          <span class="card-title">🏆 Torneos de Basquetbol</span>
          <button class="btn-add" onclick="openModal('torneo')">+ Nuevo Torneo</button>
        </div>
        <table>
          <thead><tr><th>#</th><th>Torneo</th><th>Categoría</th><th>Fecha</th><th>Estado</th><th>Equipos</th><th>Acción</th></tr></thead>
          <tbody id="tbody-torneos"></tbody>
        </table>
      </div>
    </div>

    <!-- CALENDARIO -->
    <div id="sec-calendario" class="section">
      <div class="card" style="padding: 1.5rem;">
        <div class="card-header" style="padding: 0 0 16px; border-bottom: 1px solid var(--border); margin-bottom: 16px;">
          <div class="cal-nav">
            <button class="btn-cal-nav" onclick="cambiarMes(-1)">&#8249;</button>
            <span class="cal-month-title" id="cal-titulo">Marzo 2026</span>
            <button class="btn-cal-nav" onclick="cambiarMes(1)">&#8250;</button>
          </div>
          <button class="btn-add" onclick="openModal('actividad')">+ Nueva Actividad</button>
        </div>
        <div class="cal-grid-days" id="cal-names"></div>
        <div class="cal-grid" id="cal-cells"></div>
      </div>
    </div>

    <!-- CONTACTO -->
    <div id="sec-contacto" class="section">
      <div class="stats-grid" style="grid-template-columns: 1fr; margin-bottom: 0.5rem;">
        <div class="stat-card" style="text-align:center; padding: 18px;">
          <div class="stat-label">¿Quieres unirte o tienes alguna pregunta?</div>
          <div style="font-size:13px; color:var(--text-muted); margin-top:4px;">Contáctanos por cualquiera de estos medios</div>
        </div>
      </div>

      <div class="contact-grid" style="margin-top:1.5rem;">

        <!-- Correo -->
        <div class="contact-card">
          <div class="contact-icon mail">📧</div>
          <div>
            <div class="contact-label">Correo electrónico</div>
            <div class="contact-value">snakeroyale08@gmail.com</div>
          </div>
          <a class="contact-link" href="mailto:snakeroyale08@gmail.com">Enviar correo</a>
        </div>

        <!-- Teléfono -->
        <div class="contact-card">
          <div class="contact-icon phone">📱</div>
          <div>
            <div class="contact-label">Número de contacto</div>
            <div class="contact-value">961 145 7852</div>
          </div>
          <a class="contact-link green" href="tel:9611457852">Llamar ahora</a>
        </div>

        <!-- Ubicación -->
        <div class="contact-card">
          <div class="contact-icon map">📍</div>
          <div>
            <div class="contact-label">Ubicación</div>
            <div class="contact-value">DEPORTES-GAMBOA-TUXTLA</div>
          </div>
          <a class="contact-link" href="https://www.google.com/maps/@16.75234291638283,-93.11641977435588,3a,75y,352.02h,81.89t/data=!3m6!1e1!3m4!1sYpPuUNBp-p7j04sKPdaesA!2e0!7i16384!8i8192" target="_blank" rel="noopener noreferrer">Ver en Street View</a>
        </div>

      </div>

      <!-- Street View de la ubicación -->
      <div class="contact-map-wrapper" style="margin-top:1.5rem;">
        <iframe
          src="https://www.google.com/maps/embed?pb=!4v1776784889117!6m8!1m7!1sYpPuUNBp-p7j04sKPdaesA!2m2!1d16.75234291638283!2d-93.11641977435588!3f352.0216408139001!4f-8.10914136490993!5f0.4000000000000002"
          width="100%"
          height="420"
          style="border:0; display:block;"
          allowfullscreen=""
          loading="lazy"
          referrerpolicy="no-referrer-when-downgrade">
        </iframe>
      </div>

      <!-- ═══ MÓDULO 5: Reportes, Email, Imprimir ═══ -->
      <div class="mod5-section">
        <div class="mod5-title">📊EXPORTAR Y ENVIAR CORREO DE DUDA </div>
        <div class="mod5-grid">

          <!-- Exportar PDF -->
          <div class="mod5-card">
            <div class="mod5-card-header">
              <div class="mod5-icon pdf">📄</div>
              <div class="mod5-card-title">Exportar a PDF</div>
            </div>
            <div class="mod5-card-desc">Genera un reporte en PDF con la información actual del módulo seleccionado. Los reportes funcionan como medio de información oficial del club.</div>
            <label class="mod5-label">Seleccionar plantilla</label>
            <select class="mod5-select" id="pdf-seccion">
              <option value="miembros">👥 Miembros</option>
              <option value="equipos">🏅 Equipos</option>
              <option value="torneos">🏆 Torneos</option>
            </select>
            <div class="mod5-btn-row">
              <button class="mod5-btn red" onclick="exportarPDF()">⬇ Descargar PDF</button>
            </div>
          </div>

          <!-- Exportar Excel -->
          <div class="mod5-card">
            <div class="mod5-card-header">
              <div class="mod5-icon excel">📊</div>
              <div class="mod5-card-title">Exportar a Excel</div>
            </div>
            <div class="mod5-card-desc">Descarga un archivo .csv / Excel con todos los registros del módulo seleccionado para análisis externo o respaldo.</div>
            <label class="mod5-label">Seleccionar plantilla</label>
            <select class="mod5-select" id="excel-seccion">
              <option value="miembros">👥 Miembros</option>
              <option value="equipos">🏅 Equipos</option>
              <option value="torneos">🏆 Torneos</option>
            </select>
            <div class="mod5-btn-row">
              <button class="mod5-btn green" onclick="exportarExcel()">⬇ Descargar Excel</button>
            </div>
          </div>

          <!-- Envío por correo electrónico -->
          <div class="mod5-card">
            <div class="mod5-card-header">
              <div class="mod5-icon email">📧</div>
              <div class="mod5-card-title">Enviar por Correo</div>
            </div>
            <div class="mod5-card-desc">Redacta y envía un correo electrónico desde el sistema. Disponible incluso sin conexión a la red interna.</div>
            <label class="mod5-label">Destinatario</label>
            <input class="mod5-input" type="email" id="email-dest" placeholder="correo@ejemplo.com">
            <label class="mod5-label" style="margin-top:8px;">Asunto</label>
            <input class="mod5-input" id="email-asunto" placeholder="Ej. Reporte mensual Snake Royale">
            <label class="mod5-label" style="margin-top:8px;">Mensaje</label>
            <textarea class="mod5-textarea" id="email-msg" placeholder="Escribe tu mensaje aquí..."></textarea>
            <div class="mod5-btn-row">
              <button class="mod5-btn blue" onclick="enviarCorreo()">✉ Enviar correo</button>
            </div>
          </div>

          <!-- Imprimir plantilla -->
          <div class="mod5-card">
            <div class="mod5-card-header">
              <div class="mod5-icon print">🖨️</div>
              <div class="mod5-card-title">Imprimir Plantilla</div>
            </div>
            <div class="mod5-card-desc">Imprime toda la plantilla actual del módulo seleccionado. El documento se formatea automáticamente para impresión.</div>
            <label class="mod5-label">Seleccionar plantilla</label>
            <select class="mod5-select" id="print-seccion">
              <option value="miembros">👥 Miembros</option>
              <option value="equipos">🏅 Equipos</option>
              <option value="torneos">🏆 Torneos</option>
            </select>
            <div class="mod5-btn-row">
              <button class="mod5-btn gray" onclick="imprimirPlantilla()">🖨 Imprimir ahora</button>
            </div>
          </div>

        </div><!-- /mod5-grid -->
      </div><!-- /mod5-section -->

      <!-- Área oculta usada para impresión -->
      <div id="print-area"></div>

    </div>

  </main>

  <!-- MODAL -->
  <div class="modal-overlay" id="modal-overlay">
    <div class="modal-box">
      <div class="modal-title" id="modal-title">Agregar</div>
      <div id="modal-body"></div>
      <div class="modal-footer">
        <button class="btn-cancel" onclick="closeModal()">Cancelar</button>
        <button class="btn-save" onclick="saveModal()">Guardar</button>
      </div>
    </div>
  </div>

  <!-- Toast -->
  <div id="toast"></div>

<script>
  // ── Configuración ─────────────────────────────────────────
  const API = 'api.php';   // ← ruta a tu api.php

  // Caché local
  let db = { miembros: [], equipos: [], torneos: [], actividades: [] };
  let modalType = '';

  // Estado del calendario
  const hoyReal = new Date();
  let calAnio = hoyReal.getFullYear();
  let calMes  = hoyReal.getMonth(); // 0-indexado

  const MESES = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];

  const estPill = { 'Activo':'pill-activo', 'Pendiente':'pill-pendiente', 'Inactivo':'pill-inactivo' };
  const torPill = { 'Próximo':'pill-proximo', 'En curso':'pill-encurso', 'Finalizado':'pill-finalizado' };

  // ── Toast ─────────────────────────────────────────────────
  function showToast(msg, esError = false) {
    const t = document.getElementById('toast');
    t.textContent = msg;
    t.className = 'show' + (esError ? ' error' : '');
    clearTimeout(t._timer);
    t._timer = setTimeout(() => t.className = '', 2800);
  }

  // ── Utilidades fetch ──────────────────────────────────────
  async function apiGet(tabla) {
    try {
      const r = await fetch(`${API}?tabla=${tabla}&accion=listar`);
      if (!r.ok) throw new Error('HTTP ' + r.status);
      const j = await r.json();
      return j.data || [];
    } catch(e) {
      showToast('Error al cargar ' + tabla + ': ' + e.message, true);
      return [];
    }
  }

  async function apiPost(tabla, datos) {
    try {
      const r = await fetch(`${API}?tabla=${tabla}&accion=guardar`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(datos)
      });
      if (!r.ok) throw new Error('HTTP ' + r.status);
      return await r.json();
    } catch(e) {
      return { ok: false, msg: 'Error de red: ' + e.message };
    }
  }

  // CORREGIDO: usa método DELETE como requiere la API
  async function apiDel(tabla, id) {
    try {
      const r = await fetch(`${API}?tabla=${tabla}&accion=eliminar&id=${encodeURIComponent(id)}`, {
        method: 'DELETE'
      });
      if (!r.ok) throw new Error('HTTP ' + r.status);
      return await r.json();
    } catch(e) {
      return { ok: false, msg: 'Error de red: ' + e.message };
    }
  }

  // ── Navegación ────────────────────────────────────────────
  function showSection(sec, btn) {
    document.querySelectorAll('.section').forEach(s => s.classList.remove('visible'));
    document.getElementById('sec-' + sec).classList.add('visible');
    document.querySelectorAll('.nav-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    if (sec === 'miembros')   loadMiembros();
    if (sec === 'equipos')    loadEquipos();
    if (sec === 'torneos')    loadTorneos();
    if (sec === 'calendario') loadCalendario();
    if (sec === 'contacto')   { /* sección estática, sin carga */ }
  }

  // ── MIEMBROS ──────────────────────────────────────────────
  async function loadMiembros() {
    db.miembros = await apiGet('miembros');
    renderMiembros();
  }

  function renderMiembros() {
    document.getElementById('cnt-total').textContent   = db.miembros.length;
    document.getElementById('cnt-activos').textContent = db.miembros.filter(m => m.ESTADO === 'Activo').length;
    document.getElementById('cnt-pend').textContent    = db.miembros.filter(m => m.ESTADO === 'Pendiente').length;
    document.getElementById('cnt-inac').textContent    = db.miembros.filter(m => m.ESTADO === 'Inactivo').length;
    const tb = document.getElementById('tbody-miembros');
    if (!db.miembros.length) {
      tb.innerHTML = '<tr><td colspan="8" class="empty-row">No hay miembros registrados.</td></tr>';
      return;
    }
    tb.innerHTML = db.miembros.map((m, i) => `
      <tr>
        <td class="td-id">${i + 1}</td>
        <td class="td-bold">${escHtml(m.NOMBRE)}</td>
        <td><span class="pill pill-cat">${escHtml(m.POCISION)}</span></td>
        <td class="td-num">#${escHtml(m['NO°'])}</td>
        <td>${escHtml(m.EQUIPO)}</td>
        <td><span class="pill ${estPill[m.ESTADO] || 'pill-inactivo'}">${escHtml(m.ESTADO)}</span></td>
        <td>${escHtml(m.INGRESO)}</td>
        <td><button class="btn-del" onclick="eliminarMiembro(${JSON.stringify(m.NOMBRE)})">Eliminar</button></td>
      </tr>`).join('');
  }

  async function eliminarMiembro(nombre) {
    if (!confirm('¿Eliminar a ' + nombre + '?')) return;
    const j = await apiDel('miembros', nombre);
    if (j.ok) { showToast('Miembro eliminado'); loadMiembros(); }
    else showToast(j.msg, true);
  }

  // ── EQUIPOS ───────────────────────────────────────────────
  async function loadEquipos() {
    db.equipos = await apiGet('equipos');
    renderEquipos();
  }

  function renderEquipos() {
    const tb = document.getElementById('tbody-equipos');
    if (!db.equipos.length) {
      tb.innerHTML = '<tr><td colspan="6" class="empty-row">No hay equipos registrados.</td></tr>';
      return;
    }
    tb.innerHTML = db.equipos.map(e => `
      <tr>
        <td class="td-id">${e.id}</td>
        <td class="td-bold">${escHtml(e.nombre)}</td>
        <td><span class="pill pill-cat">${escHtml(e.categoria)}</span></td>
        <td>${escHtml(e.entrenador)}</td>
        <td>${e.jugadores} jugadores</td>
        <td><button class="btn-del" onclick="eliminarRegistro('equipos', ${e.id})">Eliminar</button></td>
      </tr>`).join('');
  }

  // ── TORNEOS ───────────────────────────────────────────────
  async function loadTorneos() {
    db.torneos = await apiGet('torneos');
    renderTorneos();
  }

  function renderTorneos() {
    const tb = document.getElementById('tbody-torneos');
    if (!db.torneos.length) {
      tb.innerHTML = '<tr><td colspan="7" class="empty-row">No hay torneos registrados.</td></tr>';
      return;
    }
    tb.innerHTML = db.torneos.map(t => `
      <tr>
        <td class="td-id">${t.id}</td>
        <td class="td-bold">${escHtml(t.torneo)}</td>
        <td><span class="pill pill-cat">${escHtml(t.categoria)}</span></td>
        <td>${escHtml(t.fecha)}</td>
        <td><span class="pill ${torPill[t.estado] || 'pill-finalizado'}">${escHtml(t.estado)}</span></td>
        <td>${t.equipos} equipos</td>
        <td><button class="btn-del" onclick="eliminarRegistro('torneos', ${t.id})">Eliminar</button></td>
      </tr>`).join('');
  }

  async function eliminarRegistro(tabla, id) {
    if (!confirm('¿Eliminar este registro?')) return;
    const j = await apiDel(tabla, id);
    if (j.ok) {
      showToast('Registro eliminado');
      if (tabla === 'equipos')     loadEquipos();
      if (tabla === 'torneos')     loadTorneos();
      if (tabla === 'actividades') loadCalendario();
    } else showToast(j.msg, true);
  }

  // ── CALENDARIO ────────────────────────────────────────────
  async function loadCalendario() {
    db.actividades = await apiGet('actividades');
    renderCalendario();
  }

  function cambiarMes(delta) {
    calMes += delta;
    if (calMes > 11) { calMes = 0; calAnio++; }
    if (calMes < 0)  { calMes = 11; calAnio--; }
    renderCalendario();
  }

  function renderCalendario() {
    // Título dinámico
    document.getElementById('cal-titulo').textContent = MESES[calMes] + ' ' + calAnio;

    // Días de la semana
    const dias = ['Dom','Lun','Mar','Mié','Jue','Vie','Sáb'];
    document.getElementById('cal-names').innerHTML = dias.map(d => `<div class="cal-day-name">${d}</div>`).join('');

    // Día de hoy (solo resaltar si es el mes/año actual)
    const esHoyMismoMes = (hoyReal.getFullYear() === calAnio && hoyReal.getMonth() === calMes);
    const diaHoy = esHoyMismoMes ? hoyReal.getDate() : -1;

    // Primer día de la semana del mes
    const primerDia = new Date(calAnio, calMes, 1).getDay(); // 0=Dom
    const diasEnMes = new Date(calAnio, calMes + 1, 0).getDate();

    let cells = '';

    // Celdas vacías iniciales (offset)
    for (let i = 0; i < primerDia; i++) {
      cells += `<div class="cal-cell empty"></div>`;
    }

    // Celdas de cada día
    for (let d = 1; d <= diasEnMes; d++) {
      const evs = db.actividades.filter(a => parseInt(a.dia) === d);
      const esHoy = d === diaHoy;
      cells += `<div class="cal-cell${esHoy ? ' today' : ''}">
        <div class="cal-num${esHoy ? ' today-num' : ''}">${d}</div>
        ${evs.map(e => `<div class="cal-ev${e.tipo === 'torneo' ? ' torneo' : ''}">${escHtml(e.nombre)}</div>`).join('')}
      </div>`;
    }

    document.getElementById('cal-cells').innerHTML = cells;
  }

  // ── MODAL ─────────────────────────────────────────────────
  function openModal(tipo) {
    modalType = tipo;
    const titulos = { miembro: 'Nuevo Miembro', equipo: 'Nuevo Equipo', torneo: 'Nuevo Torneo', actividad: 'Nueva Actividad' };
    document.getElementById('modal-title').textContent = titulos[tipo];

    // CORREGIDO: usa nombre o NOMBRE según el origen del dato
    const eqOpts = db.equipos.map(e => `<option>${escHtml(e.nombre || e.NOMBRE)}</option>`).join('');

    // Fecha de hoy para el campo ingreso
    const hoyStr = hoyReal.toISOString().split('T')[0];

    const forms = {
      miembro: `
        <div class="form-row">
          <div class="form-group"><label class="form-label">Nombre completo</label><input id="f-nombre" placeholder="Ej. Ana López"></div>
          <div class="form-group"><label class="form-label">Número de camiseta</label><input type="number" id="f-num" placeholder="Ej. 23" min="0" max="99"></div>
        </div>
        <div class="form-row">
          <div class="form-group"><label class="form-label">Posición</label>
            <select id="f-pos"><option>Base</option><option>Escolta</option><option>Alero</option><option>Ala-Pivot</option><option>Pivot</option></select></div>
          <div class="form-group"><label class="form-label">Equipo asignado</label>
            <select id="f-equipo">${eqOpts || '<option>Sin equipos</option>'}</select></div>
        </div>
        <div class="form-row">
          <div class="form-group"><label class="form-label">Estado</label>
            <select id="f-estado"><option>Activo</option><option>Pendiente</option><option>Inactivo</option></select></div>
          <div class="form-group"><label class="form-label">Fecha de ingreso</label>
            <input type="date" id="f-ingreso" value="${hoyStr}"></div>
        </div>`,

      equipo: `
        <div class="form-group"><label class="form-label">Nombre del equipo</label>
          <input id="f-eq-nombre" placeholder="Ej. Cobras BB"></div>
        <div class="form-row">
          <div class="form-group"><label class="form-label">Categoría</label>
            <select id="f-eq-cat"><option>Varonil</option><option>Femenil</option><option>Mixto</option><option>Juvenil</option><option>Infantil</option></select></div>
          <div class="form-group"><label class="form-label">No. jugadores</label>
            <input type="number" id="f-eq-jug" value="10" min="1"></div>
        </div>
        <div class="form-group"><label class="form-label">Entrenador</label>
          <input id="f-eq-ent" placeholder="Nombre del entrenador"></div>`,

      torneo: `
        <div class="form-group"><label class="form-label">Nombre del torneo</label>
          <input id="f-tor-nombre" placeholder="Ej. Copa Snake Verano"></div>
        <div class="form-row">
          <div class="form-group"><label class="form-label">Categoría</label>
            <select id="f-tor-cat"><option>Varonil</option><option>Femenil</option><option>Mixto</option><option>Juvenil</option><option>Infantil</option></select></div>
          <div class="form-group"><label class="form-label">Equipos participantes</label>
            <input type="number" id="f-tor-eq" value="4" min="2"></div>
        </div>
        <div class="form-row">
          <div class="form-group"><label class="form-label">Fecha</label>
            <input type="date" id="f-tor-fecha" value="${hoyStr}"></div>
          <div class="form-group"><label class="form-label">Estado</label>
            <select id="f-tor-est"><option>Próximo</option><option>En curso</option><option>Finalizado</option></select></div>
        </div>`,

      actividad: `
        <div class="form-group"><label class="form-label">Nombre de la actividad</label>
          <input id="f-act-nombre" placeholder="Ej. Práctica general"></div>
        <div class="form-row">
          <div class="form-group"><label class="form-label">Día del mes (1-31)</label>
            <input type="number" id="f-act-dia" value="${hoyReal.getDate()}" min="1" max="31"></div>
          <div class="form-group"><label class="form-label">Tipo</label>
            <select id="f-act-tipo"><option value="act">Actividad</option><option value="torneo">Torneo</option></select></div>
        </div>`
    };

    document.getElementById('modal-body').innerHTML = forms[tipo];
    document.getElementById('modal-overlay').classList.add('open');
  }

  function closeModal() {
    document.getElementById('modal-overlay').classList.remove('open');
  }

  async function saveModal() {
    if (modalType === 'miembro') {
      const nombre = document.getElementById('f-nombre').value.trim();
      if (!nombre) { showToast('El nombre es obligatorio.', true); return; }
      const j = await apiPost('miembros', {
        nombre,
        posicion: document.getElementById('f-pos').value,
        numero:   document.getElementById('f-num').value || '0',
        equipo:   document.getElementById('f-equipo').value,
        estado:   document.getElementById('f-estado').value,
        ingreso:  document.getElementById('f-ingreso').value
      });
      if (j.ok) { closeModal(); showToast('Miembro guardado ✓'); loadMiembros(); }
      else showToast(j.msg, true);

    } else if (modalType === 'equipo') {
      const nombre = document.getElementById('f-eq-nombre').value.trim();
      if (!nombre) { showToast('El nombre es obligatorio.', true); return; }
      const j = await apiPost('equipos', {
        nombre,
        categoria:  document.getElementById('f-eq-cat').value,
        entrenador: document.getElementById('f-eq-ent').value || 'Por asignar',
        jugadores:  parseInt(document.getElementById('f-eq-jug').value) || 0
      });
      if (j.ok) { closeModal(); showToast('Equipo guardado ✓'); loadEquipos(); }
      else showToast(j.msg, true);

    } else if (modalType === 'torneo') {
      const torneo = document.getElementById('f-tor-nombre').value.trim();
      if (!torneo) { showToast('El nombre es obligatorio.', true); return; }
      const j = await apiPost('torneos', {
        torneo,
        categoria: document.getElementById('f-tor-cat').value,
        fecha:     document.getElementById('f-tor-fecha').value,
        estado:    document.getElementById('f-tor-est').value,
        equipos:   parseInt(document.getElementById('f-tor-eq').value) || 2
      });
      if (j.ok) { closeModal(); showToast('Torneo guardado ✓'); loadTorneos(); }
      else showToast(j.msg, true);

    } else if (modalType === 'actividad') {
      const nombre = document.getElementById('f-act-nombre').value.trim();
      if (!nombre) { showToast('El nombre es obligatorio.', true); return; }
      const j = await apiPost('actividades', {
        dia:    parseInt(document.getElementById('f-act-dia').value),
        nombre,
        tipo:   document.getElementById('f-act-tipo').value
      });
      if (j.ok) { closeModal(); showToast('Actividad guardada ✓'); loadCalendario(); }
      else showToast(j.msg, true);
    }
  }

  // Cerrar modal al hacer click fuera
  document.getElementById('modal-overlay').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
  });

  // ── Utilidad: escapar HTML para evitar XSS ────────────────
  function escHtml(str) {
    if (str == null) return '';
    return String(str)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;')
      .replace(/'/g, '&#39;');
  }

  // ── Carrusel ──────────────────────────────────────────────
  (function() {
    const total = 4;
    let current = 0;
    let autoTimer;

    const track = document.getElementById('carouselTrack');
    const dotsEl = document.getElementById('carouselDots');

    // Build dots
    for (let i = 0; i < total; i++) {
      const d = document.createElement('div');
      d.className = 'carousel-dot' + (i === 0 ? ' active' : '');
      d.onclick = () => goTo(i);
      dotsEl.appendChild(d);
    }

    function updateDots() {
      dotsEl.querySelectorAll('.carousel-dot').forEach((d, i) => {
        d.classList.toggle('active', i === current);
      });
    }

    function goTo(idx) {
      current = (idx + total) % total;
      track.style.transform = `translateX(-${current * 100}%)`;
      updateDots();
      restartAuto();
    }

    window.moveCarousel = function(dir) { goTo(current + dir); };

    function restartAuto() {
      clearInterval(autoTimer);
      autoTimer = setInterval(() => goTo(current + 1), 4000);
    }

    restartAuto();
  })();

  // ══════════════════════════════════════════════════════════
  //  MÓDULO 5 — Reportes, Exportación, Email, Impresión
  // ══════════════════════════════════════════════════════════

  // ── Helpers de tabla ──────────────────────────────────────
  function buildTableHTML(seccion) {
    const ahora = new Date().toLocaleString('es-MX');
    let headers = [], rows = [], titulo = '';

    if (seccion === 'miembros') {
      titulo = '👥 Reporte de Miembros';
      headers = ['#','Nombre','Posición','No.','Equipo','Estado','Ingreso'];
      rows = db.miembros.map((m, i) => [
        i + 1, m.NOMBRE, m.POCISION, m['NO°'], m.EQUIPO, m.ESTADO, m.INGRESO
      ]);
    } else if (seccion === 'equipos') {
      titulo = '🏅 Reporte de Equipos';
      headers = ['#','Nombre','Categoría','Entrenador','Jugadores'];
      rows = db.equipos.map((e, i) => [
        i + 1, e.nombre, e.categoria, e.entrenador, e.jugadores
      ]);
    } else if (seccion === 'torneos') {
      titulo = '🏆 Reporte de Torneos';
      headers = ['#','Torneo','Categoría','Fecha','Estado','Equipos'];
      rows = db.torneos.map((t, i) => [
        i + 1, t.torneo, t.categoria, t.fecha, t.estado, t.equipos
      ]);
    }

    const ths = headers.map(h => `<th style="background:#0C447C;color:#fff;padding:10px 14px;text-align:left;font-size:12px;letter-spacing:0.5px;text-transform:uppercase;">${h}</th>`).join('');
    const trs = rows.map((r, ri) => {
      const bg = ri % 2 === 0 ? '#f0f5fb' : '#ffffff';
      const tds = r.map(v => `<td style="padding:9px 14px;border-bottom:1px solid #dde8f3;font-size:13px;">${escHtml(String(v ?? ''))}</td>`).join('');
      return `<tr style="background:${bg};">${tds}</tr>`;
    }).join('');

    return { titulo, ahora, ths, trs, headers, rows };
  }

  // ── Exportar PDF (via ventana de impresión con estilos print) ──
  function exportarPDF() {
    const sec = document.getElementById('pdf-seccion').value;
    const { titulo, ahora, ths, trs } = buildTableHTML(sec);
    if (!trs) { showToast('No hay datos para exportar.', true); return; }

    const win = window.open('', '_blank');
    win.document.write(`<!DOCTYPE html><html lang="es"><head>
      <meta charset="UTF-8">
      <title>${titulo} — Snake Royale</title>
      <style>
        body{font-family:Arial,sans-serif;margin:30px;color:#0d1b2a;}
        h1{font-size:22px;color:#0C447C;border-bottom:3px solid #0C447C;padding-bottom:8px;}
        .meta{font-size:12px;color:#5F5E5A;margin-bottom:18px;}
        table{width:100%;border-collapse:collapse;font-size:13px;}
        th{background:#0C447C;color:#fff;padding:10px 14px;text-align:left;}
        td{padding:9px 14px;border-bottom:1px solid #dde8f3;}
        tr:nth-child(even)td{background:#f0f5fb;}
        .footer{margin-top:20px;font-size:11px;color:#999;text-align:right;}
        @media print{body{margin:15px;}}
      </style>
    </head><body>
      <h1>Snake Royale — ${titulo}</h1>
      <div class="meta">Generado el ${ahora} | Club de Basquetbol Snake Royale</div>
      <table><thead><tr>${ths}</tr></thead><tbody>${trs}</tbody></table>
      <div class="footer">Snake Royale © ${new Date().getFullYear()} — snakeroyale08@gmail.com</div>
      <script>window.onload=()=>{window.print();window.onafterprint=()=>window.close();}<\/script>
    </body></html>`);
    win.document.close();
    showToast('PDF generado — se abrió la ventana de impresión ✓');
  }

  // ── Exportar Excel (CSV con BOM para compatibilidad) ──────
  function exportarExcel() {
    const sec = document.getElementById('excel-seccion').value;
    const { titulo, headers, rows } = buildTableHTML(sec);
    if (!rows.length) { showToast('No hay datos para exportar.', true); return; }

    const BOM = '\uFEFF';
    const csvRows = [headers.join(',')].concat(
      rows.map(r => r.map(v => `"${String(v ?? '').replace(/"/g, '""')}"`).join(','))
    );
    const blob = new Blob([BOM + csvRows.join('\r\n')], { type: 'text/csv;charset=utf-8;' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `SnakeRoyale_${sec}_${new Date().toISOString().slice(0,10)}.csv`;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
    showToast('Excel (CSV) descargado ✓');
  }

  // ── Enviar correo (abre cliente de correo del sistema) ────
  function enviarCorreo() {
    const dest   = document.getElementById('email-dest').value.trim();
    const asunto = document.getElementById('email-asunto').value.trim();
    const msg    = document.getElementById('email-msg').value.trim();

    if (!dest) { showToast('Ingresa un destinatario.', true); return; }
    if (!asunto) { showToast('Escribe un asunto.', true); return; }

    const mailto = `mailto:${encodeURIComponent(dest)}` +
      `?subject=${encodeURIComponent(asunto)}` +
      `&body=${encodeURIComponent(msg)}`;

    window.location.href = mailto;
    showToast('Abriendo cliente de correo ✓');
  }

  // ── Imprimir plantilla actual ─────────────────────────────
  function imprimirPlantilla() {
    const sec = document.getElementById('print-seccion').value;
    const { titulo, ahora, ths, trs } = buildTableHTML(sec);
    if (!trs) { showToast('No hay datos para imprimir.', true); return; }

    const area = document.getElementById('print-area');
    area.innerHTML = `
      <div style="font-family:Arial,sans-serif;padding:20px;">
        <h1 style="font-size:22px;color:#0C447C;border-bottom:3px solid #0C447C;padding-bottom:8px;">Snake Royale — ${titulo}</h1>
        <p style="font-size:12px;color:#5F5E5A;margin-bottom:18px;">Generado el ${ahora} | Club de Basquetbol Snake Royale</p>
        <table style="width:100%;border-collapse:collapse;font-size:13px;">
          <thead><tr>${ths}</tr></thead>
          <tbody>${trs}</tbody>
        </table>
        <p style="margin-top:20px;font-size:11px;color:#999;text-align:right;">Snake Royale © ${new Date().getFullYear()} — snakeroyale08@gmail.com</p>
      </div>`;

    // Oculta todo excepto el área de impresión y dispara el diálogo
    const style = document.createElement('style');
    style.id = 'print-override';
    style.innerHTML = '@media print { body > *:not(#print-area){display:none!important;} #print-area{display:block!important;} }';
    document.head.appendChild(style);
    window.print();
    setTimeout(() => {
      document.getElementById('print-override')?.remove();
      area.innerHTML = '';
    }, 1000);
    showToast('Enviando a impresora ✓');
  }

  // ── Carga inicial ─────────────────────────────────────────
  // Cargamos equipos en segundo plano para que estén disponibles al abrir el modal de miembro
  // Precarga todos los módulos para que los reportes funcionen desde Contacto
  loadEquipos();
  loadMiembros();
  loadTorneos();
</script>
</body>
</html>
