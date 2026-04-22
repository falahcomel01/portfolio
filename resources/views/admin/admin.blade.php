<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Admin') — Portfolio</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    * { margin:0; padding:0; box-sizing:border-box; }

    :root {
      --sidebar-w: 210px;
      --primary: #6366f1;
      --primary-dark: #4f46e5;
      --primary-light: #818cf8;
      --text: #1e293b;
      --text-light: #64748b;
      --bg: #f8fafc;
      --bg-card: #ffffff;
      --border: #e2e8f0;
      --danger: #ef4444;
      --success: #10b981;
      --warning: #f59e0b;
      --gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    body {
      font-family: 'Inter', sans-serif;
      background: var(--bg);
      color: var(--text);
      line-height: 1.6;
      display: flex;
      min-height: 100vh;
    }

    /* ============================================
       SIDEBAR
       ============================================ */
    .sidebar {
      width: var(--sidebar-w);
      background: #0f172a;
      display: flex;
      flex-direction: column;
      position: fixed;
      top: 0;
      left: 0;
      bottom: 0;
      z-index: 100;
      transition: transform .3s cubic-bezier(.4,0,.2,1);
      overflow-y: auto;
      overflow-x: hidden;
    }

    .sidebar::-webkit-scrollbar { width: 3px; }
    .sidebar::-webkit-scrollbar-track { background: transparent; }
    .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,.08); border-radius: 10px; }
    .sidebar::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,.15); }

    @media(max-width:768px) {
      .sidebar { transform: translateX(-100%); }
      .sidebar.open { transform: translateX(0); }
    }

    .sidebar-brand {
      padding: 1.1rem 1rem .9rem;
      display: flex;
      align-items: center;
      gap: .6rem;
      text-decoration: none;
      flex-shrink: 0;
    }

    .brand-icon {
      width: 34px;
      height: 34px;
      border-radius: 10px;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      box-shadow: 0 3px 12px rgba(102, 126, 234, .35);
    }

    .brand-icon svg {
      width: 16px;
      height: 16px;
      stroke: #fff;
      fill: none;
      stroke-width: 2.2;
      stroke-linecap: round;
      stroke-linejoin: round;
    }

    .brand-text {
      display: flex;
      flex-direction: column;
    }

    .brand-text .bt-name {
      font-size: .92rem;
      font-weight: 700;
      color: #fff;
      line-height: 1.2;
    }

    .brand-text .bt-badge {
      font-size: .6rem;
      font-weight: 600;
      color: rgba(255,255,255,.35);
      letter-spacing: .4px;
      text-transform: uppercase;
      margin-top: 1px;
    }

    .sidebar-divider {
      height: 1px;
      background: rgba(255,255,255,.06);
      margin: .15rem .85rem .75rem;
    }

    .nav-section-label {
      padding: 0 1rem;
      margin-bottom: .4rem;
      font-size: .6rem;
      font-weight: 600;
      color: rgba(255,255,255,.25);
      text-transform: uppercase;
      letter-spacing: .7px;
    }

    .sidebar-nav {
      flex: 1;
      padding: 0 .5rem;
      display: flex;
      flex-direction: column;
      gap: 1px;
    }

    .sidebar-nav a {
      display: flex;
      align-items: center;
      gap: .6rem;
      padding: .55rem .65rem;
      border-radius: 8px;
      color: rgba(255,255,255,.45);
      text-decoration: none;
      font-size: .8rem;
      font-weight: 500;
      transition: all .15s;
      position: relative;
    }

    .sidebar-nav a:hover {
      color: rgba(255,255,255,.8);
      background: rgba(255,255,255,.04);
    }

    .sidebar-nav a.active {
      color: #fff;
      background: rgba(99,102,241,.15);
    }

    .sidebar-nav a.active::before {
      content: '';
      position: absolute;
      left: 0;
      top: 50%;
      transform: translateY(-50%);
      width: 2.5px;
      height: 55%;
      border-radius: 0 3px 3px 0;
      background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
    }

    .sidebar-nav a .nav-icon {
      width: 30px;
      height: 30px;
      border-radius: 7px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      transition: all .15s;
      background: rgba(255,255,255,.03);
    }

    .sidebar-nav a:hover .nav-icon {
      background: rgba(255,255,255,.06);
    }

    .sidebar-nav a.active .nav-icon {
      background: rgba(99,102,241,.2);
    }

    .sidebar-nav a .nav-icon svg {
      width: 15px;
      height: 15px;
      stroke-width: 1.8;
      stroke-linecap: round;
      stroke-linejoin: round;
      fill: none;
      transition: stroke .15s;
    }

    .sidebar-nav a .nav-badge {
      margin-left: auto;
      min-width: 18px;
      height: 18px;
      border-radius: 5px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: .62rem;
      font-weight: 700;
      padding: 0 5px;
      flex-shrink: 0;
    }

    .sidebar-nav a .nav-badge.badge-danger {
      background: #ef4444;
      color: #fff;
      box-shadow: 0 2px 6px rgba(239,68,68,.3);
    }

    .sidebar-nav a .nav-badge.badge-muted {
      background: rgba(255,255,255,.08);
      color: rgba(255,255,255,.4);
    }

    .sidebar-bottom {
      padding: 0;
      flex-shrink: 0;
      border-top: 1px solid rgba(255,255,255,.06);
      margin-top: auto;
    }

    .sidebar-user {
      padding: .85rem .85rem .65rem;
      display: flex;
      align-items: center;
      gap: .55rem;
    }

    .user-avatar {
      width: 32px;
      height: 32px;
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      font-size: .75rem;
      color: #fff;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      flex-shrink: 0;
      box-shadow: 0 2px 8px rgba(102,126,234,.25);
    }

    .user-info {
      flex: 1;
      min-width: 0;
    }

    .user-info .ui-name {
      font-size: .78rem;
      font-weight: 600;
      color: #fff;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .user-info .ui-role {
      font-size: .62rem;
      color: rgba(255,255,255,.3);
      font-weight: 500;
    }

    .sidebar-bottom-links {
      padding: 0 .5rem .6rem;
      display: flex;
      flex-direction: column;
      gap: 1px;
    }

    .sidebar-bottom-links a {
      display: flex;
      align-items: center;
      gap: .6rem;
      padding: .5rem .65rem;
      border-radius: 8px;
      color: rgba(255,255,255,.35);
      text-decoration: none;
      font-size: .78rem;
      font-weight: 500;
      transition: all .15s;
    }

    .sidebar-bottom-links a:hover {
      color: rgba(255,255,255,.7);
      background: rgba(255,255,255,.04);
    }

    .sidebar-bottom-links a:hover svg { stroke: rgba(255,255,255,.7); }

    .sidebar-bottom-links a .nav-icon {
      width: 28px;
      height: 28px;
      border-radius: 7px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      background: rgba(255,255,255,.03);
    }

    .sidebar-bottom-links a .nav-icon svg {
      width: 14px;
      height: 14px;
      stroke-width: 1.8;
      stroke-linecap: round;
      stroke-linejoin: round;
      fill: none;
    }

    .sidebar-bottom-links a.link-danger:hover {
      color: #fca5a5;
      background: rgba(239,68,68,.08);
    }

    .sidebar-bottom-links a.link-danger:hover svg { stroke: #fca5a5; }
    .sidebar-bottom-links a.link-danger:hover .nav-icon { background: rgba(239,68,68,.08); }

    .sidebar-version {
      padding: .5rem 1rem .85rem;
      font-size: .6rem;
      color: rgba(255,255,255,.15);
      text-align: center;
      font-weight: 500;
    }

    /* ============================================
       MAIN CONTENT
       ============================================ */
    .main {
      margin-left: var(--sidebar-w);
      flex: 1;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    @media(max-width:768px) {
      .main { margin-left: 0; }
    }

    .topbar {
      background: rgba(255,255,255,.85);
      backdrop-filter: blur(20px);
      padding: .75rem 1.75rem;
      border-bottom: 1px solid var(--border);
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: sticky;
      top: 0;
      z-index: 50;
      transition: box-shadow .2s;
    }

    .topbar.scrolled {
      box-shadow: 0 2px 15px rgba(0,0,0,.05);
    }

    .topbar-left {
      display: flex;
      align-items: center;
      gap: .85rem;
    }

    .mobile-toggle {
      display: none;
      width: 36px;
      height: 36px;
      border-radius: 8px;
      border: 1px solid var(--border);
      background: #fff;
      cursor: pointer;
      align-items: center;
      justify-content: center;
      transition: all .15s;
      flex-shrink: 0;
    }

    .mobile-toggle:hover {
      background: var(--bg);
      border-color: #c7d2fe;
    }

    .mobile-toggle svg {
      width: 16px;
      height: 16px;
      stroke: var(--text);
      fill: none;
      stroke-width: 2;
      stroke-linecap: round;
      stroke-linejoin: round;
    }

    @media(max-width:768px) {
      .mobile-toggle { display: flex; }
    }

    .topbar h1 {
      font-size: 1.05rem;
      font-weight: 600;
      color: var(--text);
    }

    .topbar-right {
      display: flex;
      align-items: center;
      gap: .6rem;
    }

    .topbar-visit {
      padding: .45rem .85rem;
      border-radius: 8px;
      font-weight: 600;
      font-size: .75rem;
      border: 1.5px solid var(--border);
      background: #fff;
      color: var(--text);
      cursor: pointer;
      transition: all .15s;
      font-family: 'Inter', sans-serif;
      display: inline-flex;
      align-items: center;
      gap: .3rem;
      text-decoration: none;
    }

    .topbar-visit:hover {
      border-color: #a7f3d0;
      color: #059669;
      background: #f0fdf4;
    }

    .topbar-visit svg {
      width: 13px;
      height: 13px;
      stroke: currentColor;
      fill: none;
      stroke-width: 2;
      stroke-linecap: round;
      stroke-linejoin: round;
    }

    .topbar-avatar {
      width: 34px;
      height: 34px;
      border-radius: 8px;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      font-size: .8rem;
      box-shadow: 0 2px 8px rgba(102,126,234,.25);
    }

    .content {
      padding: 1.5rem 1.75rem;
      flex: 1;
    }

    @media(max-width:640px) {
      .content { padding: 1.1rem; }
      .topbar { padding: .65rem .85rem; }
      .topbar-visit span.visit-text { display: none; }
    }

    /* ============================================
       MOBILE OVERLAY
       ============================================ */
    .sidebar-overlay {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(15,23,42,.5);
      backdrop-filter: blur(4px);
      z-index: 99;
      opacity: 0;
      transition: opacity .3s;
    }

    .sidebar-overlay.show {
      display: block;
      opacity: 1;
    }

    @media(min-width:769px) {
      .sidebar-overlay { display: none !important; }
    }
  </style>
</head>
<body>

<!-- Mobile Overlay -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

<!-- ========== SIDEBAR ========== -->
<aside class="sidebar" id="sidebar">
  <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
    <div class="brand-icon">
      <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
    </div>
    <div class="brand-text">
      <span class="bt-name">Portfolio</span>
      <span class="bt-badge">Admin Panel</span>
    </div>
  </a>

  <div class="sidebar-divider"></div>

  <div class="nav-section-label">Menu Utama</div>
  <nav class="sidebar-nav">
    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
      <div class="nav-icon">
        <svg viewBox="0 0 24 24" stroke="currentColor"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/></svg>
      </div>
      Dashboard
    </a>
    <a href="{{ route('admin.settings') }}" class="{{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
      <div class="nav-icon">
        <svg viewBox="0 0 24 24" stroke="currentColor"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
      </div>
      Settings
    </a>
    <a href="{{ route('admin.about') }}" class="{{ request()->routeIs('admin.about*') ? 'active' : '' }}">
      <div class="nav-icon">
        <svg viewBox="0 0 24 24" stroke="currentColor"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
      </div>
      About
    </a>
  </nav>

  <div class="sidebar-divider" style="margin-top:.25rem;"></div>
  <div class="nav-section-label">Konten</div>
  <nav class="sidebar-nav">
    <a href="{{ route('admin.skills') }}" class="{{ request()->routeIs('admin.skills*') ? 'active' : '' }}">
      <div class="nav-icon">
        <svg viewBox="0 0 24 24" stroke="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
      </div>
      Skills
      <span class="nav-badge badge-muted">{{ \App\Models\Skill::count() }}</span>
    </a>
    <a href="{{ route('admin.projects') }}" class="{{ request()->routeIs('admin.projects*') ? 'active' : '' }}">
      <div class="nav-icon">
        <svg viewBox="0 0 24 24" stroke="currentColor"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
      </div>
      Projects
      <span class="nav-badge badge-muted">{{ \App\Models\Project::count() }}</span>
    </a>
    <a href="{{ route('admin.certificates.index') }}" class="{{ request()->routeIs('admin.certificates*') ? 'active' : '' }}">
      <div class="nav-icon">
        <svg viewBox="0 0 24 24" stroke="currentColor"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/><path d="M9 16l2 2 4-4"/></svg>
      </div>
      Sertifikat
      <span class="nav-badge badge-muted">{{ \App\Models\Certificate::count() }}</span>
    </a>
    <a href="{{ route('admin.contacts') }}" class="{{ request()->routeIs('admin.contacts*') ? 'active' : '' }}">
      <div class="nav-icon">
        <svg viewBox="0 0 24 24" stroke="currentColor"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
      </div>
      Pesan
      @php
        $unread = \App\Models\Contact::where('is_read', false)->count();
      @endphp
      @if($unread > 0)
        <span class="nav-badge badge-danger">{{ $unread }}</span>
      @endif
    </a>
    
    <!-- === MENU CV BARU === -->
    <a href="{{ route('admin.cv-builder') }}" class="{{ request()->routeIs('admin.cv-builder*') ? 'active' : '' }}">
      <div class="nav-icon">
        <svg viewBox="0 0 24 24" stroke="currentColor"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
      </div>
      CV Builder
    </a>
    
  </nav>

  <div class="sidebar-bottom">
    <div class="sidebar-user">
      <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
      <div class="user-info">
        <div class="ui-name">{{ Auth::user()->name }}</div>
        <div class="ui-role">Administrator</div>
      </div>
    </div>

    <div class="sidebar-bottom-links">
      <a href="{{ route('portfolio') }}" target="_blank">
        <div class="nav-icon">
          <svg viewBox="0 0 24 24" stroke="currentColor"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
        </div>
        Lihat Website
      </a>
      <a href="#" class="link-danger" onclick="event.preventDefault();document.getElementById('logoutForm').submit();">
        <div class="nav-icon">
          <svg viewBox="0 0 24 24" stroke="currentColor"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
        </div>
        Logout
      </a>
    </div>

    <div class="sidebar-version">Portfolio v1.0</div>
  </div>
</aside>

<form action="{{ route('logout') }}" method="POST" id="logoutForm" style="display:none">@csrf</form>

<!-- ========== MAIN ========== -->
<div class="main">
  <div class="topbar" id="topbar">
    <div class="topbar-left">
      <button class="mobile-toggle" id="mobileToggle" aria-label="Menu">
        <svg viewBox="0 0 24 24"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
      </button>
      <h1>@yield('pageTitle', 'Dashboard')</h1>
    </div>
    <div class="topbar-right">
      <a href="{{ route('portfolio') }}" target="_blank" class="topbar-visit">
        <svg viewBox="0 0 24 24"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
        <span class="visit-text">Lihat Website</span>
      </a>
      <div class="topbar-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
    </div>
  </div>

  <div class="content">
    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
      <div class="alert alert-error">{{ session('error') }}</div>
    @endif
    @yield('content')
  </div>
</div>

<script>
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('sidebarOverlay');
  const toggle = document.getElementById('mobileToggle');
  const topbar = document.getElementById('topbar');

  function openSidebar() {
    sidebar.classList.add('open');
    overlay.classList.add('show');
    document.body.style.overflow = 'hidden';
  }

  function closeSidebar() {
    sidebar.classList.remove('open');
    overlay.classList.remove('show');
    document.body.style.overflow = '';
  }

  toggle.addEventListener('click', () => {
    if (sidebar.classList.contains('open')) {
      closeSidebar();
    } else {
      openSidebar();
    }
  });

  window.addEventListener('scroll', () => {
    topbar.classList.toggle('scrolled', window.scrollY > 10);
  }, { passive: true });

  window.addEventListener('resize', () => {
    if (window.innerWidth > 768) {
      closeSidebar();
    }
  });
</script>

</body>
</html>