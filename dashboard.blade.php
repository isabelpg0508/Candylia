
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Star Dynasty – Panel Admin</title>
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
  <style>
    :root {
      --gold:        #c9a84c;
      --gold-light:  #1e1a0e;
      --gold-bright: #e8c96a;
      --bg:          #0c0e13;
      --surface:     #13161e;
      --surface-2:   #1a1e28;
      --border:      #252a38;
      --border-gold: #2e2510;
      --text-head:   #e2c97e;
      --text-main:   #c8ccd8;
      --text-muted:  #525870;
      --mint:        #34d399;
      --mint-dark:   #059669;
      --mint-bg:     #021a0e;
      --amber:       #fbbf24;
      --amber-bg:    #1a1400;
      --red:         #f87171;
      --red-bg:      #1c0606;
      --sidebar-w:   230px;
      --radius:      8px;
      --shadow:      0 4px 24px rgba(0,0,0,0.5);
      --t:           0.25s ease;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'DM Sans', sans-serif;
      background: var(--bg);
      background-image:
        radial-gradient(ellipse at 15% 0%, rgba(201,168,76,0.06) 0%, transparent 45%),
        radial-gradient(ellipse at 85% 100%, rgba(52,211,153,0.03) 0%, transparent 45%);
      color: var(--text-main);
      min-height: 100vh;
      display: flex;
    }
    a { text-decoration: none; color: inherit; }

    /* ── Sidebar ── */
    .sidebar {
      width: var(--sidebar-w);
      min-height: 100vh;
      background: var(--surface);
      border-right: 1px solid var(--border);
      display: flex;
      flex-direction: column;
      position: fixed;
      top: 0; left: 0; bottom: 0;
    }

    .sidebar-logo {
      padding: 1.4rem 1.3rem;
      border-bottom: 1px solid var(--border);
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .logo-icon { font-size: 1.3rem; color: var(--gold-bright); }
    .logo-name {
      font-family: 'Cinzel', serif;
      font-size: 0.92rem;
      font-weight: 700;
      color: var(--gold-bright);
      letter-spacing: 2px;
      text-transform: uppercase;
    }
    .logo-sub {
      font-size: 0.6rem;
      color: var(--text-muted);
      letter-spacing: 1.2px;
      text-transform: uppercase;
      margin-top: 2px;
    }

    .nav-section {
      padding: 1.1rem 1rem 0.3rem;
      font-size: 0.6rem;
      font-weight: 600;
      color: var(--text-muted);
      letter-spacing: 1.5px;
      text-transform: uppercase;
    }

    .nav-item {
      display: flex;
      align-items: center;
      gap: 9px;
      padding: 0.58rem 1.1rem;
      margin: 2px 0.5rem;
      border-radius: var(--radius);
      font-size: 0.86rem;
      font-weight: 500;
      color: var(--text-muted);
      transition: all var(--t);
      position: relative;
    }

    .nav-item:hover { background: var(--gold-light); color: var(--gold-bright); }

    .nav-item.active {
      background: var(--gold-light);
      color: var(--gold-bright);
    }

    .nav-item.active::before {
      content: '';
      position: absolute;
      left: -0.5rem; top: 25%; bottom: 25%;
      width: 3px;
      background: var(--gold-bright);
      border-radius: 0 4px 4px 0;
    }

    .nav-badge {
      margin-left: auto;
      background: var(--gold);
      color: #0c0e13;
      font-size: 0.62rem;
      font-weight: 700;
      padding: 1px 6px;
      border-radius: 20px;
    }

    .btn-logout {
      display: flex;
      align-items: center;
      gap: 8px;
      width: calc(100% - 1rem);
      margin: 0 0.5rem 0.6rem;
      padding: 0.58rem 1rem;
      border: 1px solid #3a0a0a;
      border-radius: var(--radius);
      background: var(--red-bg);
      color: var(--red);
      font-family: 'DM Sans', sans-serif;
      font-size: 0.86rem;
      font-weight: 600;
      cursor: pointer;
      transition: all var(--t);
      text-align: left;
    }

    .btn-logout:hover { background: var(--red); color: #fff; border-color: var(--red); }

    .sidebar-footer {
      padding: 0.8rem 1.2rem;
      border-top: 1px solid var(--border);
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .avatar {
      width: 34px; height: 34px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--gold), #7a5c1e);
      display: flex; align-items: center; justify-content: center;
      font-size: 0.72rem; font-weight: 700; color: #0c0e13;
      flex-shrink: 0;
      border: 1px solid var(--gold);
    }

    .avatar-name { font-size: 0.84rem; font-weight: 600; color: var(--text-head); }
    .avatar-role { font-size: 0.68rem; color: var(--text-muted); }

    /* ── Main ── */
    .main { margin-left: var(--sidebar-w); flex: 1; display: flex; flex-direction: column; }

    .topbar {
      height: 56px;
      background: var(--surface);
      border-bottom: 1px solid var(--border);
      display: flex; align-items: center;
      padding: 0 1.8rem; gap: 0.8rem;
      position: sticky; top: 0; z-index: 90;
    }

    .topbar-title {
      font-family: 'Cinzel', serif;
      font-size: 0.88rem;
      font-weight: 600;
      color: var(--gold-bright);
      letter-spacing: 1px;
      text-transform: uppercase;
    }
    .topbar-date { font-size: 0.76rem; color: var(--text-muted); }
    .topbar-right { margin-left: auto; }

    .topbar-avatar {
      width: 30px; height: 30px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--gold), #7a5c1e);
      display: flex; align-items: center; justify-content: center;
      font-size: 0.68rem; font-weight: 700; color: #0c0e13;
      border: 1px solid var(--gold);
    }

    .content { padding: 1.6rem; display: flex; flex-direction: column; gap: 1.4rem; }

    /* Bienvenida */
    .welcome {
      background: var(--surface);
      border: 1px solid var(--border-gold);
      border-radius: var(--radius);
      padding: 1.6rem 2rem;
      display: flex; align-items: center; justify-content: space-between;
      overflow: hidden; position: relative;
    }

    .welcome::before {
      content: '';
      position: absolute; inset: 0;
      background: linear-gradient(120deg, rgba(201,168,76,0.07) 0%, transparent 55%);
      pointer-events: none;
    }

    .welcome::after {
      content: '✦';
      position: absolute; right: 2rem;
      font-size: 7rem; opacity: 0.04;
      color: var(--gold-bright);
      line-height: 1;
    }

    .welcome h2 {
      font-family: 'Cinzel', serif;
      font-size: 1.15rem;
      font-weight: 600;
      color: var(--gold-bright);
      margin-bottom: 0.3rem;
      letter-spacing: 0.8px;
    }
    .welcome p { font-size: 0.82rem; color: var(--text-muted); }

    .welcome-num {
      font-family: 'Cinzel', serif;
      font-size: 2rem;
      font-weight: 700;
      color: var(--gold-bright);
      text-align: right;
      z-index: 1;
    }
    .welcome-lbl { font-size: 0.7rem; color: var(--text-muted); text-align: right; margin-top: 4px; letter-spacing: 0.5px; text-transform: uppercase; }

    /* Métricas */
    .metrics { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; }

    .metric {
      background: var(--surface);
      border-radius: var(--radius);
      padding: 1.3rem 1.4rem;
      border: 1px solid var(--border);
      box-shadow: var(--shadow);
      transition: all var(--t);
      position: relative;
      overflow: hidden;
    }

    .metric::after {
      content: '';
      position: absolute;
      bottom: 0; left: 0; right: 0;
      height: 2px;
      background: linear-gradient(90deg, var(--gold), transparent);
      opacity: 0;
      transition: opacity var(--t);
    }

    .metric:hover { transform: translateY(-2px); border-color: var(--border-gold); }
    .metric:hover::after { opacity: 1; }

    .metric-icon { font-size: 1.3rem; margin-bottom: 0.8rem; }
    .metric-lbl  { font-size: 0.68rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 0.3rem; }
    .metric-val  { font-family: 'Cinzel', serif; font-size: 1.5rem; font-weight: 700; color: var(--text-head); margin-bottom: 0.3rem; }
    .metric-chg  { font-size: 0.72rem; font-weight: 600; }
    .up   { color: var(--mint); }
    .down { color: var(--red); }

    /* Panel genérico */
    .mid { display: grid; grid-template-columns: 1fr 320px; gap: 1rem; }

    .panel {
      background: var(--surface);
      border-radius: var(--radius);
      border: 1px solid var(--border);
      box-shadow: var(--shadow);
      overflow: hidden;
    }

    .panel-head {
      padding: 0.9rem 1.3rem;
      border-bottom: 1px solid var(--border);
      display: flex; align-items: center; justify-content: space-between;
    }

    .panel-title {
      font-family: 'Cinzel', serif;
      font-size: 0.76rem;
      font-weight: 600;
      color: var(--text-head);
      letter-spacing: 0.8px;
      text-transform: uppercase;
    }

    .panel-tag {
      font-size: 0.66rem; font-weight: 600;
      padding: 2px 9px; border-radius: 4px;
      background: var(--gold-light);
      color: var(--gold-bright);
      border: 1px solid var(--border-gold);
    }

    /* Barras CSS */
    .chart { padding: 1.2rem 1.4rem; }

    .bars { display: flex; align-items: flex-end; gap: 10px; height: 160px; }

    .bar-col {
      flex: 1; display: flex; flex-direction: column;
      align-items: center; gap: 5px; height: 100%; justify-content: flex-end;
    }

    .bar-v   { font-size: 0.64rem; font-weight: 600; color: var(--text-muted); }
    .bar     { width: 100%; border-radius: 4px 4px 0 0; }
    .bar.solid { background: linear-gradient(180deg, var(--gold-bright), var(--gold)); }
    .bar.ghost { background: var(--surface-2); border: 1px solid var(--border); border-bottom: none; }
    .bar-lbl { font-size: 0.66rem; color: var(--text-muted); font-weight: 500; }

    /* Pedidos */
    .order-item {
      display: flex; align-items: center; gap: 10px;
      padding: 0.78rem 1.3rem;
      border-bottom: 1px solid var(--border);
      transition: background var(--t);
    }

    .order-item:last-child { border-bottom: none; }
    .order-item:hover { background: var(--surface-2); }

    .order-ico {
      width: 34px; height: 34px; border-radius: var(--radius);
      background: var(--gold-light);
      border: 1px solid var(--border-gold);
      display: flex; align-items: center; justify-content: center;
      font-size: 0.95rem; flex-shrink: 0;
    }

    .order-name { font-size: 0.84rem; font-weight: 600; color: var(--text-head); }
    .order-time { font-size: 0.7rem; color: var(--text-muted); }
    .order-info { flex: 1; min-width: 0; }
    .order-amt  { font-size: 0.86rem; font-weight: 700; color: var(--gold-bright); flex-shrink: 0; }

    .pill { font-size: 0.65rem; font-weight: 600; padding: 2px 8px; border-radius: 4px; flex-shrink: 0; }
    .pill.ok  { background: var(--mint-bg);  color: var(--mint);  border: 1px solid #0a3d20; }
    .pill.pnd { background: var(--amber-bg); color: var(--amber); border: 1px solid #2a2000; }
    .pill.err { background: var(--red-bg);   color: var(--red);   border: 1px solid #3a0a0a; }

    @media (max-width: 1100px) {
      .metrics { grid-template-columns: repeat(2,1fr); }
      .mid     { grid-template-columns: 1fr; }
    }

    @media (max-width: 700px) {
      .sidebar { display: none; }
      .main    { margin-left: 0; }
      .metrics { grid-template-columns: 1fr 1fr; }
      .content { padding: 1rem; }
    }
  </style>
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar">
  <div class="sidebar-logo">
    <span class="logo-icon">✦</span>
    <div>
      <div class="logo-name">Star Dynasty</div>
      <div class="logo-sub">Panel Admin</div>
    </div>
  </div>

  <div class="nav-section">Principal</div>
  <a class="nav-item active" href="#">🏠 &nbsp;Inicio</a>
  <a class="nav-item" href="#">📊 &nbsp;Ventas</a>
  <a class="nav-item" href="#">📦 &nbsp;Inventario <span class="nav-badge">3</span></a>

  <div class="nav-section">Gestión</div>
  <a class="nav-item" href="#">🛒 &nbsp;Pedidos <span class="nav-badge">12</span></a>
  <a class="nav-item" href="#">👥 &nbsp;Clientes</a>
  <a class="nav-item" href="#">👗 &nbsp;Productos</a>

  <div class="nav-section">Sistema</div>
  <a class="nav-item" href="#">📈 &nbsp;Reportes</a>
  <a class="nav-item" href="#">⚙️ &nbsp;Configuración</a>
    <div style="margin-top:auto;">
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <button class="btn-logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        🚪 &nbsp;Cerrar Sesión
    </button>
</div>
    <div class="sidebar-footer">
      <div class="avatar">AL</div>
      <div>
        <div class="avatar-name">Alejandro</div>
        <div class="avatar-role">Administrador</div>
      </div>
    </div>
  
</aside>

<!-- MAIN -->
<main class="main">

  <div class="topbar">
    <span class="topbar-title">Inicio</span>
    <span class="topbar-date">Martes, 19 de mayo de 2026</span>
    <div class="topbar-right">
      <div class="topbar-avatar">AL</div>
    </div>
  </div>

  <div class="content">

    <!-- Bienvenida -->
    <div class="welcome">
      <div>
        <h2>Bienvenido, Administrador</h2>
        <p>Resumen del día — Star Dynasty</p>
      </div>
      <div>
        <div class="welcome-num">$47,320</div>
        <div class="welcome-lbl">Ventas de hoy</div>
      </div>
    </div>

    <!-- 3 métricas -->
    <div class="metrics">
      <div class="metric">
        <div class="metric-icon">💰</div>
        <div class="metric-lbl">Ventas del mes</div>
        <div class="metric-val">$1,284,500</div>
        <div class="metric-chg up">▲ 14.2% vs mes anterior</div>
      </div>
      <div class="metric">
        <div class="metric-icon">🛒</div>
        <div class="metric-lbl">Pedidos totales</div>
        <div class="metric-val">3,847</div>
        <div class="metric-chg up">▲ 8.6% vs mes anterior</div>
      </div>
      <div class="metric">
        <div class="metric-icon">👗</div>
        <div class="metric-lbl">Prendas en stock</div>
        <div class="metric-val">214</div>
        <div class="metric-chg down">▼ 3 referencias bajas</div>
      </div>
    </div>

    <!-- Gráfica + Pedidos -->
    <div class="mid">

      <div class="panel">
        <div class="panel-head">
          <span class="panel-title">Ventas por mes</span>
          <span class="panel-tag">2026</span>
        </div>
        <div class="chart">
          <div class="bars">
            <div class="bar-col"><div class="bar-v">$820k</div><div class="bar solid" style="height:64%"></div><div class="bar-lbl">Ene</div></div>
            <div class="bar-col"><div class="bar-v">$940k</div><div class="bar solid" style="height:73%"></div><div class="bar-lbl">Feb</div></div>
            <div class="bar-col"><div class="bar-v">$1.1M</div><div class="bar solid" style="height:86%"></div><div class="bar-lbl">Mar</div></div>
            <div class="bar-col"><div class="bar-v">$980k</div><div class="bar solid" style="height:76%"></div><div class="bar-lbl">Abr</div></div>
            <div class="bar-col"><div class="bar-v">$1.28M</div><div class="bar solid" style="height:100%"></div><div class="bar-lbl">May</div></div>
            <div class="bar-col"><div class="bar-v">—</div><div class="bar ghost" style="height:38%"></div><div class="bar-lbl">Jun</div></div>
            <div class="bar-col"><div class="bar-v">—</div><div class="bar ghost" style="height:38%"></div><div class="bar-lbl">Jul</div></div>
          </div>
        </div>
      </div>

      <div class="panel">
        <div class="panel-head">
          <span class="panel-title">Pedidos recientes</span>
          <span class="panel-tag">Hoy</span>
        </div>
        <div class="order-item">
          <div class="order-ico">👗</div>
          <div class="order-info"><div class="order-name">Vestido Noir Premium</div><div class="order-time">Hace 8 min · Pedro G.</div></div>
          <span class="pill ok">Pagado</span>
          <div class="order-amt">$285,000</div>
        </div>
        <div class="order-item">
          <div class="order-ico">👔</div>
          <div class="order-info"><div class="order-name">Camisa Oxford x3</div><div class="order-time">Hace 22 min · Laura M.</div></div>
          <span class="pill pnd">Pendiente</span>
          <div class="order-amt">$132,000</div>
        </div>
        <div class="order-item">
          <div class="order-ico">👠</div>
          <div class="order-info"><div class="order-name">Zapatos Cuero Elite</div><div class="order-time">Hace 45 min · Sofía R.</div></div>
          <span class="pill ok">Pagado</span>
          <div class="order-amt">$198,000</div>
        </div>
        <div class="order-item">
          <div class="order-ico">🧥</div>
          <div class="order-info"><div class="order-name">Abrigo Cachemira</div><div class="order-time">Hace 1h · Carlos V.</div></div>
          <span class="pill err">Cancelado</span>
          <div class="order-amt">$420,000</div>
        </div>
        <div class="order-item">
          <div class="order-ico">👜</div>
          <div class="order-info"><div class="order-name">Bolso Dynasty Gold</div><div class="order-time">Hace 1h 30min · Ana P.</div></div>
          <span class="pill ok">Pagado</span>
          <div class="order-amt">$375,000</div>
        </div>
      </div>

    </div>

  </div>
</main>

</body>
</html>