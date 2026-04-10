<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login — Portfolio Admin</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    * { margin:0; padding:0; box-sizing:border-box; }

    :root {
      --primary: #6366f1;
      --primary-dark: #4f46e5;
      --text: #1e293b;
      --text-light: #64748b;
      --bg: #f8fafc;
      --border: #e2e8f0;
      --gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    body {
      font-family: 'Inter', sans-serif;
      min-height: 100vh;
      display: flex;
      background: var(--bg);
    }

    /* === LEFT PANEL (VISUAL) === */
    .login-visual {
      flex: 1;
      background: var(--gradient);
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 3rem;
      position: relative;
      overflow: hidden;
      color: #fff;
    }

    .login-visual::before {
      content: '';
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: radial-gradient(circle, rgba(255,255,255,.08) 0%, transparent 70%);
      animation: floatBg 20s ease-in-out infinite;
    }

    @keyframes floatBg {
      0%,100% { transform: translate(0,0); }
      33% { transform: translate(30px,-30px); }
      66% { transform: translate(-20px,20px); }
    }

    .visual-content {
      position: relative;
      z-index: 1;
      text-align: center;
      max-width: 400px;
    }

    .visual-icon {
      width: 80px;
      height: 80px;
      background: rgba(255,255,255,.15);
      border-radius: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 2rem;
      backdrop-filter: blur(10px);
    }

    .visual-icon svg {
      width: 40px;
      height: 40px;
      stroke: #fff;
      fill: none;
      stroke-width: 2;
      stroke-linecap: round;
      stroke-linejoin: round;
    }

    .visual-content h2 {
      font-size: 2rem;
      font-weight: 800;
      margin-bottom: 1rem;
      line-height: 1.2;
    }

    .visual-content p {
      font-size: 1.05rem;
      opacity: .8;
      line-height: 1.7;
    }

    .visual-dots {
      position: absolute;
      bottom: 2rem;
      display: flex;
      gap: 8px;
    }

    .visual-dots span {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: rgba(255,255,255,.3);
    }

    .visual-dots span:nth-child(2) { background: #fff; width: 20px; border-radius: 10px; }

    /* Floating shapes */
    .shape {
      position: absolute;
      border-radius: 50%;
      background: rgba(255,255,255,.06);
    }

    .shape-1 { width: 300px; height: 300px; top: -100px; right: -100px; }
    .shape-2 { width: 200px; height: 200px; bottom: -60px; left: -60px; }
    .shape-3 { width: 100px; height: 100px; top: 40%; left: 10%; background: rgba(255,255,255,.04); }

    /* === RIGHT PANEL (FORM) === */
    .login-form-panel {
      flex: 1;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 3rem;
      max-width: 520px;
    }

    .form-wrapper {
      width: 100%;
      max-width: 380px;
    }

    .form-header {
      margin-bottom: 2.5rem;
    }

    .form-logo {
      font-size: 1.5rem;
      font-weight: 700;
      background: var(--gradient);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      text-decoration: none;
      display: inline-block;
      margin-bottom: 1.5rem;
    }

    .form-header h1 {
      font-size: 1.75rem;
      font-weight: 700;
      color: var(--text);
      margin-bottom: .5rem;
    }

    .form-header p {
      color: var(--text-light);
      font-size: .95rem;
    }

    /* Alert / Status */
    .alert {
      padding: .75rem 1rem;
      border-radius: 10px;
      margin-bottom: 1.5rem;
      font-size: .875rem;
      display: flex;
      align-items: center;
      gap: .5rem;
    }

    .alert-success {
      background: #ecfdf5;
      color: #065f46;
      border: 1px solid #a7f3d0;
    }

    .alert-error {
      background: #fef2f2;
      color: #991b1b;
      border: 1px solid #fecaca;
    }

    .alert svg { width: 18px; height: 18px; flex-shrink: 0; }

    /* Form Elements */
    .field {
      margin-bottom: 1.25rem;
    }

    .field label {
      display: block;
      font-size: .875rem;
      font-weight: 500;
      color: var(--text);
      margin-bottom: .4rem;
    }

    .field input[type="email"],
    .field input[type="password"] {
      width: 100%;
      padding: .75rem 1rem;
      border: 1.5px solid var(--border);
      border-radius: 10px;
      font-size: .95rem;
      font-family: 'Inter', sans-serif;
      transition: all .2s;
      background: #fff;
      color: var(--text);
    }

    .field input:focus {
      outline: none;
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(99,102,241,.1);
    }

    .field input.error {
      border-color: #ef4444;
      box-shadow: 0 0 0 3px rgba(239,68,68,.1);
    }

    .field-error {
      font-size: .8rem;
      color: #ef4444;
      margin-top: .3rem;
      display: flex;
      align-items: center;
      gap: .25rem;
    }

    .field-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 1.5rem;
    }

    .remember {
      display: flex;
      align-items: center;
      gap: .5rem;
      cursor: pointer;
    }

    .remember input[type="checkbox"] {
      width: 16px;
      height: 16px;
      accent-color: var(--primary);
      cursor: pointer;
    }

    .remember span {
      font-size: .875rem;
      color: var(--text-light);
    }

    .forgot {
      font-size: .875rem;
      color: var(--primary);
      text-decoration: none;
      font-weight: 500;
      transition: color .2s;
    }

    .forgot:hover {
      color: var(--primary-dark);
      text-decoration: underline;
    }

    .btn-login {
      width: 100%;
      padding: .8rem;
      background: var(--gradient);
      color: #fff;
      border: none;
      border-radius: 10px;
      font-size: 1rem;
      font-weight: 600;
      font-family: 'Inter', sans-serif;
      cursor: pointer;
      transition: all .2s;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: .5rem;
    }

    .btn-login:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(99,102,241,.35);
    }

    .btn-login:active {
      transform: translateY(0);
    }

    .btn-login svg {
      width: 18px;
      height: 18px;
      stroke: #fff;
      fill: none;
      stroke-width: 2;
      stroke-linecap: round;
      stroke-linejoin: round;
    }

    .back-link {
      display: block;
      text-align: center;
      margin-top: 2rem;
      font-size: .875rem;
      color: var(--text-light);
      text-decoration: none;
      transition: color .2s;
    }

    .back-link:hover {
      color: var(--primary);
    }

    .back-link svg {
      width: 14px;
      height: 14px;
      vertical-align: middle;
      margin-right: .3rem;
      stroke: currentColor;
      fill: none;
      stroke-width: 2;
      stroke-linecap: round;
      stroke-linejoin: round;
    }

    /* Responsive */
    @media (max-width: 900px) {
      body { flex-direction: column; }
      .login-visual {
        padding: 2.5rem 1.5rem;
        min-height: auto;
      }
      .visual-content h2 { font-size: 1.5rem; }
      .visual-icon { width: 60px; height: 60px; border-radius: 16px; }
      .visual-icon svg { width: 30px; height: 30px; }
      .shape { display: none; }
      .login-form-panel { padding: 2rem 1.5rem; }
    }

    @media (max-width: 480px) {
      .login-visual { padding: 2rem 1.25rem; }
      .visual-dots { display: none; }
      .login-form-panel { padding: 1.5rem 1.25rem; }
    }
  </style>
</head>
<body>

  <!-- LEFT VISUAL -->
  <div class="login-visual">
    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>
    <div class="shape shape-3"></div>

    <div class="visual-content">
      <div class="visual-icon">
        <svg viewBox="0 0 24 24">
          <rect x="3" y="3" width="7" height="7"/>
          <rect x="14" y="3" width="7" height="7"/>
          <rect x="14" y="14" width="7" height="7"/>
          <rect x="3" y="14" width="7" height="7"/>
        </svg>
      </div>
      <h2>Portfolio Admin Panel</h2>
      <p>Kelola portofolio kamu dari satu tempat. Update skills, tambah project, dan balas pesan pengunjung.</p>
    </div>

    <div class="visual-dots">
      <span></span><span></span><span></span>
    </div>
  </div>

  <!-- RIGHT FORM -->
  <div class="login-form-panel">
    <div class="form-wrapper">

      <div class="form-header">
        <a href="{{ route('portfolio') }}" class="form-logo">Portfolio</a>
        <h1>Selamat Datang</h1>
        <p>Masuk untuk mengelola portofolio kamu</p>
      </div>

      <!-- Session Status -->
      @if (session('status'))
        <div class="alert alert-success">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
          {{ session('status') }}
        </div>
      @endif

      <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email -->
        <div class="field">
          <label for="email">Email</label>
          <input
            id="email"
            type="email"
            name="email"
            value="{{ old('email') }}"
            required
            autofocus
            autocomplete="username"
            class="{{ $errors->has('email') ? 'error' : '' }}"
            placeholder="admin@email.com"
          >
          @if ($errors->has('email'))
            <div class="field-error">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
              {{ $errors->first('email') }}
            </div>
          @endif
        </div>

        <!-- Password -->
        <div class="field">
          <label for="password">Password</label>
          <input
            id="password"
            type="password"
            name="password"
            required
            autocomplete="current-password"
            class="{{ $errors->has('password') ? 'error' : '' }}"
            placeholder="••••••••"
          >
          @if ($errors->has('password'))
            <div class="field-error">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
              {{ $errors->first('password') }}
            </div>
          @endif
        </div>

        <!-- Remember & Forgot -->
        <div class="field-row">
          <label class="remember">
            <input type="checkbox" name="remember" id="remember_me">
            <span>Ingat saya</span>
          </label>
          @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="forgot">Lupa password?</a>
          @endif
        </div>

        <!-- Submit -->
        <button type="submit" class="btn-login">
          <svg viewBox="0 0 24 24">
            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
            <polyline points="10 17 15 12 10 7"/>
            <line x1="15" y1="12" x2="3" y2="12"/>
          </svg>
          Masuk
        </button>
      </form>

      <a href="{{ route('portfolio') }}" class="back-link">
        <svg viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        Kembali ke website
      </a>

    </div>
  </div>

</body>
</html>