<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dulcería Encanto – Iniciar Sesión</title>
  <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@500;600;700;800&family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet"/>
  <style>
    :root {
      --pink:         #ff6fa8;
      --pink-bright:  #ff8fc0;
      --pink-deep:    #e0417f;
      --mint:         #4fd8b8;
      --mint-deep:    #29b294;
      --caramel:      #f2a65a;
      --caramel-deep: #d98530;
      --cream:        #fff7ec;
      --bg-top:       #fff0f6;
      --bg-bottom:    #fdeaf9;
      --surface:      #ffffff;
      --surface-2:    #fff5fa;
      --border:       #ffd9ea;
      --border-mint:  #cdf3e8;
      --text-head:    #6b2456;
      --text-main:    #5a3a52;
      --text-muted:   #b489a8;
      --red:          #e0417f;
      --red-bg:       #fdeaf1;
      --radius-card:  32px;
      --radius-input: 16px;
      --radius-btn:   50px;
      --shadow-card:  0 30px 70px rgba(224,65,127,0.18), 0 8px 24px rgba(224,65,127,0.1);
      --shadow-btn:   0 10px 26px rgba(255,111,168,0.45);
      --transition:   0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Quicksand', sans-serif;
      background:
        radial-gradient(ellipse at 15% 15%, rgba(255,143,192,0.35) 0%, transparent 45%),
        radial-gradient(ellipse at 85% 20%, rgba(79,216,184,0.28) 0%, transparent 45%),
        radial-gradient(ellipse at 50% 100%, rgba(242,166,90,0.22) 0%, transparent 55%),
        linear-gradient(160deg, var(--bg-top) 0%, var(--bg-bottom) 100%);
      overflow: hidden;
      padding: 2rem 1rem;
      position: relative;
    }

    /* Confites flotando de fondo */
    .bg-decor { position: fixed; inset: 0; pointer-events: none; z-index: 0; }

    .candy {
      position: absolute;
      font-size: 1.6rem;
      opacity: 0;
      filter: drop-shadow(0 4px 10px rgba(224,65,127,0.15));
      animation: floatCandy 6s ease-in-out infinite;
      user-select: none;
    }

    .c1  { top: 8%;  left: 6%;   animation-delay: 0s;   font-size: 1.4rem; }
    .c2  { top: 16%; right: 8%;  animation-delay: 1s;   font-size: 2rem; }
    .c3  { top: 55%; left: 4%;   animation-delay: 2s;   font-size: 1.6rem; }
    .c4  { bottom: 14%; right: 6%; animation-delay: 0.6s; font-size: 1.8rem; }
    .c5  { bottom: 30%; left: 8%;  animation-delay: 2.6s; font-size: 1.3rem; }
    .c6  { top: 38%; right: 4%;  animation-delay: 1.4s; font-size: 1.9rem; }
    .c7  { top: 78%; right: 16%; animation-delay: 3s;   font-size: 1.4rem; }
    .c8  { top: 4%;  left: 42%;  animation-delay: 2.2s; font-size: 1.5rem; }

    @keyframes floatCandy {
      0%   { opacity: 0;   transform: translateY(0) rotate(-6deg) scale(0.85); }
      50%  { opacity: 0.9; transform: translateY(-16px) rotate(10deg) scale(1.05); }
      100% { opacity: 0;   transform: translateY(-32px) rotate(-6deg) scale(0.85); }
    }

    /* Wrapper */
    .login-wrapper {
      position: relative;
      z-index: 1;
      width: 100%;
      max-width: 420px;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 1.6rem;
      animation: fadeUp 0.7s cubic-bezier(0.4, 0, 0.2, 1) both;
    }

    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(28px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    /* Marca */
    .brand { text-align: center; }

    .brand-icon {
      font-size: 3.2rem;
      line-height: 1;
      margin-bottom: 0.5rem;
      display: inline-block;
      animation: swirl 3.5s ease-in-out infinite;
      filter: drop-shadow(0 6px 14px rgba(224,65,127,0.35));
    }

    @keyframes swirl {
      0%, 100% { transform: rotate(-10deg) scale(1); }
      50%       { transform: rotate(10deg)  scale(1.12); }
    }

    .brand-name {
      font-family: 'Baloo 2', sans-serif;
      font-size: 2.1rem;
      font-weight: 800;
      color: var(--text-head);
      letter-spacing: 0.5px;
      line-height: 1.1;
      text-shadow: 0 2px 0 rgba(255,255,255,0.6);
    }

    .brand-tagline {
      font-size: 0.86rem;
      color: var(--pink-deep);
      margin-top: 0.4rem;
      letter-spacing: 1.5px;
      text-transform: uppercase;
      font-weight: 700;
    }

    /* Tarjeta con borde tipo envoltorio de dulce */
    .card {
      width: 100%;
      background: var(--surface);
      border-radius: var(--radius-card);
      padding: 2.5rem 2.2rem 2.2rem;
      box-shadow: var(--shadow-card);
      border: 3px solid var(--surface);
      position: relative;
      overflow: hidden;
    }

    /* Borde festoneado tipo envoltorio */
    .card::before {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0;
      height: 14px;
      background-image: radial-gradient(circle at 10px 0, transparent 9px, var(--pink) 10px);
      background-size: 20px 14px;
      background-repeat: repeat-x;
    }

    .card::after {
      content: '';
      position: absolute;
      top: -70px; right: -70px;
      width: 180px; height: 180px;
      background: radial-gradient(circle, rgba(79,216,184,0.14) 0%, transparent 70%);
      pointer-events: none;
    }

    /* Franja de caramelo bajo el borde festoneado */
    .card-stripe {
      position: absolute;
      top: 14px; left: 0; right: 0;
      height: 6px;
      background: repeating-linear-gradient(
        -45deg,
        var(--mint) 0 10px,
        var(--pink-bright) 10px 20px
      );
    }

    /* Error */
    .error-box {
      background: var(--red-bg);
      border: 2px dashed rgba(224,65,127,0.35);
      color: var(--red);
      padding: 0.9rem 1rem;
      border-radius: var(--radius-input);
      margin-bottom: 1.4rem;
      font-size: 0.86rem;
      font-weight: 600;
    }

    .error-box strong { display: block; margin-bottom: 2px; font-weight: 800; }

    /* Campos */
    .field-group { margin-bottom: 1.3rem; }

    .field-group label {
      display: block;
      font-size: 0.72rem;
      font-weight: 700;
      color: var(--pink-deep);
      margin-bottom: 0.5rem;
      letter-spacing: 1px;
      text-transform: uppercase;
    }

    .input-wrapper {
      position: relative;
      display: flex;
      align-items: center;
    }

    .input-icon {
      position: absolute;
      left: 14px;
      color: var(--mint-deep);
      display: flex;
      align-items: center;
      pointer-events: none;
      transition: color var(--transition);
    }
    .toggle-password {
      position: absolute;
      right: 14px;
      color: var(--text-muted);
      display: flex;
      align-items: center;
      cursor: pointer;
      transition: color var(--transition);
      background: none;
      border: none;
      padding: 0;
    }

    .toggle-password:hover { color: var(--pink-deep); }

    .toggle-password svg { display: block; }

    .input-wrapper.has-toggle input {
      padding-right: 2.7rem;
    }

    .input-wrapper input {
      width: 100%;
      padding: 0.85rem 1rem 0.85rem 2.8rem;
      border: 2px solid var(--border);
      border-radius: var(--radius-input);
      font-family: 'Quicksand', sans-serif;
      font-size: 0.95rem;
      font-weight: 600;
      color: var(--text-main);
      background: var(--surface-2);
      outline: none;
      transition: all var(--transition);
    }

    .input-wrapper input::placeholder {
      color: var(--text-muted);
      font-weight: 500;
    }

    .input-wrapper input:focus {
      border-color: var(--pink);
      background: #fffdfd;
      box-shadow: 0 0 0 4px rgba(255,111,168,0.15);
    }

    .input-wrapper:focus-within .input-icon { color: var(--pink-deep); }

    /* Botón principal estilo gomita */
    .btn-primary {
      display: block;
      width: 100%;
      padding: 0.95rem;
      margin-top: 0.6rem;
      background: linear-gradient(135deg, var(--pink) 0%, var(--pink-deep) 100%);
      color: #fff;
      font-family: 'Baloo 2', sans-serif;
      font-size: 1rem;
      font-weight: 700;
      letter-spacing: 1px;
      border: none;
      border-radius: var(--radius-btn);
      cursor: pointer;
      box-shadow: var(--shadow-btn);
      transition: all var(--transition);
      position: relative;
      overflow: hidden;
    }

    .btn-primary::after {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, rgba(255,255,255,0.35) 0%, transparent 55%);
      pointer-events: none;
    }

    .btn-primary:hover {
      transform: translateY(-2px) scale(1.01);
      box-shadow: 0 14px 32px rgba(255,111,168,0.55);
      background: linear-gradient(135deg, var(--pink-bright) 0%, var(--pink) 100%);
    }

    .btn-primary:active { transform: translateY(0) scale(1); }

    /* Divisor */
    .divider {
      display: flex;
      align-items: center;
      gap: 0.8rem;
      margin: 1.4rem 0 1.2rem;
      color: var(--text-muted);
      font-size: 0.8rem;
      font-weight: 700;
      letter-spacing: 1px;
    }

    .divider::before,
    .divider::after {
      content: '';
      flex: 1;
      height: 2px;
      background-image: linear-gradient(to right, var(--border) 50%, transparent 50%);
      background-size: 8px 2px;
    }

    /* Botón recuperar */
    .btn-recover {
      display: block;
      width: 100%;
      padding: 0.85rem;
      text-align: center;
      background: var(--cream);
      color: var(--mint-deep);
      font-family: 'Quicksand', sans-serif;
      font-size: 0.9rem;
      font-weight: 700;
      text-decoration: none;
      border: 2px solid var(--border-mint);
      border-radius: var(--radius-btn);
      cursor: pointer;
      transition: all var(--transition);
      letter-spacing: 0.3px;
    }

    .btn-recover:hover {
      background: #eafbf6;
      border-color: var(--mint);
      transform: translateY(-2px);
      box-shadow: 0 6px 18px rgba(79,216,184,0.25);
    }

    .btn-recover:active { transform: translateY(0); }

    /* Pie */
    .footer-note {
      font-size: 0.84rem;
      color: var(--text-muted);
      text-align: center;
      font-weight: 600;
    }

    .footer-note a {
      color: var(--pink-deep);
      font-weight: 700;
      text-decoration: none;
      transition: color var(--transition);
    }

    .footer-note a:hover { color: var(--mint-deep); text-decoration: underline; }

    @media (max-width: 480px) {
      .card { padding: 2.2rem 1.4rem 1.8rem; }
      .brand-name { font-size: 1.7rem; }
    }
  </style>
</head>
<body>

  <!-- Confites de fondo -->
  <div class="bg-decor">
    <span class="candy c1">🍬</span>
    <span class="candy c2">🍭</span>
    <span class="candy c3">🍡</span>
    <span class="candy c4">🧁</span>
    <span class="candy c5">🍫</span>
    <span class="candy c6">🍭</span>
    <span class="candy c7">🍬</span>
    <span class="candy c8">🍡</span>
  </div>

  <div class="login-wrapper">

    <!-- Marca -->
    <div class="brand">
      <div class="brand-icon">🍭</div>
      <h1 class="brand-name">Dulcería Encanto</h1>
      <p class="brand-tagline">Acceso exclusivo</p>
    </div>

    <!-- Tarjeta -->
    <div class="card">
      <div class="card-stripe"></div>

      @if ($errors->any())
        <div class="error-box">
          <strong>¡Ups, algo no cuadra!</strong>
          <p>El correo o la contraseña no son correctos. Inténtalo de nuevo.</p>
        </div>
      @endif

      <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email -->
        <div class="field-group">
          <label for="correo">Correo electrónico</label>
          <div class="input-wrapper">
            <span class="input-icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                   fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="4" width="20" height="16" rx="2"/>
                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
              </svg>
            </span>
            <input type="email" name="correo" id="correo"
                   placeholder="tu@correo.com" required autocomplete="email"/>
          </div>
        </div>

        <!-- Contraseña -->
        <div class="field-group">
          <label for="contrasena">Contraseña</label>
          <div class="input-wrapper has-toggle">
            <span class="input-icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                  fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
              </svg>
            </span>
            <input type="password" name="contrasena" id="contrasena"
                  placeholder="••••••••" required autocomplete="current-password"/>
            <button type="button" class="toggle-password" id="togglePassword" aria-label="Mostrar contraseña">
              <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                  fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8Z"/>
                <circle cx="12" cy="12" r="3"/>
              </svg>
            </button>
          </div>
        </div>

        <button type="submit" class="btn-primary">Ingresar</button>

        <div class="divider"><span>o</span></div>

        <a href="{{ route('password.request') }}" class="btn-recover">
          🍯 Recuperar contraseña
        </a>

      </form>
    </div>

  </div>
  <script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput  = document.getElementById('contrasena');
    const eyeIcon         = document.getElementById('eyeIcon');

    const eyeOpen = `
      <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8Z"/>
      <circle cx="12" cy="12" r="3"/>
    `;
    const eyeClosed = `
      <path d="M17.94 17.94A10.94 10.94 0 0 1 12 20c-7 0-11-8-11-8a18.6 18.6 0 0 1 4.22-5.94"/>
      <path d="M9.9 4.24A10.94 10.94 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>
      <path d="M14.12 14.12a3 3 0 1 1-4.24-4.24"/>
      <line x1="1" y1="1" x2="23" y2="23"/>
    `;

    togglePassword.addEventListener('click', () => {
      const isPassword = passwordInput.type === 'password';
      passwordInput.type = isPassword ? 'text' : 'password';
      eyeIcon.innerHTML = isPassword ? eyeClosed : eyeOpen;
      togglePassword.setAttribute('aria-label', isPassword ? 'Ocultar contraseña' : 'Mostrar contraseña');
    });
  </script>

</body>
</html>