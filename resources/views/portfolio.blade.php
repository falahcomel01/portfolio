<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $settings['title'] ?? 'Ahmad Badrul Falah' }} — Frontend Developer</title>
  <link rel="icon" type="image/x-icon" href="{{ !empty($settings['favicon']) ? Storage::url($settings['favicon']) : asset('image/favicon.png') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <style>
    /* =============================================
       RESET & VARIABLES
       ============================================= */
    *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

    :root {
      --primary: #6366f1;
      --primary-dark: #4f46e5;
      --primary-light: #a5b4fc;
      --primary-ultra: #e0e7ff;
      --secondary: #ec4899;
      --secondary-light: #f9a8d4;
      --accent: #14b8a6;
      --accent-light: #5eead4;
      --text: #0f172a;
      --text-mid: #334155;
      --text-light: #64748b;
      --text-muted: #94a3b8;
      --bg: #ffffff;
      --bg-soft: #fafbff;
      --bg-warm: #f8f9fc;
      --border: #e2e8f0;
      --border-light: #f1f5f9;
      --shadow-xs: 0 1px 2px rgba(0,0,0,.04);
      --shadow-sm: 0 2px 8px rgba(0,0,0,.04);
      --shadow-md: 0 8px 30px rgba(0,0,0,.06);
      --shadow-lg: 0 20px 60px rgba(0,0,0,.08);
      --shadow-xl: 0 30px 80px rgba(0,0,0,.1);
      --shadow-glow: 0 0 40px rgba(99,102,241,.12);
      --gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      --gradient-soft: linear-gradient(135deg, #818cf8 0%, #c084fc 100%);
      --gradient-warm: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
      --gradient-cool: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
      --radius-sm: 8px;
      --radius-md: 16px;
      --radius-lg: 24px;
      --radius-xl: 32px;
    }

    html { scroll-behavior: smooth; }

    body {
      font-family: 'Inter', sans-serif;
      background: var(--bg);
      color: var(--text);
      line-height: 1.6;
      overflow-x: hidden;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
    }

    body::after {
      content: '';
      position: fixed;
      inset: 0;
      background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.03'/%3E%3C/svg%3E");
      pointer-events: none;
      z-index: 9990;
      opacity: .5;
    }

    /* =============================================
       CUSTOM CURSOR
       ============================================= */
    #cursor {
      width: 8px; height: 8px;
      background: var(--primary);
      border-radius: 50%;
      position: fixed;
      pointer-events: none;
      z-index: 9999;
      mix-blend-mode: difference;
      transition: transform .15s;
    }
    #cursor.hover { transform: scale(3); background: var(--secondary); }

    #cursorRing {
      width: 36px; height: 36px;
      border: 1.5px solid rgba(99,102,241,.4);
      border-radius: 50%;
      position: fixed;
      pointer-events: none;
      z-index: 9998;
      opacity: .6;
      transition: all .25s cubic-bezier(.4,0,.2,1);
    }
    #cursorRing.hover {
      transform: scale(1.8);
      border-color: rgba(236,72,153,.4);
      opacity: .3;
    }

    @media (max-width: 768px) {
      #cursor, #cursorRing { display: none; }
    }

    /* =============================================
       NAVIGATION
       ============================================= */
    #mainNav {
      position: fixed;
      top: 0;
      width: 100%;
      padding: 1rem 2rem;
      background: rgba(255,255,255,.6);
      backdrop-filter: blur(24px) saturate(1.5);
      z-index: 1000;
      transition: all .4s cubic-bezier(.4,0,.2,1);
      border-bottom: 1px solid transparent;
    }
    #mainNav.scrolled {
      padding: .7rem 2rem;
      background: rgba(255,255,255,.85);
      box-shadow: var(--shadow-sm);
      border-bottom-color: var(--border-light);
    }

    .nav-container {
      max-width: 1200px;
      margin: 0 auto;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .logo {
      font-size: 1.4rem;
      font-weight: 800;
      letter-spacing: -.02em;
      background: var(--gradient);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      text-decoration: none;
      position: relative;
    }
    .logo::after {
      content: '';
      position: absolute;
      bottom: -4px;
      left: 0; right: 0;
      height: 2px;
      background: var(--gradient);
      border-radius: 2px;
      transform: scaleX(0);
      transition: transform .3s;
      transform-origin: left;
    }
    .logo:hover::after { transform: scaleX(1); }

    .nav-links { display: flex; gap: 2rem; align-items: center; }
    .nav-links a {
      color: var(--text-mid);
      text-decoration: none;
      font-weight: 500;
      font-size: .9rem;
      position: relative;
      transition: color .3s;
      padding: .25rem 0;
    }
    .nav-links a:hover { color: var(--primary); }
    .nav-links a.active { color: var(--primary); }
    .nav-links a.active::after {
      content: '';
      position: absolute;
      bottom: -2px;
      left: 0; right: 0;
      height: 2px;
      background: var(--gradient);
      border-radius: 2px;
    }
    .nav-cta {
      background: var(--gradient) !important;
      color: #fff !important;
      padding: .6rem 1.4rem !important;
      border-radius: 50px;
      font-size: .9rem;
      box-shadow: 0 4px 15px rgba(99,102,241,.25);
      transition: all .3s !important;
    }
    .nav-cta:hover {
      transform: translateY(-2px) !important;
      box-shadow: 0 8px 25px rgba(99,102,241,.35) !important;
    }

    .hamburger {
      display: none;
      flex-direction: column;
      gap: 5px;
      cursor: pointer;
      background: none;
      border: none;
      padding: 6px;
      border-radius: 8px;
      transition: background .2s;
    }
    .hamburger:hover { background: var(--border-light); }
    .hamburger span {
      display: block;
      width: 22px; height: 2px;
      background: var(--text);
      transition: all .3s;
      border-radius: 2px;
    }
    .hamburger.active span:nth-child(1) { transform: rotate(45deg) translate(5px,5px); }
    .hamburger.active span:nth-child(2) { opacity: 0; transform: scaleX(0); }
    .hamburger.active span:nth-child(3) { transform: rotate(-45deg) translate(5px,-5px); }

    .mobile-menu {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(255,255,255,.97);
      backdrop-filter: blur(30px);
      z-index: 999;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      gap: 1.5rem;
    }
    .mobile-menu.open { display: flex; animation: fadeUp .3s ease; }
    @keyframes fadeUp { from { opacity: 0; } to { opacity: 1; } }
    .mobile-menu a {
      font-size: 1.6rem;
      font-weight: 700;
      color: var(--text);
      text-decoration: none;
      transition: all .3s;
      padding: .5rem 1rem;
      border-radius: 12px;
    }
    .mobile-menu a:hover { color: var(--primary); background: var(--primary-ultra); }

    @media (max-width: 768px) {
      .nav-links { display: none; }
      .hamburger { display: flex; }
    }

    /* =============================================
       HERO
       ============================================= */
    .hero {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 7rem 2rem 4rem;
      position: relative;
      overflow: hidden;
      background: linear-gradient(160deg, #fafbff 0%, #f0f0ff 30%, #fff5fb 60%, #fafbff 100%);
    }

    .hero-orb {
      position: absolute;
      border-radius: 50%;
      filter: blur(80px);
      opacity: .5;
      pointer-events: none;
    }
    .hero-orb-1 {
      width: 500px; height: 500px;
      top: -15%; right: -10%;
      background: radial-gradient(circle, rgba(99,102,241,.15), transparent 70%);
      animation: orbFloat1 18s ease-in-out infinite;
    }
    .hero-orb-2 {
      width: 400px; height: 400px;
      bottom: -10%; left: -5%;
      background: radial-gradient(circle, rgba(236,72,153,.1), transparent 70%);
      animation: orbFloat2 22s ease-in-out infinite;
    }
    .hero-orb-3 {
      width: 300px; height: 300px;
      top: 40%; left: 50%;
      background: radial-gradient(circle, rgba(20,184,166,.08), transparent 70%);
      animation: orbFloat3 15s ease-in-out infinite;
    }
    @keyframes orbFloat1 { 0%,100% { transform: translate(0,0); } 50% { transform: translate(-40px,30px); } }
    @keyframes orbFloat2 { 0%,100% { transform: translate(0,0); } 50% { transform: translate(30px,-40px); } }
    @keyframes orbFloat3 { 0%,100% { transform: translate(0,0); } 33% { transform: translate(-20px,-30px); } 66% { transform: translate(25px,15px); } }

    .hero-dots {
      position: absolute;
      inset: 0;
      background-image: radial-gradient(circle, rgba(99,102,241,.08) 1px, transparent 1px);
      background-size: 40px 40px;
      opacity: .6;
      pointer-events: none;
    }

    .hero-content {
      max-width: 1200px;
      width: 100%;
      margin: 0 auto;
      display: grid;
      grid-template-columns: 1.1fr .9fr;
      gap: 4rem;
      align-items: center;
      position: relative;
      z-index: 1;
    }

    .hero-badge {
      display: inline-flex;
      align-items: center;
      gap: .5rem;
      padding: .4rem 1rem;
      background: rgba(99,102,241,.08);
      border: 1px solid rgba(99,102,241,.15);
      border-radius: 50px;
      font-size: .85rem;
      font-weight: 600;
      color: var(--primary);
      margin-bottom: 1.5rem;
    }
    .hero-badge-dot {
      width: 8px; height: 8px;
      background: var(--accent);
      border-radius: 50%;
      animation: pulse 2s ease-in-out infinite;
    }
    @keyframes pulse { 0%,100% { opacity: 1; transform: scale(1); } 50% { opacity: .5; transform: scale(.8); } }

    .hero-text h1 {
      font-size: clamp(2.5rem, 5vw, 3.8rem);
      font-weight: 900;
      line-height: 1.05;
      margin-bottom: 1.5rem;
      letter-spacing: -.03em;
    }
    .hero-text h1 .typed-name {
      background: var(--gradient);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      border-right: 3px solid var(--primary);
      padding-right: 4px;
      animation: blink 1s step-end infinite;
    }
    @keyframes blink { 0%,100% { border-color: var(--primary); } 50% { border-color: transparent; } }

    .hero-text p {
      font-size: 1.15rem;
      color: var(--text-light);
      margin-bottom: 2rem;
      line-height: 1.8;
      max-width: 500px;
    }

    .hero-buttons { display: flex; gap: 1rem; flex-wrap: wrap; }

    /* =============================================
       BUTTONS (shared)
       ============================================= */
    .btn {
      padding: .85rem 1.8rem;
      border-radius: 50px;
      font-weight: 600;
      text-decoration: none;
      transition: all .35s cubic-bezier(.4,0,.2,1);
      display: inline-flex;
      align-items: center;
      gap: .5rem;
      border: none;
      cursor: pointer;
      font-size: .95rem;
      font-family: 'Inter', sans-serif;
      position: relative;
      overflow: hidden;
    }
    .btn-primary {
      background: var(--gradient);
      color: #fff;
      box-shadow: 0 4px 20px rgba(99,102,241,.3);
    }
    .btn-primary::before {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, rgba(255,255,255,.2), transparent);
      opacity: 0;
      transition: opacity .3s;
    }
    .btn-primary:hover::before { opacity: 1; }
    .btn-primary:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 30px rgba(99,102,241,.4);
    }
    .btn-outline {
      background: rgba(255,255,255,.8);
      color: var(--primary);
      border: 1.5px solid rgba(99,102,241,.3);
      backdrop-filter: blur(10px);
    }
    .btn-outline:hover {
      background: var(--primary);
      color: #fff;
      border-color: var(--primary);
      transform: translateY(-3px);
      box-shadow: 0 8px 30px rgba(99,102,241,.25);
    }

    /* Hero card & code */
    .hero-visual {
      position: relative;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .hero-card {
      background: rgba(255,255,255,.7);
      backdrop-filter: blur(20px);
      border-radius: var(--radius-lg);
      padding: 2rem;
      box-shadow: var(--shadow-lg);
      position: relative;
      overflow: hidden;
      border: 1px solid rgba(255,255,255,.8);
      transform: perspective(1000px) rotateY(-5deg) rotateX(2deg);
      transition: transform .5s cubic-bezier(.4,0,.2,1);
    }
    .hero-card:hover { transform: perspective(1000px) rotateY(0) rotateX(0); }

    .hero-card::before {
      content: '';
      position: absolute;
      inset: -2px;
      background: conic-gradient(from var(--card-angle, 0deg), #667eea, #764ba2, #ec4899, #14b8a6, #667eea);
      border-radius: var(--radius-lg);
      z-index: -1;
      animation: rotateBorder 6s linear infinite;
      opacity: .6;
    }
    @property --card-angle {
      syntax: '<angle>';
      initial-value: 0deg;
      inherits: false;
    }
    @keyframes rotateBorder { to { --card-angle: 360deg; } }

    .hero-card::after {
      content: '';
      position: absolute;
      inset: 1.5px;
      background: rgba(255,255,255,.95);
      border-radius: calc(var(--radius-lg) - 1.5px);
      z-index: -1;
    }

    .hero-code {
      font-family: 'Courier New', monospace;
      font-size: .88rem;
      color: var(--text-mid);
    }
    .code-line {
      margin: .6rem 0;
      opacity: 0;
      animation: fadeInUp .5s forwards;
    }
    .code-line:nth-child(1) { animation-delay: .1s; }
    .code-line:nth-child(2) { animation-delay: .25s; }
    .code-line:nth-child(3) { animation-delay: .4s; }
    .code-line:nth-child(4) { animation-delay: .55s; }
    .code-line:nth-child(5) { animation-delay: .7s; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }

    .code-keyword { color: #6366f1; font-weight: 700; }
    .code-string { color: #ec4899; }
    .code-function { color: #14b8a6; font-weight: 600; }

    .float-card {
      position: absolute;
      padding: .6rem 1rem;
      background: rgba(255,255,255,.85);
      backdrop-filter: blur(12px);
      border-radius: var(--radius-sm);
      box-shadow: var(--shadow-md);
      border: 1px solid rgba(255,255,255,.9);
      font-size: .8rem;
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: .4rem;
      animation: floatCard 4s ease-in-out infinite;
      pointer-events: none;
    }
    .float-card-1 { top: -15px; right: -20px; color: #6366f1; }
    .float-card-2 { bottom: -10px; left: -25px; animation-delay: 1.5s; color: #ec4899; }
    .float-card-3 { bottom: 30px; right: -30px; animation-delay: 3s; color: #14b8a6; }
    @keyframes floatCard { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-8px); } }

    .float-dot { width: 8px; height: 8px; border-radius: 50%; }
    .float-dot-1 { background: rgba(99,102,241,.2); }
    .float-dot-2 { background: rgba(236,72,153,.2); }
    .float-dot-3 { background: rgba(20,184,166,.2); }

    /* =============================================
       TECH MARQUEE
       ============================================= */
    .tech-marquee {
      background: var(--bg-soft);
      padding: 1.8rem 0;
      overflow: hidden;
      border-top: 1px solid var(--border-light);
      border-bottom: 1px solid var(--border-light);
      position: relative;
    }
    .tech-marquee::before,
    .tech-marquee::after {
      content: '';
      position: absolute;
      top: 0; bottom: 0;
      width: 80px;
      z-index: 2;
    }
    .tech-marquee::before { left: 0; background: linear-gradient(to right, var(--bg-soft), transparent); }
    .tech-marquee::after { right: 0; background: linear-gradient(to left, var(--bg-soft), transparent); }

    .marquee-track { display: flex; animation: marquee 35s linear infinite; }
    @keyframes marquee { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }

    .marquee-item {
      display: flex;
      align-items: center;
      gap: .7rem;
      padding: 0 1.8rem;
      white-space: nowrap;
      color: var(--text-light);
      font-weight: 500;
      font-size: .9rem;
    }
    .tech-icon {
      width: 32px; height: 32px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: #fff;
      border-radius: 8px;
      box-shadow: var(--shadow-xs);
      overflow: hidden;
      padding: 5px;
    }
    .tech-icon img { width: 100%; height: 100%; object-fit: contain; display: block; }

    /* =============================================
       SECTIONS (shared)
       ============================================= */
    .section-wrap { max-width: 1200px; margin: 0 auto; padding: 7rem 2rem; }

    .section-tag {
      display: inline-flex;
      align-items: center;
      gap: .4rem;
      padding: .45rem 1.1rem;
      background: linear-gradient(135deg, rgba(99,102,241,.08), rgba(236,72,153,.08));
      color: var(--primary);
      border-radius: 50px;
      font-size: .82rem;
      font-weight: 600;
      margin-bottom: 1.2rem;
      border: 1px solid rgba(99,102,241,.1);
    }
    .section-tag::before {
      content: '';
      width: 6px; height: 6px;
      background: var(--primary);
      border-radius: 50%;
    }

    .section-title {
      font-size: clamp(2rem, 4vw, 2.8rem);
      font-weight: 800;
      margin-bottom: .8rem;
      line-height: 1.15;
      letter-spacing: -.02em;
    }
    .section-desc { font-size: 1.05rem; color: var(--text-light); max-width: 550px; line-height: 1.7; }

    .gradient-text {
      background: var(--gradient);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }
    .underline-text { position: relative; display: inline-block; }
    .underline-text::after {
      content: '';
      position: absolute;
      bottom: 2px; left: 0; right: 0;
      height: 10px;
      background: linear-gradient(90deg, rgba(99,102,241,.15), rgba(236,72,153,.15), transparent);
      border-radius: 4px;
    }

    /* =============================================
       ABOUT
       ============================================= */
    .about-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 5rem;
      margin-top: 3rem;
      align-items: center;
    }
    .about-text { font-size: 1.05rem; line-height: 1.9; color: var(--text-mid); }
    .about-text strong { color: var(--text); font-weight: 600; }
    .about-text p { margin-bottom: 1rem; }

    .about-visual {
      position: relative;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .avatar-box {
      position: relative;
      width: 300px; height: 300px;
      border-radius: var(--radius-lg);
      overflow: hidden;
      background: var(--gradient);
      padding: 3px;
      box-shadow: var(--shadow-lg);
      transition: transform .4s cubic-bezier(.4,0,.2,1);
    }
    .avatar-box:hover { transform: scale(1.03) rotate(1deg); }

    .avatar-link {
      display: block;
      width: 100%; height: 100%;
      border-radius: calc(var(--radius-lg) - 3px);
      overflow: hidden;
      background: #fff;
    }
    .avatar-link img {
      width: 100%; height: 100%;
      object-fit: cover;
      transition: transform .5s cubic-bezier(.4,0,.2,1);
    }
    .avatar-link:hover img { transform: scale(1.08); }

    .corner-deco {
      position: absolute;
      width: 50px; height: 50px;
      border: 2px solid var(--primary-light);
      opacity: .4;
      transition: opacity .3s;
    }
    .avatar-box:hover ~ .corner-deco { opacity: .8; }
    .corner-deco.tl { top: -15px; left: -15px; border-right: none; border-bottom: none; border-radius: 4px 0 0 0; }
    .corner-deco.tr { top: -15px; right: -15px; border-left: none; border-bottom: none; border-radius: 0 4px 0 0; }
    .corner-deco.bl { bottom: -15px; left: -15px; border-right: none; border-top: none; border-radius: 0 0 0 4px; }
    .corner-deco.br { bottom: -15px; right: -15px; border-left: none; border-top: none; border-radius: 0 0 4px 0; }

    .about-badge {
      position: absolute;
      bottom: -15px; right: -15px;
      background: #fff;
      padding: .6rem 1.2rem;
      border-radius: var(--radius-sm);
      box-shadow: var(--shadow-md);
      font-size: .82rem;
      font-weight: 600;
      color: var(--primary);
      display: flex;
      align-items: center;
      gap: .4rem;
      border: 1px solid var(--border-light);
      z-index: 2;
      animation: floatCard 3s ease-in-out infinite;
    }
    .about-badge svg { width: 16px; height: 16px; }

    /* =============================================
       SKILLS
       ============================================= */
    .skills-bg {
      background: linear-gradient(180deg, var(--bg-soft) 0%, #fff 100%);
      position: relative;
    }
    .skills-bg::before {
      content: '';
      position: absolute;
      top: 0; left: 50%;
      transform: translateX(-50%);
      width: 600px; height: 600px;
      background: radial-gradient(circle, rgba(99,102,241,.04), transparent 70%);
      pointer-events: none;
    }

    .skills-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
      gap: 1.5rem;
      margin-top: 3rem;
    }

    .skill-card {
      background: rgba(255,255,255,.8);
      backdrop-filter: blur(10px);
      padding: 1.8rem;
      border-radius: var(--radius-md);
      box-shadow: var(--shadow-sm);
      transition: all .4s cubic-bezier(.4,0,.2,1);
      border: 1px solid var(--border-light);
      position: relative;
      overflow: hidden;
    }
    .skill-card::before {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0;
      height: 3px;
      background: var(--gradient);
      transform: scaleX(0);
      transition: transform .4s;
      transform-origin: left;
    }
    .skill-card::after {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, rgba(99,102,241,.03), rgba(236,72,153,.03));
      opacity: 0;
      transition: opacity .4s;
    }
    .skill-card:hover {
      transform: translateY(-6px);
      box-shadow: var(--shadow-lg);
      border-color: rgba(99,102,241,.15);
    }
    .skill-card:hover::before { transform: scaleX(1); }
    .skill-card:hover::after { opacity: 1; }
    .skill-card > * { position: relative; z-index: 1; }

    .skill-icon {
      width: 48px; height: 48px;
      background: var(--bg-soft);
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 1rem;
      overflow: hidden;
      border: 1px solid var(--border-light);
      transition: all .3s;
    }
    .skill-card:hover .skill-icon { background: var(--primary-ultra); border-color: rgba(99,102,241,.2); }
    .skill-icon img { width: 28px; height: 28px; object-fit: contain; }

    .skill-name { font-size: 1.15rem; font-weight: 700; margin-bottom: .4rem; letter-spacing: -.01em; }
    .skill-desc { color: var(--text-light); margin-bottom: 1rem; line-height: 1.65; font-size: .92rem; }

    .skill-tags { display: flex; flex-wrap: wrap; gap: .4rem; }
    .tag {
      padding: .25rem .7rem;
      background: var(--bg-soft);
      color: var(--text-light);
      border-radius: 50px;
      font-size: .78rem;
      font-weight: 500;
      border: 1px solid var(--border-light);
      transition: all .2s;
    }
    .skill-card:hover .tag { border-color: rgba(99,102,241,.15); color: var(--text-mid); }

    /* =============================================
       PROJECTS
       ============================================= */
    .projects-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(340px, 1fr));
      gap: 2rem;
      margin-top: 3rem;
    }

    .project-card {
      background: #fff;
      border-radius: var(--radius-md);
      overflow: hidden;
      box-shadow: var(--shadow-sm);
      transition: all .4s cubic-bezier(.4,0,.2,1);
      border: 1px solid var(--border-light);
      position: relative;
    }
    .project-card:hover { transform: translateY(-8px); box-shadow: var(--shadow-xl); }

    .project-thumb {
      position: relative;
      height: 210px;
      background: var(--bg-soft);
      overflow: hidden;
    }
    .project-thumb-overlay {
      position: absolute;
      inset: 0;
      background: linear-gradient(180deg, transparent 50%, rgba(0,0,0,.3));
      opacity: 0;
      transition: opacity .4s;
      z-index: 1;
    }
    .project-card:hover .project-thumb-overlay { opacity: 1; }
    .project-thumb img {
      width: 100%; height: 100%;
      object-fit: cover;
      transition: transform .5s cubic-bezier(.4,0,.2,1);
    }
    .project-card:hover .project-thumb img { transform: scale(1.08); }
    .project-thumb-inner {
      width: 100%; height: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 3.5rem;
      background: var(--gradient);
      color: #fff;
    }

    .project-info { padding: 1.5rem 1.5rem 1.6rem; }
    .project-num { color: var(--primary-light); font-family: 'Courier New', monospace; font-size: .82rem; margin-bottom: .4rem; font-weight: 600; }
    .project-title { font-size: 1.2rem; font-weight: 700; margin-bottom: .4rem; letter-spacing: -.01em; }
    .project-desc { color: var(--text-light); margin-bottom: 1rem; line-height: 1.65; font-size: .92rem; }
    .project-footer { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: .5rem; }

    .project-link {
      color: var(--primary);
      text-decoration: none;
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: .3rem;
      transition: all .3s;
      font-size: .9rem;
    }
    .project-link:hover { gap: .6rem; color: var(--primary-dark); }

    /* =============================================
       CERTIFICATES
       ============================================= */
    .certs-bg {
      background: linear-gradient(180deg, #fff 0%, var(--bg-soft) 100%);
      position: relative;
    }

    .certs-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
      gap: 1.75rem;
      margin-top: 3rem;
    }

    .cert-card {
      background: #fff;
      border-radius: var(--radius-md);
      overflow: hidden;
      box-shadow: var(--shadow-sm);
      transition: all .4s cubic-bezier(.4,0,.2,1);
      border: 1px solid var(--border-light);
      position: relative;
    }
    .cert-card:hover { transform: translateY(-8px); box-shadow: var(--shadow-xl); }
    .cert-card::before {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0;
      height: 3px;
      background: linear-gradient(90deg, var(--primary), var(--secondary));
      transform: scaleX(0);
      transition: transform .4s;
      transform-origin: left;
      z-index: 2;
    }
    .cert-card:hover::before { transform: scaleX(1); }

    .cert-thumb {
      position: relative;
      height: 200px;
      background: var(--bg-soft);
      overflow: hidden;
    }
    .cert-thumb img {
      width: 100%; height: 100%;
      object-fit: cover;
      transition: transform .5s cubic-bezier(.4,0,.2,1);
      filter: saturate(.9);
    }
    .cert-card:hover .cert-thumb img { transform: scale(1.08); filter: saturate(1); }

    .cert-thumb-overlay {
      position: absolute;
      inset: 0;
      background: linear-gradient(180deg, transparent 40%, rgba(0,0,0,.25));
      opacity: 0;
      transition: opacity .4s;
      z-index: 1;
    }
    .cert-card:hover .cert-thumb-overlay { opacity: 1; }

    .cert-verify-badge {
      position: absolute;
      bottom: 12px; right: 12px;
      z-index: 2;
      display: flex;
      align-items: center;
      gap: .35rem;
      padding: .4rem .75rem;
      border-radius: 50px;
      background: rgba(255,255,255,.92);
      backdrop-filter: blur(8px);
      font-size: .72rem;
      font-weight: 600;
      color: var(--primary);
      box-shadow: var(--shadow-sm);
      transition: all .3s;
      text-decoration: none;
      opacity: 0;
      transform: translateY(8px);
    }
    .cert-card:hover .cert-verify-badge { opacity: 1; transform: translateY(0); }
    .cert-verify-badge:hover { background: var(--primary); color: #fff; }
    .cert-verify-badge:hover svg { stroke: #fff; }
    .cert-verify-badge svg {
      width: 12px; height: 12px;
      stroke: var(--primary);
      fill: none;
      stroke-width: 2;
      stroke-linecap: round;
      stroke-linejoin: round;
      transition: stroke .3s;
    }

    .cert-info { padding: 1.35rem 1.5rem 1.5rem; }
    .cert-meta { display: flex; align-items: center; gap: .6rem; margin-bottom: .65rem; }

    .cert-issuer-badge {
      display: inline-flex;
      align-items: center;
      gap: .3rem;
      padding: .2rem .6rem;
      border-radius: 50px;
      background: linear-gradient(135deg, rgba(99,102,241,.08), rgba(236,72,153,.08));
      color: var(--primary);
      font-size: .72rem;
      font-weight: 600;
      border: 1px solid rgba(99,102,241,.1);
    }
    .cert-issuer-badge svg {
      width: 11px; height: 11px;
      stroke: var(--primary);
      fill: none;
      stroke-width: 2;
      stroke-linecap: round;
      stroke-linejoin: round;
    }
    .cert-date-badge { font-size: .72rem; color: var(--text-muted); font-weight: 500; margin-left: auto; }
    .cert-title { font-size: 1.1rem; font-weight: 700; margin-bottom: .3rem; letter-spacing: -.01em; line-height: 1.35; }
    .cert-card:hover .cert-title { color: var(--primary); }

    .cert-empty { text-align: center; padding: 4rem 2rem; color: var(--text-light); }
    .cert-empty svg { width: 48px; height: 48px; stroke: var(--border); fill: none; stroke-width: 1.5; margin-bottom: 1rem; }
    .cert-empty p { font-size: .95rem; }

    /* =============================================
       CONTACT
       ============================================= */
    .contact-bg {
      background: linear-gradient(160deg, #fafbff 0%, #f0edff 40%, #fff5fb 100%);
      position: relative;
      overflow: hidden;
    }
    .contact-bg .orb-c {
      position: absolute;
      width: 900px; height: 900px;
      background: radial-gradient(circle, rgba(99,102,241,.1), transparent 70%);
      border-radius: 50%;
      top: -450px; right: -350px;
      animation: orbFloat1 18s ease-in-out infinite;
      pointer-events: none;
    }
    .contact-bg .orb-c2 {
      position: absolute;
      width: 750px; height: 750px;
      background: radial-gradient(circle, rgba(236,72,153,.08), transparent 70%);
      border-radius: 50%;
      bottom: -375px; left: -300px;
      animation: orbFloat2 22s ease-in-out infinite;
      pointer-events: none;
    }
    .contact-bg .contact-dots {
      position: absolute;
      inset: 0;
      background-image: radial-gradient(circle, rgba(99,102,241,.06) 1px, transparent 1px);
      background-size: 32px 32px;
      pointer-events: none;
    }

    .contact-inner {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 4rem;
      position: relative;
      z-index: 1;
      align-items: center;
    }
    .contact-big-title {
      font-size: clamp(2rem, 4vw, 3.2rem);
      font-weight: 900;
      line-height: 1.1;
      margin-bottom: 1.5rem;
      letter-spacing: -.03em;
    }
    .contact-big-title .highlight {
      background: var(--gradient);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }
    .contact-desc { font-size: 1.05rem; color: var(--text-light); margin-bottom: 2rem; line-height: 1.8; }

    .contact-socials { display: flex; gap: .7rem; flex-wrap: wrap; }
    .contact-socials a {
      padding: .7rem 1.3rem;
      background: rgba(255,255,255,.8);
      color: var(--text-mid);
      text-decoration: none;
      border-radius: 50px;
      font-weight: 500;
      font-size: .88rem;
      display: flex;
      align-items: center;
      gap: .4rem;
      transition: all .3s;
      box-shadow: var(--shadow-xs);
      border: 1px solid var(--border-light);
      backdrop-filter: blur(10px);
    }
    .contact-socials a:hover {
      background: var(--primary);
      color: #fff;
      transform: translateY(-3px);
      box-shadow: 0 8px 25px rgba(99,102,241,.3);
      border-color: var(--primary);
    }
    .contact-socials a:hover svg { fill: #fff; }

    .wa-link { background: #25D366 !important; color: #fff !important; border-color: #25D366 !important; }
    .wa-link:hover { background: #128C7E !important; border-color: #128C7E !important; box-shadow: 0 8px 25px rgba(37,211,102,.3) !important; }

    .contact-form {
      background: rgba(255,255,255,.85);
      backdrop-filter: blur(20px);
      padding: 2rem;
      border-radius: var(--radius-md);
      box-shadow: var(--shadow-lg);
      border: 1px solid rgba(255,255,255,.9);
    }

    .form-group { margin-bottom: 1.3rem; }
    .form-group label { display: block; margin-bottom: .4rem; font-weight: 600; color: var(--text-mid); font-size: .9rem; }
    .form-group input,
    .form-group textarea {
      width: 100%;
      padding: .8rem 1rem;
      border: 1.5px solid var(--border);
      border-radius: var(--radius-sm);
      font-size: .95rem;
      transition: all .3s;
      background: var(--bg-soft);
      font-family: 'Inter', sans-serif;
      color: var(--text);
    }
    .form-group input::placeholder,
    .form-group textarea::placeholder { color: var(--text-muted); }
    .form-group input:focus,
    .form-group textarea:focus {
      outline: none;
      border-color: var(--primary);
      background: #fff;
      box-shadow: 0 0 0 3px rgba(99,102,241,.1);
    }
    .form-group textarea { min-height: 120px; resize: vertical; }

    .btn-send {
      width: 100%;
      background: var(--gradient);
      color: #fff;
      padding: 1rem;
      border: none;
      border-radius: var(--radius-sm);
      font-size: .95rem;
      font-weight: 600;
      cursor: pointer;
      transition: all .35s;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: .5rem;
      font-family: 'Inter', sans-serif;
      position: relative;
      overflow: hidden;
    }
    .btn-send::before {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, rgba(255,255,255,.15), transparent);
      opacity: 0;
      transition: opacity .3s;
    }
    .btn-send:hover::before { opacity: 1; }
    .btn-send:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(99,102,241,.35); }

    /* =============================================
       FOOTER
       ============================================= */
    footer {
      background: #fff;
      padding: 2.5rem 2rem;
      text-align: center;
      border-top: 1px solid var(--border-light);
      position: relative;
    }
    footer::before {
      content: '';
      position: absolute;
      top: 0; left: 50%;
      transform: translateX(-50%);
      width: 200px; height: 2px;
      background: var(--gradient);
      border-radius: 2px;
    }
    footer p { color: var(--text-muted); margin-bottom: 1rem; font-size: .9rem; }

    .social-links { display: flex; justify-content: center; gap: .5rem; }
    .social-links a {
      color: var(--text-light);
      text-decoration: none;
      padding: .5rem .8rem;
      border-radius: var(--radius-sm);
      transition: all .3s;
      display: flex;
      align-items: center;
      gap: .3rem;
      font-size: .85rem;
      font-weight: 500;
    }
    .social-links a:hover { background: var(--primary-ultra); color: var(--primary); }
    .social-links a:hover svg { fill: var(--primary); }

    /* =============================================
       UTILITIES
       ============================================= */
    .reveal {
      opacity: 0;
      transform: translateY(30px);
      transition: all .7s cubic-bezier(.4,0,.2,1);
    }
    .reveal.visible { opacity: 1; transform: translateY(0); }

    .flash {
      position: fixed;
      top: 100px; right: 20px;
      padding: 1rem 1.5rem;
      background: rgba(255,255,255,.95);
      backdrop-filter: blur(12px);
      border-radius: var(--radius-sm);
      box-shadow: var(--shadow-lg);
      z-index: 2000;
      animation: slideIn .4s cubic-bezier(.4,0,.2,1);
      max-width: 320px;
      border-left: 4px solid var(--primary);
      font-size: .92rem;
      font-weight: 500;
    }
    .flash.success { border-left-color: #10b981; color: #059669; }
    .flash.error { border-left-color: #ef4444; color: #dc2626; }
    @keyframes slideIn { from { transform: translateX(120%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }

    /* =============================================
       RESPONSIVE — TABLET
       ============================================= */
    @media (max-width: 1024px) {
      .hero-content { gap: 3rem; }
      .about-grid { gap: 3rem; }
      .contact-inner { gap: 3rem; }
      .projects-grid { grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; }
      .certs-grid { grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem; }
      .skills-grid { grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.25rem; }
    }

    /* =============================================
       RESPONSIVE — MOBILE LANDSCAPE
       ============================================= */
    @media (max-width: 768px) {
      .section-wrap { padding: 5rem 1.25rem; }
      .section-title { font-size: clamp(1.75rem, 5vw, 2.4rem); }

      .hero { padding: 6rem 1.25rem 3.5rem; }
      .hero-content { grid-template-columns: 1fr; text-align: center; gap: 2.5rem; }
      .hero-text p { margin-left: auto; margin-right: auto; }
      .hero-buttons { justify-content: center; }
      .hero-visual { order: 2; }
      .float-card { display: none; }

      .about-grid { grid-template-columns: 1fr; gap: 2.5rem; }
      .about-visual { order: -1; }
      .avatar-box { width: 220px; height: 220px; }
      .about-badge { bottom: -10px; right: -10px; font-size: .75rem; padding: .4rem .8rem; }
      .about-text { font-size: .98rem; }

      .skills-grid { grid-template-columns: 1fr; gap: 1.25rem; }
      .skill-card { padding: 1.5rem; }

      .projects-grid { grid-template-columns: 1fr; gap: 1.5rem; }
      .project-thumb { height: 200px; }
      .project-info { padding: 1.25rem; }

      .certs-grid { grid-template-columns: 1fr; gap: 1.5rem; }
      .cert-thumb { aspect-ratio: 16/10; }
      .cert-info { padding: 1.15rem 1.25rem; }

      .contact-inner { grid-template-columns: 1fr; gap: 2.5rem; }
      .contact-big-title { font-size: clamp(1.75rem, 5vw, 2.4rem); }
      .contact-desc { font-size: .98rem; }
      .contact-form { padding: 1.5rem; }
      .contact-bg .orb-c { width: 500px; height: 500px; top: -250px; right: -200px; }
      .contact-bg .orb-c2 { width: 400px; height: 400px; bottom: -200px; left: -150px; }

      footer { padding: 2rem 1.25rem; }
    }

    /* =============================================
       RESPONSIVE — MOBILE PORTRAIT
       ============================================= */
    @media (max-width: 480px) {
      .section-wrap { padding: 4rem 1rem; }
      .section-tag { font-size: .76rem; padding: .35rem .9rem; }
      .section-desc { font-size: .92rem; }

      .hero { padding: 5.5rem 1rem 3rem; min-height: auto; }
      .hero-badge { font-size: .78rem; padding: .35rem .85rem; }
      .hero-text h1 { margin-bottom: 1.25rem; }
      .hero-text p { font-size: 1rem; margin-bottom: 1.5rem; }
      .hero-buttons { flex-direction: column; align-items: stretch; gap: .75rem; }
      .btn { width: 100%; justify-content: center; padding: .8rem 1.5rem; font-size: .9rem; }
      .hero-card { padding: 1.5rem; }
      .hero-code { font-size: .8rem; }
      .code-line { margin: .5rem 0; }

      .tech-marquee { padding: 1.2rem 0; }
      .marquee-item { padding: 0 1.2rem; font-size: .82rem; }
      .tech-icon { width: 28px; height: 28px; padding: 4px; }

      .about-grid { gap: 2rem; }
      .about-visual { justify-content: center; }
      .avatar-box { width: 180px; height: 180px; }
      .about-badge { bottom: -8px; right: -8px; padding: .35rem .7rem; font-size: .7rem; }
      .about-text { font-size: .92rem; line-height: 1.8; }
      .corner-deco { width: 35px; height: 35px; }
      .corner-deco.tl { top: -10px; left: -10px; }
      .corner-deco.tr { top: -10px; right: -10px; }
      .corner-deco.bl { bottom: -10px; left: -10px; }
      .corner-deco.br { bottom: -10px; right: -10px; }

      .skill-card { padding: 1.25rem; }
      .skill-icon { width: 40px; height: 40px; border-radius: 10px; margin-bottom: .85rem; }
      .skill-icon img { width: 24px; height: 24px; }
      .skill-name { font-size: 1.05rem; }
      .skill-desc { font-size: .85rem; margin-bottom: .85rem; }
      .skill-tags { gap: .3rem; }
      .tag { padding: .2rem .6rem; font-size: .73rem; }

      .project-thumb { height: 180px; }
      .project-info { padding: 1.1rem; }
      .project-num { font-size: .76rem; }
      .project-title { font-size: 1.05rem; }
      .project-desc { font-size: .85rem; margin-bottom: .85rem; }
      .project-footer { gap: .4rem; }

      .certs-grid { gap: 1.25rem; }
      .cert-thumb { aspect-ratio: 16/9; border-radius: calc(var(--radius-md) - 1px); }
      .cert-info { padding: 1rem 1.15rem; }
      .cert-issuer-badge { font-size: .68rem; padding: .18rem .5rem; }
      .cert-issuer-badge svg { width: 10px; height: 10px; }
      .cert-date-badge { font-size: .68rem; }
      .cert-title { font-size: 1rem; }
      .cert-verify-badge { font-size: .66rem; padding: .3rem .6rem; bottom: 8px; right: 8px; }
      .cert-verify-badge svg { width: 10px; height: 10px; }

      .contact-form { padding: 1.25rem; }
      .form-group input, .form-group textarea { padding: .7rem .85rem; font-size: .9rem; }
      .form-group label { font-size: .85rem; }
      .btn-send { padding: .85rem; font-size: .9rem; }
      .contact-socials { gap: .5rem; }
      .contact-socials a { padding: .6rem 1.1rem; font-size: .82rem; }

      footer { padding: 1.75rem 1rem; }
      footer p { font-size: .82rem; }
      .social-links a { padding: .4rem .65rem; font-size: .8rem; }
    }

    /* =============================================
       RESPONSIVE — VERY SMALL
       ============================================= */
    @media (max-width: 360px) {
      .section-wrap { padding: 3.5rem .85rem; }
      .hero { padding: 5rem .85rem 2.5rem; }
      .hero-badge { font-size: .74rem; }
      .hero-text h1 { font-size: 2rem; }
      .hero-text p { font-size: .9rem; }
      .hero-card { padding: 1.25rem; }
      .hero-code { font-size: .74rem; }
      .avatar-box { width: 160px; height: 160px; }
      .skill-card { padding: 1.1rem; }
      .skill-name { font-size: 1rem; }
      .project-thumb { height: 160px; }
      .project-title { font-size: 1rem; }
      .cert-thumb { aspect-ratio: 16/9; }
      .cert-title { font-size: .95rem; }
      .contact-socials a { padding: .5rem .9rem; font-size: .78rem; }
    }

    /* =============================================
       RESPONSIVE — LANDSCAPE PHONE
       ============================================= */
    @media (max-height: 500px) and (orientation: landscape) {
      .hero { min-height: auto; padding: 4rem 1.25rem 2rem; }
      .hero-content { gap: 1.5rem; }
      .hero-text h1 { font-size: 2rem; }
      .hero-text p { display: none; }
      .hero-buttons { gap: .5rem; }
      .hero-card { padding: 1rem; }
      .hero-code { font-size: .75rem; }
      .code-line { margin: .4rem 0; }
      .float-card { display: none; }
    }
  </style>
</head>
<body>

  <!-- Custom Cursor -->
  <div id="cursor"></div>
  <div id="cursorRing"></div>

  <!-- Navigation -->
  <nav id="mainNav">
    <div class="nav-container">
      <a href="#home" class="logo">{{ $settings['name'] ?? 'Falah' }}</a>
      <div class="nav-links">
        <a href="#about" data-section="about">About</a>
        <a href="#projects" data-section="projects">Projects</a>
        <a href="#certificates" data-section="certificates">Certificates</a>
        <a href="#skills" data-section="skills">Skills</a>
        <a href="#contact" data-section="contact" class="nav-cta">Contact</a>
      </div>
      <button class="hamburger" id="hamburgerBtn" aria-label="Menu">
        <span></span><span></span><span></span>
      </button>
    </div>
  </nav>

  <!-- Mobile Menu -->
  <div class="mobile-menu" id="mobileMenu">
    <a href="#home" class="mobile-link">Home</a>
    <a href="#about" class="mobile-link">About</a>
    <a href="#projects" class="mobile-link">Projects</a>
    <a href="#certificates" class="mobile-link">Certificates</a>
    <a href="#skills" class="mobile-link">Skills</a>
    <a href="#contact" class="mobile-link">Contact</a>
  </div>

  <!-- Flash Messages -->
  @if(session('success'))
    <div class="flash success">{{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="flash error">{{ session('error') }}</div>
  @endif
  @if($errors->any())
    @foreach($errors->all() as $error)
      <div class="flash error">{{ $error }}</div>
    @endforeach
  @endif

  <!-- ======================== HERO ======================== -->
  <section class="hero" id="home">
    <div class="hero-orb hero-orb-1"></div>
    <div class="hero-orb hero-orb-2"></div>
    <div class="hero-orb hero-orb-3"></div>
    <div class="hero-dots"></div>
    <div class="hero-content">
      <div class="hero-text reveal">
        <div class="hero-badge">
          <span class="hero-badge-dot"></span>
          {{ $settings['hero_badge'] ?? 'Available for work' }}
        </div>
        <h1>Hi, I'm<br><span class="typed-name" id="typingName"></span></h1>
        <p>{{ $settings['hero_desc'] ?? 'Frontend Developer passionate about creating beautiful, responsive, and user-friendly web experiences.' }}</p>
        <div class="hero-buttons">
          <a href="#contact" class="btn btn-primary">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            Get In Touch
          </a>
          <a href="#projects" class="btn btn-outline">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
            View Projects
          </a>
        </div>
      </div>
      <div class="hero-visual reveal" style="transition-delay:.2s">
        <div class="float-card float-card-1"><span class="float-dot float-dot-1"></span>React.js</div>
        <div class="float-card float-card-2"><span class="float-dot float-dot-2"></span>Clean Code</div>
        <div class="float-card float-card-3"><span class="float-dot float-dot-3"></span>UI/UX</div>
        <div class="hero-card">
          <div class="hero-code">
            <div class="code-line"><span class="code-keyword">const</span> <span class="code-function">developer</span> = {</div>
            <div class="code-line">&nbsp;&nbsp;<span class="code-string">name</span>: <span class="code-string">"{{ $settings['name'] ?? 'Ahmad Badrul Falah' }}"</span>,</div>
            <div class="code-line">&nbsp;&nbsp;<span class="code-string">role</span>: <span class="code-string">"{{ $settings['role'] ?? 'Frontend Developer' }}"</span>,</div>
            <div class="code-line">&nbsp;&nbsp;<span class="code-string">passion</span>: <span class="code-string">"{{ $settings['passion'] ?? 'Beautiful Code' }}"</span></div>
            <div class="code-line">};</div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ======================== TECH MARQUEE ======================== -->
  <div class="tech-marquee">
    <div class="marquee-track">
      @php
        $techs = [
          ['name' => 'JavaScript', 'img' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/javascript/javascript-original.svg'],
          ['name' => 'React',      'img' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/react/react-original.svg'],
          ['name' => 'Vue.js',     'img' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/vuejs/vuejs-original.svg'],
          ['name' => 'Next.js',    'img' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/nextjs/nextjs-original.svg'],
          ['name' => 'TypeScript', 'img' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/typescript/typescript-original.svg'],
          ['name' => 'HTML5',      'img' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/html5/html5-original.svg'],
          ['name' => 'CSS3',       'img' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/css3/css3-original.svg'],
          ['name' => 'Tailwind',   'img' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/tailwindcss/tailwindcss-original.svg'],
          ['name' => 'PHP',        'img' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/php/php-original.svg'],
          ['name' => 'Laravel',    'img' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/laravel/laravel-original.svg'],
          ['name' => 'Node.js',    'img' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/nodejs/nodejs-original.svg'],
          ['name' => 'Git',        'img' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/git/git-original.svg'],
          ['name' => 'Figma',      'img' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/figma/figma-original.svg'],
          ['name' => 'Python',     'img' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/python/python-original.svg'],
          ['name' => 'Vite',       'img' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/vitejs/vitejs-original.svg'],
        ];
      @endphp
      @foreach(array_merge($techs, $techs) as $tech)
        <div class="marquee-item">
          <div class="tech-icon"><img src="{{ $tech['img'] }}" alt="{{ $tech['name'] }}" loading="lazy"></div>
          {{ $tech['name'] }}
        </div>
      @endforeach
    </div>
  </div>

  <!-- ======================== ABOUT ======================== -->
  <div class="section-wrap" id="about">
    <div class="reveal">
      <div class="section-tag">About Me</div>
      <h2 class="section-title">Passionate about<br><span class="gradient-text">beautiful code.</span></h2>
    </div>
    <div class="about-grid reveal">
      <div class="about-text">
        @if($about && $about->content)
          {!! $about->content !!}
        @else
          <p>Tentang saya belum diisi. Silakan update melalui admin panel.</p>
        @endif
      </div>
      <div class="about-visual">
        <div class="avatar-box">
          <a href="{{ $settings['avatar_link'] ?? '#' }}" class="avatar-link" target="_blank">
            <img src="{{ !empty($settings['avatar']) ? Storage::url($settings['avatar']) : asset('image/fotosaya.png') }}"
                 alt="{{ $settings['name'] ?? 'Ahmad Badrul Falah' }}" loading="lazy">
          </a>
        </div>
        <div class="about-badge">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
          Open to Collaborate
        </div>
        <div class="corner-deco tl"></div>
        <div class="corner-deco tr"></div>
        <div class="corner-deco bl"></div>
        <div class="corner-deco br"></div>
      </div>
    </div>
  </div>

  <!-- ======================== PROJECTS ======================== -->
  <div class="section-wrap" id="projects">
    <div class="reveal">
      <div class="section-tag">Work</div>
      <h2 class="section-title">Selected <span class="gradient-text">Projects</span></h2>
      <p class="section-desc">Beberapa project pilihan yang telah saya kerjakan.</p>
    </div>
    <div class="projects-grid">
      @if($projects->count())
        @foreach($projects as $i => $project)
          <div class="project-card reveal" style="transition-delay:{{ $i * 0.1 }}s">
            <div class="project-thumb">
              <div class="project-thumb-overlay"></div>
              @if($project->thumbnail)
                <img src="{{ Storage::url($project->thumbnail) }}" alt="{{ $project->title }}" loading="lazy">
              @else
                <div class="project-thumb-inner">{{ $project->icon ?? '🌐' }}</div>
              @endif
            </div>
            <div class="project-info">
              <div class="project-num">// {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</div>
              <div class="project-title">{{ $project->title }}</div>
              <div class="project-desc">{{ $project->description }}</div>
              <div class="project-footer">
                <div class="skill-tags">
                  @foreach(explode(',', $project->tags ?? '') as $tag)
                    @if(trim($tag))<span class="tag">{{ trim($tag) }}</span>@endif
                  @endforeach
                </div>
                @if($project->url)
                  <a href="{{ $project->url }}" class="project-link" target="_blank">
                    View
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                  </a>
                @endif
              </div>
            </div>
          </div>
        @endforeach
      @else
        <p style="grid-column:1/-1;color:var(--text-light);text-align:center;padding:3rem 0;">Belum ada project ditambahkan.</p>
      @endif
    </div>
  </div>

  <!-- ======================== CERTIFICATES ======================== -->
  <div class="certs-bg" id="certificates">
    <div class="section-wrap">
      <div class="reveal">
        <div class="section-tag">Credentials</div>
        <h2 class="section-title">Licenses & <span class="gradient-text">Certificates</span></h2>
        <p class="section-desc">Sertifikat yang telah saya peroleh sebagai bukti kompetensi.</p>
      </div>
      <div class="certs-grid">
        @if(isset($certificates) && $certificates->count())
          @foreach($certificates as $i => $cert)
            <div class="cert-card reveal" style="transition-delay:{{ $i * 0.1 }}s">
              <div class="cert-thumb">
                <img src="{{ Storage::url($cert->image) }}" alt="{{ $cert->title }}" loading="lazy">
                <div class="cert-thumb-overlay"></div>
                @if($cert->url)
                  <a href="{{ $cert->url }}" target="_blank" class="cert-verify-badge">
                    <svg viewBox="0 0 24 24"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                    Verify
                  </a>
                @endif
              </div>
              <div class="cert-info">
                <div class="cert-meta">
                  <span class="cert-issuer-badge">
                    <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    {{ $cert->issuer }}
                  </span>
                  <span class="cert-date-badge">{{ \Carbon\Carbon::parse($cert->issued_date)->format('M Y') }}</span>
                </div>
                <div class="cert-title">{{ $cert->title }}</div>
              </div>
            </div>
          @endforeach
        @else
          <div class="cert-empty" style="grid-column:1/-1;">
            <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            <p>Belum ada sertifikat ditambahkan.</p>
          </div>
        @endif
      </div>
    </div>
  </div>

  <!-- ======================== SKILLS ======================== -->
  <div class="skills-bg">
    <div class="section-wrap" id="skills">
      <div class="reveal">
        <div class="section-tag">Expertise</div>
        <h2 class="section-title">What I <span class="underline-text">build</span></h2>
        <p class="section-desc">Keahlian yang saya kuasai untuk menghadirkan solusi digital terbaik.</p>
      </div>
      <div class="skills-grid">
        @if($skills->count())
          @foreach($skills as $i => $skill)
            <div class="skill-card reveal" style="transition-delay:{{ $i * 0.1 }}s">
              <div class="skill-icon">
                @if($skill->icon_image)
                  <img src="{{ Storage::url($skill->icon_image) }}" alt="{{ $skill->name }}">
                @else
                  <img src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/code/code-original.svg" alt="{{ $skill->name }}">
                @endif
              </div>
              <div class="skill-name">{{ $skill->name }}</div>
              <div class="skill-desc">{{ $skill->description }}</div>
              <div class="skill-tags">
                @foreach(explode(',', $skill->tags ?? '') as $tag)
                  @if(trim($tag))<span class="tag">{{ trim($tag) }}</span>@endif
                @endforeach
              </div>
            </div>
          @endforeach
        @else
          <p style="grid-column:1/-1;color:var(--text-light);text-align:center;padding:3rem 0;">Belum ada skill ditambahkan.</p>
        @endif
      </div>
    </div>
  </div>

  <!-- ======================== CONTACT ======================== -->
  <div class="contact-bg">
    <div class="orb-c"></div>
    <div class="orb-c2"></div>
    <div class="contact-dots"></div>
    <div class="section-wrap" id="contact">
      <div class="contact-inner">
        <div class="contact-left reveal">
          <div class="section-tag">Kontak</div>
          <div class="contact-big-title">Let's Build<br><span class="highlight">Together.</span></div>
          <p class="contact-desc">{{ $settings['contact_desc'] ?? 'Punya project menarik? Saya selalu terbuka untuk kolaborasi.' }}</p>
          <div class="contact-socials">
            @if(!empty($settings['whatsapp']))
              <a href="https://wa.me/{{ $settings['whatsapp'] }}?text={{ urlencode($settings['wa_message'] ?? 'Halo!') }}" target="_blank" class="wa-link">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="#fff"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                WhatsApp
              </a>
            @endif
            @if(!empty($settings['github']))
              <a href="{{ $settings['github'] }}" target="_blank">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.374 0 0 5.373 0 12c0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23A11.509 11.509 0 0112 5.803c1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576C20.566 21.797 24 17.3 24 12c0-6.627-5.373-12-12-12z"/></svg>
                GitHub
              </a>
            @endif
            @if(!empty($settings['linkedin']))
              <a href="{{ $settings['linkedin'] }}" target="_blank">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                LinkedIn
              </a>
            @endif
            @if(!empty($settings['twitter']))
              <a href="{{ $settings['twitter'] }}" target="_blank">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                Twitter
              </a>
            @endif
          </div>
        </div>
        <div class="contact-right reveal" style="transition-delay:.2s">
          <form class="contact-form" action="{{ route('contact.send') }}" method="POST">
            @csrf
            <div class="form-group">
              <label>Nama</label>
              <input type="text" name="nama" placeholder="John Doe" required value="{{ old('nama') }}">
              @error('nama')<span style="font-size:12px;color:#ef4444">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
              <label>Email</label>
              <input type="email" name="email" placeholder="john@example.com" required value="{{ old('email') }}">
              @error('email')<span style="font-size:12px;color:#ef4444">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
              <label>Pesan</label>
              <textarea name="pesan" placeholder="Ceritakan projectmu...">{{ old('pesan') }}</textarea>
              @error('pesan')<span style="font-size:12px;color:#ef4444">{{ $message }}</span>@enderror
            </div>
            <button type="submit" class="btn-send">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
              Kirim Pesan
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- ======================== FOOTER ======================== -->
  <footer>
    <p>&copy; {{ date('Y') }} {{ $settings['name'] ?? 'Ahmad Badrul Falah' }} — {{ $settings['role'] ?? 'Frontend Developer' }}</p>
    <div class="social-links">
      @if(!empty($settings['github']))
        <a href="{{ $settings['github'] }}" target="_blank">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.374 0 0 5.373 0 12c0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23A11.509 11.509 0 0112 5.803c1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576C20.566 21.797 24 17.3 24 12c0-6.627-5.373-12-12-12z"/></svg>
          GitHub
        </a>
      @endif
      @if(!empty($settings['linkedin']))
        <a href="{{ $settings['linkedin'] }}" target="_blank">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
          LinkedIn
        </a>
      @endif
    </div>
  </footer>

  <!-- ======================== SCRIPTS ======================== -->
  <script>
    /* ── Custom Cursor ── */
    (function() {
      const cursor = document.getElementById('cursor');
      const ring = document.getElementById('cursorRing');
      if (!cursor || !ring) return;

      let mx = 0, my = 0, rx = 0, ry = 0;

      document.addEventListener('mousemove', function(e) {
        mx = e.clientX;
        my = e.clientY;
        cursor.style.left = mx + 'px';
        cursor.style.top = my + 'px';
      });

      (function animate() {
        rx += (mx - rx) * .1;
        ry += (my - ry) * .1;
        ring.style.left = rx + 'px';
        ring.style.top = ry + 'px';
        requestAnimationFrame(animate);
      })();

      document.querySelectorAll('a, button, .skill-card, .project-card, .cert-card, .avatar-box, input, textarea')
        .forEach(function(el) {
          el.addEventListener('mouseenter', function() {
            cursor.classList.add('hover');
            ring.classList.add('hover');
          });
          el.addEventListener('mouseleave', function() {
            cursor.classList.remove('hover');
            ring.classList.remove('hover');
          });
        });
    })();

    /* ── Mobile Menu ── */
    (function() {
      var btn = document.getElementById('hamburgerBtn');
      var menu = document.getElementById('mobileMenu');
      if (!btn || !menu) return;

      btn.addEventListener('click', function() {
        btn.classList.toggle('active');
        menu.classList.toggle('open');
        document.body.style.overflow = menu.classList.contains('open') ? 'hidden' : '';
      });

      document.querySelectorAll('.mobile-link').forEach(function(link) {
        link.addEventListener('click', function() {
          btn.classList.remove('active');
          menu.classList.remove('open');
          document.body.style.overflow = '';
        });
      });
    })();

    /* ── Nav Scroll Effect ── */
    (function() {
      var nav = document.getElementById('mainNav');
      if (!nav) return;
      window.addEventListener('scroll', function() {
        nav.classList.toggle('scrolled', window.scrollY > 60);
      }, { passive: true });
    })();

    /* ── Active Nav on Scroll ── */
    (function() {
      var links = document.querySelectorAll('.nav-links a[data-section]');
      if (!links.length) return;

      var observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
          if (entry.isIntersecting) {
            links.forEach(function(l) { l.classList.remove('active'); });
            var active = document.querySelector('.nav-links a[data-section="' + entry.target.id + '"]');
            if (active) active.classList.add('active');
          }
        });
      }, { rootMargin: '-30% 0px -60% 0px' });

      document.querySelectorAll('section[id], div[id]').forEach(function(s) {
        observer.observe(s);
      });
    })();

    /* ── Reveal on Scroll ── */
    (function() {
      var observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
          if (entry.isIntersecting) entry.target.classList.add('visible');
        });
      }, { threshold: .06 });

      document.querySelectorAll('.reveal').forEach(function(el) {
        observer.observe(el);
      });
    })();

    /* ── Flash Messages Auto-dismiss ── */
    document.querySelectorAll('.flash').forEach(function(el) {
      setTimeout(function() {
        el.style.opacity = '0';
        el.style.transition = 'opacity .3s';
        setTimeout(function() { el.remove(); }, 300);
      }, 3500);
    });

    /* ── Smooth Scroll ── */
    document.querySelectorAll('a[href^="#"]').forEach(function(a) {
      a.addEventListener('click', function(e) {
        e.preventDefault();
        var target = document.querySelector(this.getAttribute('href'));
        if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      });
    });

    /* ── 3D Tilt on Project Cards ── */
    document.querySelectorAll('.project-card').forEach(function(card) {
      card.addEventListener('mousemove', function(e) {
        var r = this.getBoundingClientRect();
        var x = e.clientX - r.left;
        var y = e.clientY - r.top;
        var cx = r.width / 2;
        var cy = r.height / 2;
        this.style.transform = 'perspective(800px) rotateX(' + (y - cy) / 12 + 'deg) rotateY(' + (cx - x) / 12 + 'deg) translateZ(8px)';
      });
      card.addEventListener('mouseleave', function() {
        this.style.transform = 'perspective(800px) rotateX(0) rotateY(0) translateZ(0)';
      });
    });

    /* ── 3D Tilt on Cert Cards ── */
    document.querySelectorAll('.cert-card').forEach(function(card) {
      card.addEventListener('mousemove', function(e) {
        var r = this.getBoundingClientRect();
        var x = e.clientX - r.left;
        var y = e.clientY - r.top;
        var cx = r.width / 2;
        var cy = r.height / 2;
        this.style.transform = 'translateY(-8px) perspective(800px) rotateX(' + (y - cy) / 14 + 'deg) rotateY(' + (cx - x) / 14 + 'deg)';
      });
      card.addEventListener('mouseleave', function() {
        this.style.transform = '';
      });
    });

    /* ── Contact Form Submit Feedback ── */
    (function() {
      var form = document.querySelector('.contact-form');
      if (!form) return;

      form.addEventListener('submit', function() {
        var btn = this.querySelector('.btn-send');
        btn.innerHTML = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="animation:spin 1s linear infinite"><path d="M21 12a9 9 0 11-6.219-8.56"/></svg> Sending...';
        btn.disabled = true;
      });
    })();

    /* ── Spin Keyframe (injected) ── */
    (function() {
      var s = document.createElement('style');
      s.textContent = '@keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }';
      document.head.appendChild(s);
    })();

    /* ── Typing Effect ── */
    (function() {
      var el = document.getElementById('typingName');
      if (!el) return;

      var name = "{{ $settings['name'] ?? 'Ahmad Badrul Falah' }}";
      var i = 0;
      var deleting = false;

      function loop() {
        if (!deleting) {
          el.textContent = name.substring(0, ++i);
          if (i === name.length) {
            setTimeout(function() { deleting = true; loop(); }, 2500);
            return;
          }
          setTimeout(loop, 80);
        } else {
          el.textContent = name.substring(0, --i);
          if (i === 0) {
            deleting = false;
            setTimeout(loop, 500);
            return;
          }
          setTimeout(loop, 40);
        }
      }

      setTimeout(loop, 800);
    })();

    /* ── Hero Orbs Parallax ── */
    (function() {
      var orbs = document.querySelectorAll('.hero-orb');
      if (!orbs.length || window.innerWidth <= 768) return;

      document.addEventListener('mousemove', function(e) {
        var x = (e.clientX / window.innerWidth - .5) * 2;
        var y = (e.clientY / window.innerHeight - .5) * 2;

        orbs.forEach(function(orb, i) {
          var speed = (i + 1) * 12;
          orb.style.transform = 'translate(' + (x * speed) + 'px, ' + (y * speed) + 'px)';
        });
      });
    })();
  </script>

</body>
</html>