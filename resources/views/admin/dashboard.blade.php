@extends('admin.layout')

@section('title', 'Dashboard')
@section('pageTitle', 'Dashboard')

@section('content')
<style>
  /* === WELCOME BANNER === */
  .dash-welcome {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 20px;
    padding: 0;
    margin-bottom: 2rem;
    position: relative;
    overflow: hidden;
    display: grid;
    grid-template-columns: 1fr 1fr;
    min-height: 200px;
  }

  .welcome-left {
    padding: 2.5rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
    position: relative;
    z-index: 2;
  }

  .welcome-left .greeting {
    font-size: .9rem;
    font-weight: 500;
    color: rgba(255,255,255,.7);
    margin-bottom: .4rem;
    display: flex;
    align-items: center;
    gap: .5rem;
  }

  .welcome-left .greeting .wave {
    display: inline-block;
    animation: wave 2.5s ease-in-out infinite;
    transform-origin: 70% 70%;
    font-size: 1.2rem;
  }

  @keyframes wave {
    0%, 60%, 100% { transform: rotate(0deg); }
    10% { transform: rotate(14deg); }
    20% { transform: rotate(-8deg); }
    30% { transform: rotate(14deg); }
    40% { transform: rotate(-4deg); }
    50% { transform: rotate(10deg); }
  }

  .welcome-left h2 {
    font-size: 1.8rem;
    font-weight: 800;
    color: #fff;
    margin-bottom: .5rem;
    line-height: 1.2;
  }

  .welcome-left h2 .name-highlight {
    background: rgba(255,255,255,.2);
    padding: 2px 10px;
    border-radius: 6px;
    display: inline-block;
  }

  .welcome-left .sub-text {
    font-size: .9rem;
    color: rgba(255,255,255,.75);
    line-height: 1.5;
    margin-bottom: 1.2rem;
  }

  .welcome-left .date-chip {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    background: rgba(255,255,255,.15);
    backdrop-filter: blur(8px);
    padding: .4rem .9rem;
    border-radius: 50px;
    font-size: .8rem;
    color: #fff;
    font-weight: 500;
    width: fit-content;
  }

  .welcome-left .date-chip svg {
    width: 14px; height: 14px; stroke: #fff; fill: none;
    stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;
  }

  .welcome-right {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1;
  }

  .welcome-right .code-preview {
    background: rgba(0,0,0,.25);
    backdrop-filter: blur(10px);
    border-radius: 14px;
    padding: 1.5rem;
    border: 1px solid rgba(255,255,255,.1);
    font-family: 'Courier New', monospace;
    font-size: .82rem;
    color: rgba(255,255,255,.9);
    line-height: 1.7;
    transform: perspective(800px) rotateY(-8deg);
    transition: transform .4s;
    position: relative;
    z-index: 2;
    width: 85%;
  }

  .welcome-right .code-preview:hover {
    transform: perspective(800px) rotateY(0deg);
  }

  .welcome-right .code-preview .ck { color: #a78bfa; font-weight: 600; }
  .welcome-right .code-preview .cs { color: #fbbf24; }
  .welcome-right .code-preview .cf { color: #34d399; }
  .welcome-right .code-preview .cc { color: rgba(255,255,255,.35); }

  .welcome-right .floating-card {
    position: absolute;
    background: rgba(255,255,255,.12);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255,255,255,.15);
    border-radius: 12px;
    padding: .8rem 1rem;
    color: #fff;
    font-size: .8rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: .5rem;
    z-index: 3;
  }

  .welcome-right .floating-card svg {
    width: 18px; height: 18px; stroke: #fff; fill: none;
    stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;
  }

  .floating-card.fc-1 {
    top: 15%;
    right: 8%;
    animation: floatCard 6s ease-in-out infinite;
  }

  .floating-card.fc-2 {
    bottom: 18%;
    left: 5%;
    animation: floatCard 6s ease-in-out infinite 2s;
  }

  @keyframes floatCard {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
  }

  .welcome-bg-shape {
    position: absolute;
    border-radius: 50%;
    background: rgba(255,255,255,.06);
  }

  .welcome-bg-shape.s1 {
    width: 350px; height: 350px;
    top: -120px; right: -80px;
    background: rgba(255,255,255,.08);
  }

  .welcome-bg-shape.s2 {
    width: 200px; height: 200px;
    bottom: -80px; right: 20%;
    background: rgba(255,255,255,.05);
  }

  .welcome-bg-shape.s3 {
    width: 120px; height: 120px;
    top: 30%; right: 60%;
    background: rgba(255,255,255,.04);
  }

  /* === STAT CARDS === */
  .stat-grid-v2 {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.25rem;
    margin-bottom: 2rem;
  }
  .stat-card-v2 {
    background: var(--bg-card);
    border-radius: 14px;
    padding: 1.5rem;
    border: 1px solid var(--border);
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    transition: all .2s;
  }
  .stat-card-v2:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
  }
  .stat-icon {
    width: 48px; height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }
  .stat-icon svg {
    width: 22px; height: 22px;
    stroke-width: 2;
    stroke-linecap: round;
    stroke-linejoin: round;
    fill: none;
  }
  .stat-icon.purple { background: #eef2ff; }
  .stat-icon.purple svg { stroke: #6366f1; }
  .stat-icon.green { background: #ecfdf5; }
  .stat-icon.green svg { stroke: #10b981; }
  .stat-icon.orange { background: #fff7ed; }
  .stat-icon.orange svg { stroke: #f59e0b; }
  .stat-icon.red { background: #fef2f2; }
  .stat-icon.red svg { stroke: #ef4444; }
  .stat-info { flex: 1; }
  .stat-info .label {
    font-size: .8rem;
    color: var(--text-light);
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: .3px;
    margin-bottom: .3rem;
  }
  .stat-info .value {
    font-size: 1.75rem;
    font-weight: 800;
    line-height: 1;
    color: var(--text);
  }
  .stat-info .sub {
    font-size: .78rem;
    color: var(--text-light);
    margin-top: .3rem;
  }
  .stat-info .sub .up { color: #10b981; font-weight: 600; }
  .stat-info .sub .down { color: #ef4444; font-weight: 600; }

  /* === DASH GRID === */
  .dash-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-bottom: 2rem;
  }

  /* === CHART === */
  .chart-card {
    background: var(--bg-card);
    border-radius: 14px;
    border: 1px solid var(--border);
    overflow: hidden;
  }
  .chart-card .card-header {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid var(--border);
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  .chart-card .card-header h3 {
    font-size: 1rem;
    font-weight: 600;
  }
  .chart-card .card-header .badge-sm {
    font-size: .75rem;
    padding: .2rem .6rem;
    border-radius: 50px;
    background: var(--bg);
    color: var(--text-light);
    font-weight: 500;
  }
  .chart-body { padding: 1.5rem; }
  .bar-chart {
    display: flex;
    align-items: flex-end;
    gap: 12px;
    height: 160px;
    padding-top: 1rem;
  }
  .bar-col {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: .5rem;
    height: 100%;
    justify-content: flex-end;
  }
  .bar {
    width: 100%;
    max-width: 40px;
    border-radius: 6px 6px 2px 2px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 4px;
    transition: height .6s cubic-bezier(.4,0,.2,1);
  }
  .bar.zero { background: var(--border); }
  .bar-label { font-size: .7rem; color: var(--text-light); font-weight: 500; }
  .bar-value { font-size: .7rem; font-weight: 700; color: var(--text); }
  .chart-empty {
    text-align: center;
    padding: 3rem 1rem;
    color: var(--text-light);
    font-size: .9rem;
  }
  .chart-empty svg {
    width: 40px; height: 40px;
    stroke: var(--border);
    fill: none;
    stroke-width: 1.5;
    margin-bottom: .5rem;
  }

  /* === QUICK ACTIONS === */
  .quick-actions {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: .75rem;
  }
  .quick-btn {
    display: flex;
    align-items: center;
    gap: .75rem;
    padding: 1rem;
    border-radius: 10px;
    border: 1.5px solid var(--border);
    background: #fff;
    text-decoration: none;
    color: var(--text);
    transition: all .2s;
    cursor: pointer;
  }
  .quick-btn:hover {
    border-color: var(--primary);
    background: #fafafe;
    transform: translateY(-2px);
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
  }
  .quick-btn .qb-icon {
    width: 38px; height: 38px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }
  .quick-btn .qb-icon svg {
    width: 18px; height: 18px;
    stroke-width: 2;
    stroke-linecap: round;
    stroke-linejoin: round;
    fill: none;
  }
  .quick-btn .qb-text { font-size: .85rem; font-weight: 600; line-height: 1.3; }
  .quick-btn .qb-sub { font-size: .75rem; color: var(--text-light); font-weight: 400; }

  /* === COMPLETENESS === */
  .completeness {
    background: var(--bg-card);
    border-radius: 14px;
    border: 1px solid var(--border);
    padding: 1.5rem;
  }
  .completeness h3 { font-size: 1rem; font-weight: 600; margin-bottom: .3rem; }
  .completeness .comp-desc { font-size: .8rem; color: var(--text-light); margin-bottom: 1.25rem; }
  .comp-bar-wrap {
    background: var(--bg);
    border-radius: 50px;
    height: 10px;
    overflow: hidden;
    margin-bottom: 1rem;
  }
  .comp-bar {
    height: 100%;
    border-radius: 50px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    transition: width .8s cubic-bezier(.4,0,.2,1);
  }
  .comp-percent { font-size: 1.5rem; font-weight: 800; color: var(--primary); margin-bottom: 1rem; }
  .comp-list { display: flex; flex-direction: column; gap: .6rem; }
  .comp-item { display: flex; align-items: center; gap: .6rem; font-size: .85rem; }
  .comp-item .check {
    width: 20px; height: 20px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }
  .comp-item .check.done { background: #d1fae5; }
  .comp-item .check.done svg {
    width: 12px; height: 12px; stroke: #065f46; fill: none;
    stroke-width: 3; stroke-linecap: round; stroke-linejoin: round;
  }
  .comp-item .check.missing { background: #fef2f2; }
  .comp-item .check.missing svg {
    width: 12px; height: 12px; stroke: #ef4444; fill: none;
    stroke-width: 2.5; stroke-linecap: round; stroke-linejoin: round;
  }
  .comp-item span { color: var(--text); }
  .comp-item span.miss { color: var(--text-light); }

  /* === RECENT MESSAGES === */
  .recent-card {
    background: var(--bg-card);
    border-radius: 14px;
    border: 1px solid var(--border);
    overflow: hidden;
  }
  .recent-card .card-header {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid var(--border);
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  .recent-card .card-header h3 { font-size: 1rem; font-weight: 600; }
  .msg-row {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem 1.5rem;
    border-bottom: 1px solid var(--border);
    transition: background .15s;
    text-decoration: none;
    color: var(--text);
    cursor: pointer;
  }
  .msg-row:last-child { border-bottom: none; }
  .msg-row:hover { background: var(--bg); }
  .msg-row.unread { background: #fffbeb; }
  .msg-row.unread:hover { background: #fef3c7; }
  .msg-avatar {
    width: 40px; height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: .85rem;
    flex-shrink: 0;
    color: #fff;
  }
  .msg-avatar.read { background: var(--border); color: var(--text-light); }
  .msg-avatar.unread-av { background: var(--primary); }
  .msg-body { flex: 1; min-width: 0; }
  .msg-name {
    font-size: .9rem;
    font-weight: 600;
    margin-bottom: .15rem;
    display: flex;
    align-items: center;
    gap: .5rem;
  }
  .msg-name .dot {
    width: 7px; height: 7px;
    border-radius: 50%;
    background: var(--warning);
    flex-shrink: 0;
  }
  .msg-preview {
    font-size: .8rem;
    color: var(--text-light);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
  .msg-time { font-size: .75rem; color: var(--text-light); white-space: nowrap; flex-shrink: 0; }
  .see-all-btn {
    display: block;
    text-align: center;
    padding: .85rem;
    font-size: .85rem;
    font-weight: 600;
    color: var(--primary);
    text-decoration: none;
    border-top: 1px solid var(--border);
    transition: background .15s;
  }
  .see-all-btn:hover { background: var(--bg); }
  .empty-msg {
    text-align: center;
    padding: 3rem 1rem;
    color: var(--text-light);
  }
  .empty-msg svg {
    width: 40px; height: 40px;
    stroke: var(--border);
    fill: none;
    stroke-width: 1.5;
    margin-bottom: .5rem;
  }

  /* === SKILLS OVERVIEW === */
  .skills-mini { display: flex; flex-wrap: wrap; gap: .5rem; margin-top: .75rem; }
  .skill-pill {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    padding: .35rem .75rem;
    background: var(--bg);
    border-radius: 50px;
    font-size: .8rem;
    font-weight: 500;
    color: var(--text);
    border: 1px solid var(--border);
  }
  .skill-pill img { width: 16px; height: 16px; object-fit: contain; }

  /* === RESPONSIVE === */
  @media (max-width: 1024px) {
    .stat-grid-v2 { grid-template-columns: repeat(2, 1fr); }
    .dash-grid { grid-template-columns: 1fr; }
  }
  @media (max-width: 768px) {
    .dash-welcome {
      grid-template-columns: 1fr;
    }
    .welcome-right { display: none; }
    .welcome-left { padding: 2rem; }
    .welcome-left h2 { font-size: 1.5rem; }
  }
  @media (max-width: 640px) {
    .stat-grid-v2 { grid-template-columns: 1fr; }
    .quick-actions { grid-template-columns: 1fr; }
  }
</style>

@php
  $totalSkills = \App\Models\Skill::count();
  $totalProjects = \App\Models\Project::count();
  $totalContacts = \App\Models\Contact::count();
  $unreadContacts = \App\Models\Contact::where('is_read', false)->count();
  $recentContacts = \App\Models\Contact::latest()->take(5)->get();
  $allSkills = \App\Models\Skill::orderBy('sort_order')->take(8)->get();

  $chartData = [];
  $chartLabels = [];
  for ($i = 6; $i >= 0; $i--) {
    $date = \Carbon\Carbon::today()->subDays($i);
    $count = \App\Models\Contact::whereDate('created_at', $date)->count();
    $chartData[] = $count;
    $chartLabels[] = $date->format('D');
  }
  $maxChart = max(max($chartData), 1);

  $settings = \App\Models\Setting::all()->pluck('value', 'key')->toArray();
  $about = \App\Models\About::first();

  $checks = [];
  $checks[] = ['label' => 'Nama profil diisi', 'done' => !empty($settings['name'])];
  $checks[] = ['label' => 'Deskripsi hero diisi', 'done' => !empty($settings['hero_desc'])];
  $checks[] = ['label' => 'Foto avatar diupload', 'done' => !empty($settings['avatar'])];
  $checks[] = ['label' => 'Konten about diisi', 'done' => $about && !empty($about->content)];
  $checks[] = ['label' => 'Minimal 1 skill ditambahkan', 'done' => $totalSkills > 0];
  $checks[] = ['label' => 'Minimal 1 project ditambahkan', 'done' => $totalProjects > 0];
  $checks[] = ['label' => 'Link WhatsApp diisi', 'done' => !empty($settings['whatsapp'])];
  $checks[] = ['label' => 'Link GitHub diisi', 'done' => !empty($settings['github'])];
  $doneChecks = count(array_filter($checks, fn($c) => $c['done']));
  $compPercent = round(($doneChecks / count($checks)) * 100);
@endphp

<!-- ========== WELCOME BANNER ========== -->
<div class="dash-welcome">
  <div class="welcome-bg-shape s1"></div>
  <div class="welcome-bg-shape s2"></div>
  <div class="welcome-bg-shape s3"></div>

  <div class="welcome-left">
    <div class="greeting">
      <span class="wave">👋</span> Selamat datang kembali
    </div>
    <h2>Halo, <span class="name-highlight">{{ Auth::user()->name }}</span>!</h2>
    <p class="sub-text">Berikut ringkasan portofolio kamu hari ini. Semua baik?</p>
    <div class="date-chip">
      <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
      {{ now()->translatedFormat('l, d F Y') }}
    </div>
  </div>

  <div class="welcome-right">
    <div class="floating-card fc-1">
      <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
      {{ $compPercent }}% Lengkap
    </div>
    <div class="floating-card fc-2">
      <svg viewBox="0 0 24 24"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
      {{ $totalProjects }} Project
    </div>
    <div class="code-preview">
      <div><span class="cc">// portfolio.status()</span></div>
      <div><span class="ck">const</span> stats = {</div>
      <div>&nbsp;&nbsp;skills: <span class="cs">{{ $totalSkills }}</span>,</div>
      <div>&nbsp;&nbsp;projects: <span class="cs">{{ $totalProjects }}</span>,</div>
      <div>&nbsp;&nbsp;messages: <span class="cs">{{ $totalContacts }}</span>,</div>
      <div>&nbsp;&nbsp;unread: <span class="cs">{{ $unreadContacts }}</span></div>
      <div>};</div>
    </div>
  </div>
</div>

<!-- ========== STAT CARDS ========== -->
<div class="stat-grid-v2">
  <div class="stat-card-v2">
    <div class="stat-icon purple">
      <svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
    </div>
    <div class="stat-info">
      <div class="label">Skills</div>
      <div class="value">{{ $totalSkills }}</div>
      <div class="sub">Keahlian terdaftar</div>
    </div>
  </div>
  <div class="stat-card-v2">
    <div class="stat-icon green">
      <svg viewBox="0 0 24 24"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
    </div>
    <div class="stat-info">
      <div class="label">Projects</div>
      <div class="value">{{ $totalProjects }}</div>
      <div class="sub">Project dipublikasi</div>
    </div>
  </div>
  <div class="stat-card-v2">
    <div class="stat-icon orange">
      <svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
    </div>
    <div class="stat-info">
      <div class="label">Total Pesan</div>
      <div class="value">{{ $totalContacts }}</div>
      <div class="sub">Sejak pertama kali</div>
    </div>
  </div>
  <div class="stat-card-v2">
    <div class="stat-icon red">
      <svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
    </div>
    <div class="stat-info">
      <div class="label">Belum Dibaca</div>
      <div class="value">{{ $unreadContacts }}</div>
      <div class="sub">
        @if($unreadContacts > 0)
          <span class="down">{{ $unreadContacts }} pesan baru</span>
        @else
          <span class="up">Semua sudah dibaca</span>
        @endif
      </div>
    </div>
  </div>
</div>

<!-- ========== CHART + QUICK ACTIONS ========== -->
<div class="dash-grid">
  <div class="chart-card">
    <div class="card-header">
      <h3>Pesan 7 Hari Terakhir</h3>
      <span class="badge-sm">{{ now()->format('d M') }} — 7 hari</span>
    </div>
    <div class="chart-body">
      @if(array_sum($chartData) > 0)
        <div class="bar-chart">
          @foreach($chartData as $i => $val)
            <div class="bar-col">
              <div class="bar-value">{{ $val }}</div>
              <div class="bar {{ $val === 0 ? 'zero' : '' }}" style="height:{{ ($val / $maxChart) * 100 }}%"></div>
              <div class="bar-label">{{ $chartLabels[$i] }}</div>
            </div>
          @endforeach
        </div>
      @else
        <div class="chart-empty">
          <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
          <p>Belum ada pesan 7 hari terakhir</p>
        </div>
      @endif
    </div>
  </div>

  <div class="chart-card">
    <div class="card-header"><h3>Aksi Cepat</h3></div>
    <div class="chart-body">
      <div class="quick-actions">
        <a href="{{ route('admin.settings') }}" class="quick-btn">
          <div class="qb-icon" style="background:#eef2ff;">
            <svg viewBox="0 0 24 24" stroke="#6366f1"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
          </div>
          <div><div class="qb-text">Edit Settings</div><div class="qb-sub">Nama, sosmed, foto</div></div>
        </a>
        <a href="{{ route('admin.about') }}" class="quick-btn">
          <div class="qb-icon" style="background:#ecfdf5;">
            <svg viewBox="0 0 24 24" stroke="#10b981"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
          </div>
          <div><div class="qb-text">Edit About</div><div class="qb-sub">Tentang kamu</div></div>
        </a>
        <a href="{{ route('admin.skills') }}" class="quick-btn">
          <div class="qb-icon" style="background:#fff7ed;">
            <svg viewBox="0 0 24 24" stroke="#f59e0b"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
          </div>
          <div><div class="qb-text">Kelola Skills</div><div class="qb-sub">{{ $totalSkills }} terdaftar</div></div>
        </a>
        <a href="{{ route('admin.projects') }}" class="quick-btn">
          <div class="qb-icon" style="background:#fef2f2;">
            <svg viewBox="0 0 24 24" stroke="#ef4444"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
          </div>
          <div><div class="qb-text">Kelola Projects</div><div class="qb-sub">{{ $totalProjects }} terdaftar</div></div>
        </a>
      </div>
    </div>
  </div>
</div>

<!-- ========== MESSAGES + COMPLETENESS ========== -->
<div class="dash-grid">
  <div class="recent-card">
    <div class="card-header">
      <h3>Pesan Terbaru</h3>
      @if($unreadContacts > 0)
        <span style="background:#fef3c7;color:#92400e;font-size:.75rem;padding:.2rem .6rem;border-radius:50px;font-weight:600;">{{ $unreadContacts }} baru</span>
      @endif
    </div>
    @if($recentContacts->count())
      @foreach($recentContacts as $c)
        <a href="{{ route('admin.contacts.show', $c) }}" class="msg-row {{ !$c->is_read ? 'unread' : '' }}">
          <div class="msg-avatar {{ !$c->is_read ? 'unread-av' : 'read' }}">
            {{ strtoupper(substr($c->nama, 0, 1)) }}
          </div>
          <div class="msg-body">
            <div class="msg-name">{{ $c->nama }} @if(!$c->is_read)<span class="dot"></span>@endif</div>
            <div class="msg-preview">{{ $c->pesan }}</div>
          </div>
          <div class="msg-time">{{ $c->created_at->diffForHumans() }}</div>
        </a>
      @endforeach
      <a href="{{ route('admin.contacts') }}" class="see-all-btn">Lihat Semua Pesan →</a>
    @else
      <div class="empty-msg">
        <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
        <p>Belum ada pesan masuk</p>
      </div>
    @endif
  </div>

  <div class="completeness">
    <h3>Kelengkapan Portofolio</h3>
    <p class="comp-desc">Cek seberapa lengkap portofolio kamu</p>
    <div class="comp-percent">{{ $compPercent }}%</div>
    <div class="comp-bar-wrap">
      <div class="comp-bar" style="width:{{ $compPercent }}%"></div>
    </div>
    <div class="comp-list">
      @foreach($checks as $check)
        <div class="comp-item">
          <div class="check {{ $check['done'] ? 'done' : 'missing' }}">
            @if($check['done'])
              <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
            @else
              <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            @endif
          </div>
          <span class="{{ $check['done'] ? '' : 'miss' }}">{{ $check['label'] }}</span>
        </div>
      @endforeach
    </div>
  </div>
</div>

<!-- ========== SKILLS OVERVIEW ========== -->
@if($allSkills->count())
<div class="chart-card" style="margin-bottom:2rem;">
  <div class="card-header">
    <h3>Skill Terdaftar</h3>
    <a href="{{ route('admin.skills') }}" style="font-size:.85rem;color:var(--primary);text-decoration:none;font-weight:500;">Kelola →</a>
  </div>
  <div class="chart-body">
    <div class="skills-mini">
      @foreach($allSkills as $skill)
        <span class="skill-pill">
          @if($skill->icon_image)
            <img src="{{ \Illuminate\Support\Facades\Storage::url($skill->icon_image) }}" alt="{{ $skill->name }}">
          @endif
          {{ $skill->name }}
        </span>
      @endforeach
      @if($totalSkills > 8)
        <span class="skill-pill" style="color:var(--text-light);">+{{ $totalSkills - 8 }} lainnya</span>
      @endif
    </div>
  </div>
</div>
@endif

@endsection