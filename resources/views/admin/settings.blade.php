@extends('admin.layout')

@section('title', 'Settings')
@section('pageTitle', 'Settings')

@section('content')
<style>
  @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap');

  :root {
    --primary: #6366f1;
    --primary-hover: #4f46e5;
    --primary-subtle: #f0f0ff;
    --surface: #ffffff;
    --surface-raised: #fafafa;
    --border: #e8e8ed;
    --border-hover: #d4d4dc;
    --text-1: #111113;
    --text-2: #52525b;
    --text-3: #a1a1aa;
    --radius: 14px;
    --radius-sm: 10px;
    --transition: 0.2s ease;
  }

  .settings-wrap {
    max-width: 100%;
    padding: 1.5rem 0 7rem;
  }

  /* ── Page Header ── */
  .page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 2rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid var(--border);
  }
  .ph-left { display: flex; align-items: center; gap: 1rem; }
  .ph-icon {
    width: 44px; height: 44px; border-radius: 12px;
    background: var(--primary);
    color: #fff;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
  }
  .ph-icon svg { width: 22px; height: 22px; stroke: #fff; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
  .ph-text h1 { font-size: 1.25rem; font-weight: 800; color: var(--text-1); margin: 0; letter-spacing: -.02em; }
  .ph-text .ph-sub { font-size: .82rem; color: var(--text-3); margin: 2px 0 0; font-weight: 500; }

  /* Inline editable name */
  .ph-name {
    display: flex; align-items: center; gap: .35rem;
    margin-top: 4px;
  }
  .ph-name-icon {
    width: 14px; height: 14px; stroke: var(--text-3); fill: none;
    stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;
    flex-shrink: 0; opacity: .5;
  }
  .ph-name-display {
    font-size: .88rem; font-weight: 700; color: var(--primary);
    cursor: pointer; padding: 2px 6px; margin: -2px -6px;
    border-radius: 6px; border: 1.5px solid transparent;
    transition: all .15s ease;
    max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
    display: flex; align-items: center; gap: .3rem;
  }
  .ph-name-display:hover {
    background: var(--primary-subtle);
    border-color: rgba(99,102,241,.15);
  }
  .ph-name-display .edit-hint {
    font-size: .6rem; color: var(--text-3); font-weight: 600;
    opacity: 0; transition: opacity .15s;
    flex-shrink: 0; text-transform: uppercase; letter-spacing: .04em;
  }
  .ph-name-display:hover .edit-hint { opacity: 1; }

  .ph-name-input {
    font-size: .88rem; font-weight: 700; color: var(--text-1);
    font-family: 'Inter', system-ui, sans-serif;
    padding: 3px 6px; margin: -3px -6px;
    border: 1.5px solid var(--primary);
    border-radius: 6px; outline: none;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(99,102,241,.1);
    max-width: 300px;
    display: none;
  }

  .ph-completeness {
    display: flex; align-items: center; gap: .75rem;
  }
  .ph-comp-label { font-size: .75rem; color: var(--text-3); font-weight: 600; white-space: nowrap; }
  .ph-comp-bar {
    width: 120px; height: 6px; background: var(--border);
    border-radius: 100px; overflow: hidden;
  }
  .ph-comp-fill {
    height: 100%; border-radius: 100px;
    background: var(--primary);
    transition: width .6s cubic-bezier(.4,0,.2,1);
  }
  .ph-comp-pct { font-size: .82rem; font-weight: 700; color: var(--text-1); min-width: 36px; text-align: right; font-variant-numeric: tabular-nums; }

  /* ── Cards ── */
  .s-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    margin-bottom: 1.5rem;
    transition: border-color var(--transition), box-shadow var(--transition);
    animation: cardIn .5s ease both;
  }
  .s-card:nth-child(2) { animation-delay: .05s; }
  .s-card:nth-child(3) { animation-delay: .1s; }
  .s-card:nth-child(4) { animation-delay: .15s; }
  .s-card:nth-child(5) { animation-delay: .2s; }
  @keyframes cardIn { from { opacity:0; transform:translateY(12px); } to { opacity:1; transform:translateY(0); } }

  .s-card:hover { border-color: var(--border-hover); box-shadow: 0 2px 12px rgba(0,0,0,.04); }

  .s-card-head {
    display: flex; align-items: center; gap: .85rem;
    padding: 1.25rem 1.75rem;
    border-bottom: 1px solid var(--border);
  }
  .sch-icon {
    width: 40px; height: 40px; border-radius: var(--radius-sm);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
  }
  .sch-icon svg { width: 20px; height: 20px; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
  .sch-icon.purple { background: #f0eeff; color: #6d28d9; }
  .sch-icon.green  { background: #ecfdf5; color: #047857; }
  .sch-icon.amber  { background: #fffbeb; color: #b45309; }
  .sch-icon.rose   { background: #fff1f2; color: #be123c; }

  .sch-text h2 { font-size: .95rem; font-weight: 700; color: var(--text-1); margin: 0; }
  .sch-text p { font-size: .78rem; color: var(--text-3); margin: 2px 0 0; }

  .s-card-body { padding: 1.75rem; }

  /* ── Form ── */
  .f-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; }
  .f-group, .f-full { position: relative; }
  .f-label {
    display: block; font-size: .78rem; font-weight: 600; color: var(--text-2);
    margin-bottom: .5rem;
  }
  .req { color: #e53e3e; }

  .f-input {
    width: 100%; padding: .72rem .9rem;
    border: 1px solid var(--border); border-radius: var(--radius-sm);
    font-size: .88rem; font-family: 'Inter', system-ui, sans-serif;
    color: var(--text-1); background: var(--surface);
    transition: border-color var(--transition), box-shadow var(--transition);
    outline: none;
  }
  .f-input::placeholder { color: var(--text-3); }
  .f-input:hover { border-color: var(--border-hover); }
  .f-input:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(99,102,241,.08); }
  .f-textarea { resize: vertical; min-height: 80px; line-height: 1.6; }

  .f-input-wrap { position: relative; }
  .f-input-wrap .prefix {
    position: absolute; left: .9rem; top: 50%; transform: translateY(-50%);
    font-size: .85rem; color: var(--text-3); font-weight: 600; pointer-events: none;
  }
  .f-input.has-prefix { padding-left: 2.2rem; }
  .f-input-wrap .suffix {
    position: absolute; right: .9rem; top: 50%; transform: translateY(-50%);
  }
  .f-input.has-suffix { padding-right: 4rem; }
  .char-count { font-size: .7rem; color: var(--text-3); font-weight: 600; font-variant-numeric: tabular-nums; }

  .f-hint { font-size: .72rem; color: var(--text-3); margin-top: .4rem; }
  .f-divider { border: none; border-top: 1px solid var(--border); margin: 1.75rem 0 1.5rem; }

  /* ── Upload ── */
  .upload-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }
  .upload-box {
    position: relative; border: 1.5px dashed var(--border);
    border-radius: var(--radius); padding: 2.5rem 1.25rem 1.25rem;
    text-align: center; cursor: pointer;
    transition: border-color var(--transition), background var(--transition);
    background: var(--surface-raised);
  }
  .upload-box:hover { border-color: var(--primary); background: #fafaff; }
  .upload-box.drag-over { border-color: var(--primary); background: var(--primary-subtle); }
  .upload-box.has-file { border-style: solid; border-color: var(--border); background: var(--surface); padding-top: 1.25rem; }
  .upload-box input[type="file"] { position: absolute; inset: 0; opacity: 0; cursor: pointer; z-index: 3; }

  .ub-remove {
    position: absolute; top: .65rem; right: .65rem; width: 26px; height: 26px;
    border-radius: 8px; background: #fef2f2; border: 1px solid #fecaca;
    cursor: pointer; display: none; align-items: center; justify-content: center;
    z-index: 4; transition: all var(--transition);
  }
  .ub-remove.show { display: flex; }
  .ub-remove:hover { background: #ef4444; border-color: #ef4444; }
  .ub-remove:hover svg { stroke: #fff; }
  .ub-remove svg { width: 13px; height: 13px; stroke: #ef4444; fill: none; stroke-width: 2.5; stroke-linecap: round; }

  .ub-icon {
    width: 44px; height: 44px; border-radius: 12px;
    background: var(--primary-subtle); color: var(--primary);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto .9rem;
  }
  .ub-icon svg { width: 20px; height: 20px; stroke: currentColor; fill: none; stroke-width: 1.5; stroke-linecap: round; }
  .ub-title { font-size: .88rem; font-weight: 600; color: var(--text-1); }
  .ub-desc { font-size: .72rem; color: var(--text-3); margin-top: 2px; }
  .ub-badges { display: flex; justify-content: center; gap: .35rem; margin-top: .6rem; }
  .ub-badge { font-size: .6rem; font-weight: 600; color: var(--text-3); background: rgba(0,0,0,.04); padding: 1px 7px; border-radius: 4px; text-transform: uppercase; letter-spacing: .04em; }
  .ub-preview { margin-top: 1rem; display: none; }
  .ub-preview img { display: block; margin: 0 auto; }
  .prev-avatar { width: 80px; height: 80px; border-radius: 16px; object-fit: cover; border: 2px solid var(--border); }
  .prev-favicon { width: 44px; height: 44px; border-radius: 10px; object-fit: contain; border: 1px solid var(--border); background: #fff; padding: 4px; }
  .upload-box.has-file .ub-preview { display: block; }
  .upload-box.has-file .ub-icon,
  .upload-box.has-file .ub-title,
  .upload-box.has-file .ub-desc,
  .upload-box.has-file .ub-badges { display: none; }

  /* ── Social ── */
  .social-list { display: flex; flex-direction: column; gap: .75rem; }
  .social-field {
    display: flex; align-items: center; gap: 1rem;
    padding: 1rem 1.25rem; border-radius: var(--radius-sm);
    border: 1px solid var(--border); background: var(--surface);
    transition: border-color var(--transition), background var(--transition);
  }
  .social-field:hover { border-color: var(--border-hover); background: var(--surface-raised); }
  .social-field.connected { border-color: #bbf7d0; background: #f0fdf4; }

  .sf-logo {
    width: 40px; height: 40px; border-radius: var(--radius-sm);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
  }
  .sf-logo svg { width: 20px; height: 20px; }
  .sf-body { flex: 1; min-width: 0; }
  .sf-label { display: flex; align-items: center; gap: .5rem; font-size: .85rem; font-weight: 600; color: var(--text-1); margin-bottom: .4rem; }
  .sf-brand { font-size: .58rem; font-weight: 700; color: var(--text-3); letter-spacing: .08em; background: rgba(0,0,0,.04); padding: 1px 6px; border-radius: 4px; }
  .sf-input {
    width: 100%; padding: .55rem .75rem; border: 1px solid var(--border);
    border-radius: 8px; font-size: .85rem; font-family: 'Inter', sans-serif;
    color: var(--text-1); background: var(--surface); transition: border-color var(--transition), box-shadow var(--transition); outline: none;
  }
  .sf-input::placeholder { color: var(--text-3); font-size: .82rem; }
  .sf-input:hover { border-color: var(--border-hover); }
  .sf-input:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(99,102,241,.08); }
  .sf-status { display: inline-flex; align-items: center; gap: .35rem; font-size: .7rem; font-weight: 600; margin-top: .35rem; }
  .sf-status .dot { width: 6px; height: 6px; border-radius: 50%; }
  .sf-status.on { color: #16a34a; }
  .sf-status.on .dot { background: #22c55e; }
  .sf-status.off { color: var(--text-3); }
  .sf-status.off .dot { background: var(--border); }

  /* ── Save Bar ── */
  .save-bar {
    position: fixed; bottom: 0; left: var(--sidebar-w, 260px); right: 0;
    background: rgba(255,255,255,.92); backdrop-filter: blur(12px);
    border-top: 1px solid var(--border); padding: .85rem 1.75rem;
    display: flex; align-items: center; justify-content: space-between; z-index: 60;
  }
  .sb-hint { font-size: .78rem; color: var(--text-3); font-weight: 500; display: flex; align-items: center; gap: .4rem; }
  .sb-hint svg { width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 2; }
  .sb-actions { display: flex; align-items: center; gap: .75rem; }

  .btn-ghost {
    display: inline-flex; align-items: center; gap: .4rem;
    padding: .6rem 1.15rem; border-radius: var(--radius-sm);
    font-size: .85rem; font-weight: 600; font-family: 'Inter', sans-serif;
    color: var(--text-2); background: transparent;
    border: 1px solid var(--border); cursor: pointer;
    text-decoration: none; transition: all var(--transition);
  }
  .btn-ghost:hover { color: var(--text-1); border-color: var(--border-hover); background: var(--surface-raised); }
  .btn-ghost svg { width: 15px; height: 15px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; }

  .btn-primary {
    display: inline-flex; align-items: center; gap: .5rem;
    padding: .6rem 1.5rem; border-radius: var(--radius-sm);
    font-size: .85rem; font-weight: 600; font-family: 'Inter', sans-serif;
    color: #fff; background: var(--primary); border: none;
    cursor: pointer; transition: all var(--transition);
    box-shadow: 0 1px 3px rgba(99,102,241,.25);
    position: relative; overflow: hidden;
  }
  .btn-primary:hover { background: var(--primary-hover); box-shadow: 0 2px 8px rgba(99,102,241,.3); }
  .btn-primary:active { transform: scale(.98); }
  .btn-primary svg { width: 16px; height: 16px; stroke: currentColor; fill: none; stroke-width: 2.5; stroke-linecap: round; stroke-linejoin: round; position: relative; z-index: 1; }
  .btn-primary .btn-label { position: relative; z-index: 1; }
  .btn-primary.loading { pointer-events: none; opacity: .7; }
  .btn-primary.loading .btn-label { opacity: 0; }
  .btn-primary .spinner {
    display: none; width: 18px; height: 18px;
    border: 2px solid rgba(255,255,255,.3); border-top-color: #fff;
    border-radius: 50%; animation: spin .6s linear infinite;
    position: absolute; left: 50%; top: 50%; margin: -9px 0 0 -9px;
  }
  .btn-primary.loading .spinner { display: block; }
  .btn-primary.loading svg { opacity: 0; }
  @keyframes spin { to { transform: rotate(360deg); } }

  /* ── Toast ── */
  #toast-container { position: fixed; top: 5rem; right: 1.5rem; z-index: 9999; display: flex; flex-direction: column; gap: .6rem; pointer-events: none; }
  .toast {
    pointer-events: auto; display: flex; align-items: center; gap: .75rem;
    padding: .85rem 1.25rem; border-radius: var(--radius-sm);
    background: var(--surface); border: 1px solid var(--border);
    box-shadow: 0 4px 16px rgba(0,0,0,.08);
    font-size: .85rem; font-weight: 500; color: var(--text-1);
    transform: translateX(110%); transition: transform .35s cubic-bezier(.2,.8,.2,1);
    min-width: 280px; position: relative; overflow: hidden;
  }
  .toast.show { transform: translateX(0); }
  .toast-icon { width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
  .toast-icon svg { width: 16px; height: 16px; stroke-width: 2.5; stroke-linecap: round; stroke-linejoin: round; fill: none; }
  .toast.success { border-left: 3px solid #22c55e; }
  .toast.success .toast-icon { background: #f0fdf4; }
  .toast.success .toast-icon svg { stroke: #16a34a; }
  .toast.error { border-left: 3px solid #ef4444; }
  .toast.error .toast-icon { background: #fef2f2; }
  .toast.error .toast-icon svg { stroke: #dc2626; }
  .toast.warning { border-left: 3px solid #f59e0b; }
  .toast.warning .toast-icon { background: #fffbeb; }
  .toast.warning .toast-icon svg { stroke: #d97706; }
  .toast-bar { position: absolute; bottom: 0; left: 0; right: 0; height: 2px; }
  .toast-bar-fill { height: 100%; animation: tBar 3.5s linear forwards; }
  .toast.success .toast-bar-fill { background: #22c55e; }
  .toast.error .toast-bar-fill { background: #ef4444; }
  .toast.warning .toast-bar-fill { background: #f59e0b; }
  @keyframes tBar { from { width:100%; } to { width:0%; } }

  /* ── Responsive ── */
  @media(max-width:768px) {
    .save-bar { left: 0; padding: .75rem 1rem; }
    .sb-hint { display: none; }
    .f-row, .upload-row { grid-template-columns: 1fr; }
    .social-field { flex-direction: column; align-items: stretch; }
    .sf-logo { width: 36px; height: 36px; }
    .sf-logo svg { width: 18px; height: 18px; }
    .page-header { flex-direction: column; align-items: flex-start; gap: 1rem; }
    .ph-completeness { width: 100%; }
    .ph-comp-bar { flex: 1; }
    .ph-name-display, .ph-name-input { max-width: 200px; }
  }
  @media(max-width:480px) {
    .s-card-body { padding: 1.25rem; }
    .s-card-head { padding: 1rem 1.25rem; }
    .ph-name-display, .ph-name-input { max-width: 160px; }
  }

  @media(prefers-reduced-motion:reduce) {
    .s-card { animation: none; }
    .toast { transition-duration: .01s; }
  }
</style>

<div id="toast-container"></div>

<form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" id="settingsForm">
  @csrf

  <div class="settings-wrap">

    <!-- Header -->
    <div class="page-header">
      <div class="ph-left">
        <div class="ph-icon">
          <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
        </div>
        <div class="ph-text">
          <h1>Pengaturan Website</h1>
          <p class="ph-sub">Kelola konten utama dan tampilan</p>
          <div class="ph-name">
            <svg class="ph-name-icon" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            <span class="ph-name-display" id="headerNameDisplay" title="Klik untuk edit nama">
              {{ $settings['name'] ?? 'Ahmad Badrul Falah' }}
              <span class="edit-hint">edit</span>
            </span>
            <input type="text" class="ph-name-input" id="headerNameInput" value="{{ $settings['name'] ?? 'Ahmad Badrul Falah' }}" maxlength="50">
          </div>
        </div>
      </div>
      <div class="ph-completeness">
        <span class="ph-comp-pct" id="compPct">0%</span>
        <div class="ph-comp-bar"><div class="ph-comp-fill" id="compBar" style="width:0%"></div></div>
        <span class="ph-comp-label">profil lengkap</span>
      </div>
    </div>

    <!-- 1. Identitas & Hero -->
    <div class="s-card">
      <div class="s-card-head">
        <div class="sch-icon purple">
          <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        </div>
        <div class="sch-text">
          <h2>Identitas & Hero</h2>
          <p>Nama, Judul Halaman, dan Deskripsi Utama</p>
        </div>
      </div>
      <div class="s-card-body">
        
        <div class="f-row">
          <div class="f-group">
            <label class="f-label">Nama Lengkap <span class="req">*</span></label>
            <input type="text" name="name" class="f-input" id="nameInput" value="{{ $settings['name'] ?? '' }}" placeholder="Ahmad Badrul Falah">
            <div class="f-hint">Muncul di Header & Hero</div>
          </div>
          <div class="f-group">
            <label class="f-label">Judul Tab Browser</label>
            <div class="f-input-wrap">
              <input type="text" name="title" class="f-input has-suffix" value="{{ $settings['title'] ?? '' }}" placeholder="Ahmad Badrul Falah — Developer" maxlength="60" oninput="updateCharCount(this,'titleCC')">
              <div class="suffix"><span class="char-count" id="titleCC">{{ strlen($settings['title'] ?? '') }}/60</span></div>
            </div>
          </div>
        </div>

        <hr class="f-divider">

        <div class="f-full">
            <label class="f-label">Deskripsi Hero</label>
            <textarea name="hero_desc" class="f-input f-textarea" rows="3" placeholder="Deskripsi singkat di bawah nama...">{{ $settings['hero_desc'] ?? '' }}</textarea>
        </div>
        <div class="f-full" style="margin-top:1.25rem">
            <label class="f-label">Deskripsi Kontak</label>
            <textarea name="contact_desc" class="f-input f-textarea" rows="3" placeholder="Teks ajakan di section kontak...">{{ $settings['contact_desc'] ?? '' }}</textarea>
        </div>

        <!-- ========================================== -->
        <!-- SECTION: HERO VISUAL SERVICES CARD -->
        <!-- ========================================== -->
        <hr class="f-divider">

        <div class="f-full">
            <label class="f-label" style="color:var(--primary); font-weight:700; margin-bottom:0.5rem; display:block; border-bottom:1px solid var(--border); padding-bottom:0.5rem; margin-top: 1rem;">Hero Visual (Services Card)</label>
            <div class="f-hint" style="margin-top:0">Pengaturan tampilan kartu layanan di sisi kanan Hero.</div>
        </div>

        <div class="f-row" style="margin-top: 1.25rem;">
          <div class="f-group">
            <label class="f-label">Judul Kartu</label>
            <input type="text" name="hero_card_title" class="f-input" value="{{ $settings['hero_card_title'] ?? 'Services' }}" placeholder="Contoh: Services">
            <div class="f-hint">Teks besar di kiri atas kartu</div>
          </div>
          <div class="f-group">
            <label class="f-label">Sub Judul Kartu</label>
            <input type="text" name="hero_card_subtitle" class="f-input" value="{{ $settings['hero_card_subtitle'] ?? 'Our Services' }}" placeholder="Contoh: Our Services">
            <div class="f-hint">Teks kecil (uppercase) di bawah judul</div>
          </div>
        </div>

        <div class="f-full" style="margin-top: 1.25rem;">
          <label class="f-label">Daftar Layanan</label>
          <textarea name="hero_card_items" class="f-input f-textarea" rows="2" placeholder="Web Development, UI Design, Mobile Development">{{ $settings['hero_card_items'] ?? 'Web Development, User Interface Design, Mobile Development' }}</textarea>
          <div class="f-hint">Pisahkan setiap layanan dengan tanda koma (,).</div>
        </div>
        <!-- ========================================== -->

      </div>
    </div>

    <!-- 2. WhatsApp -->
    <div class="s-card">
      <div class="s-card-head">
        <div class="sch-icon green">
          <svg viewBox="0 0 24 24"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
        </div>
        <div class="sch-text">
          <h2>WhatsApp Integration</h2>
          <p>Atur nomor dan pesan otomatis</p>
        </div>
      </div>
      <div class="s-card-body">
        <div class="f-row">
          <div class="f-group">
            <label class="f-label">Nomor WhatsApp</label>
            <div class="f-input-wrap">
              <span class="prefix">+</span>
              <input type="text" name="whatsapp" class="f-input has-prefix" value="{{ $settings['whatsapp'] ?? '' }}" placeholder="6281234567890">
            </div>
            <div class="f-hint">Kode negara + nomor, tanpa tanda +</div>
          </div>
          <div class="f-group">
            <label class="f-label">Pesan Pembuka</label>
            <input type="text" name="wa_message" class="f-input" value="{{ $settings['wa_message'] ?? '' }}" placeholder="Halo! Saya ingin...">
          </div>
        </div>
      </div>
    </div>

    <!-- 3. Media -->
    <div class="s-card">
      <div class="s-card-head">
        <div class="sch-icon amber">
          <svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
        </div>
        <div class="sch-text">
          <h2>Media & Aset</h2>
          <p>Foto profil, favicon, dan link avatar</p>
        </div>
      </div>
      <div class="s-card-body">
        <div class="upload-row">
          <div class="upload-box {{ !empty($settings['avatar']) ? 'has-file' : '' }}" id="avatarBox"
            ondragenter="dragOn(event,'avatarBox')" ondragover="dragOn(event,'avatarBox')"
            ondragleave="dragOff(event,'avatarBox')" ondrop="dropIt(event,'avatarBox')">
            <input type="file" name="avatar" accept="image/*" onchange="prevUpload(this,'avatar')">
            <button type="button" class="ub-remove {{ !empty($settings['avatar']) ? 'show' : '' }}" onclick="clearUpload('avatar')">
              <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
            <div class="ub-icon">
              <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </div>
            <div class="ub-title">Foto Profil</div>
            <div class="ub-desc">Klik atau seret file ke sini</div>
            <div class="ub-badges"><span class="ub-badge">JPG</span><span class="ub-badge">PNG</span><span class="ub-badge">2MB</span></div>
            <div class="ub-preview" id="avatarPreview">
              @if(!empty($settings['avatar']))
                <img src="{{ Storage::url($settings['avatar']) }}" alt="Avatar" class="prev-avatar">
              @endif
            </div>
          </div>
          <div class="upload-box {{ !empty($settings['favicon']) ? 'has-file' : '' }}" id="faviconBox"
            ondragenter="dragOn(event,'faviconBox')" ondragover="dragOn(event,'faviconBox')"
            ondragleave="dragOff(event,'faviconBox')" ondrop="dropIt(event,'faviconBox')">
            <input type="file" name="favicon" accept="image/*,.ico" onchange="prevUpload(this,'favicon')">
            <button type="button" class="ub-remove {{ !empty($settings['favicon']) ? 'show' : '' }}" onclick="clearUpload('favicon')">
              <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
            <div class="ub-icon">
              <svg viewBox="0 0 24 24"><path d="M12 19l7-7 3 3-7 7-3-3-3z"/><path d="M18.73 5.41l-1.28-1.28L9 12.58l-8.55 8.55 1.41-1.41L9 9.17l8.73-8.73z"/></svg>
            </div>
            <div class="ub-title">Favicon</div>
            <div class="ub-desc">Ikon tab browser</div>
            <div class="ub-badges"><span class="ub-badge">ICO</span><span class="ub-badge">PNG</span><span class="ub-badge">32×32</span></div>
            <div class="ub-preview" id="faviconPreview">
              @if(!empty($settings['favicon']))
                <img src="{{ Storage::url($settings['favicon']) }}" alt="Favicon" class="prev-favicon">
              @endif
            </div>
          </div>
        </div>
        <div class="f-full" style="margin-top:1.25rem">
          <label class="f-label">Link Tujuan Avatar</label>
          <input type="url" name="avatar_link" class="f-input" value="{{ $settings['avatar_link'] ?? '' }}" placeholder="https://instagram.com/username">
          <div class="f-hint">Link terbuka saat foto profil diklik</div>
        </div>
      </div>
    </div>

    <!-- 4. Sosial Media -->
    <div class="s-card">
      <div class="s-card-head">
        <div class="sch-icon rose">
          <svg viewBox="0 0 24 24"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
        </div>
        <div class="sch-text">
          <h2>Sosial Media</h2>
          <p>Hubungkan profil profesional kamu</p>
        </div>
      </div>
      <div class="s-card-body">
        <div class="social-list">
          <div class="social-field {{ !empty($settings['github']) ? 'connected' : '' }}">
            <div class="sf-logo" style="background:#f4f4f5; color:#24292f;">
              <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.374 0 0 5.373 0 12c0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23A11.509 11.509 0 0112 5.803c1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576C20.566 21.797 24 17.3 24 12c0-6.627-5.373-12-12-12z"/></svg>
            </div>
            <div class="sf-body">
              <div class="sf-label">GitHub <span class="sf-brand">GITHUB</span></div>
              <input type="url" name="github" class="sf-input" value="{{ $settings['github'] ?? '' }}" placeholder="https://github.com/username">
              <div class="sf-status {{ !empty($settings['github']) ? 'on' : 'off' }}"><span class="dot"></span>{{ !empty($settings['github']) ? 'Terhubung' : 'Belum diisi' }}</div>
            </div>
          </div>
          <div class="social-field {{ !empty($settings['linkedin']) ? 'connected' : '' }}">
            <div class="sf-logo" style="background:#eff6ff; color:#0077b5;">
              <svg viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
            </div>
            <div class="sf-body">
              <div class="sf-label">LinkedIn <span class="sf-brand">LINKEDIN</span></div>
              <input type="url" name="linkedin" class="sf-input" value="{{ $settings['linkedin'] ?? '' }}" placeholder="https://linkedin.com/in/username">
              <div class="sf-status {{ !empty($settings['linkedin']) ? 'on' : 'off' }}"><span class="dot"></span>{{ !empty($settings['linkedin']) ? 'Terhubung' : 'Belum diisi' }}</div>
            </div>
          </div>
          <div class="social-field {{ !empty($settings['twitter']) ? 'connected' : '' }}">
            <div class="sf-logo" style="background:#f9fafb; color:#000;">
              <svg viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
            </div>
            <div class="sf-body">
              <div class="sf-label">Twitter / X <span class="sf-brand">X</span></div>
              <input type="url" name="twitter" class="sf-input" value="{{ $settings['twitter'] ?? '' }}" placeholder="https://x.com/username">
              <div class="sf-status {{ !empty($settings['twitter']) ? 'on' : 'off' }}"><span class="dot"></span>{{ !empty($settings['twitter']) ? 'Terhubung' : 'Belum diisi' }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Save Bar -->
    <div class="save-bar">
      <div class="sb-hint">
        <svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
        Perubahan tersimpan setelah klik simpan
      </div>
      <div class="sb-actions">
        <a href="{{ route('admin.dashboard') }}" class="btn-ghost">
          <svg viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
          Batal
        </a>
        <button type="submit" class="btn-primary" id="saveBtn">
          <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
          <div class="spinner"></div>
          <span class="btn-label">Simpan Perubahan</span>
        </button>
      </div>
    </div>
  </div>
</form>

<script>
  // ── Inline edit nama di header ──
  const nameDisplay = document.getElementById('headerNameDisplay');
  const nameInputHeader = document.getElementById('headerNameInput');
  const nameInputForm = document.getElementById('nameInput');
  const defaultName = '{{ $settings["name"] ?? "Ahmad Badrul Falah" }}';

  function setName(val) {
    const v = val.trim() || defaultName;
    // Update display text (tanpa span edit-hint)
    nameDisplay.childNodes[0].textContent = v;
    // Sync ke input form bawah
    nameInputForm.value = val;
    // Sync ke input header (supaya kalau edit dari bawah, header juga update)
    nameInputHeader.value = val;
    calcComp();
  }

  nameDisplay.addEventListener('click', () => {
    nameDisplay.style.display = 'none';
    nameInputHeader.style.display = 'block';
    nameInputHeader.value = nameDisplay.childNodes[0].textContent.trim();
    nameInputHeader.focus();
    nameInputHeader.select();
  });

  function finishHeaderEdit() {
    setName(nameInputHeader.value);
    nameInputHeader.style.display = 'none';
    nameDisplay.style.display = 'flex';
  }

  nameInputHeader.addEventListener('blur', finishHeaderEdit);
  nameInputHeader.addEventListener('keydown', (e) => {
    if (e.key === 'Enter') { e.preventDefault(); finishHeaderEdit(); }
    if (e.key === 'Escape') {
      nameInputHeader.value = nameDisplay.childNodes[0].textContent.trim();
      finishHeaderEdit();
    }
  });

  // ── Input form bawah juga sync ke header ──
  nameInputForm.addEventListener('input', () => {
    const v = nameInputForm.value.trim() || defaultName;
    nameDisplay.childNodes[0].textContent = v;
    nameInputHeader.value = nameInputForm.value;
    calcComp();
  });

  // ── Completeness (Diperbarui: Role, Passion, Badge dihapus) ──
  function calcComp(){
    const f=[
      nameInputForm?.value?.trim(),
      document.querySelector('input[name="title"]')?.value?.trim(),
      // role, passion, hero_badge dihapus di sini
      document.querySelector('textarea[name="hero_desc"]')?.value?.trim(),
      document.querySelector('textarea[name="contact_desc"]')?.value?.trim(),
      // Hero Visual Card fields
      document.querySelector('input[name="hero_card_title"]')?.value?.trim(),
      document.querySelector('input[name="hero_card_subtitle"]')?.value?.trim(),
      document.querySelector('textarea[name="hero_card_items"]')?.value?.trim(),
      // End NEW
      document.querySelector('input[name="whatsapp"]')?.value?.trim(),
      document.querySelector('input[name="wa_message"]')?.value?.trim(),
      document.querySelector('input[name="avatar_link"]')?.value?.trim(),
      document.querySelector('input[name="github"]')?.value?.trim(),
      document.querySelector('input[name="linkedin"]')?.value?.trim(),
      document.querySelector('input[name="twitter"]')?.value?.trim(),
    ];
    if(document.getElementById('avatarBox')?.classList.contains('has-file')) f.push('y');
    if(document.getElementById('faviconBox')?.classList.contains('has-file')) f.push('y');
    const pct=Math.round(f.filter(Boolean).length/f.length*100);
    document.getElementById('compBar').style.width=pct+'%';
    document.getElementById('compPct').textContent=pct+'%';
  }
  document.querySelectorAll('#settingsForm input,#settingsForm textarea').forEach(e=>e.addEventListener('input',calcComp));
  setTimeout(calcComp,80);

  // ── Char count ──
  function updateCharCount(el,id){const c=document.getElementById(id);if(c)c.textContent=el.value.length+'/'+el.maxLength;}

  // ── Drag & drop ──
  function dragOn(e,id){e.preventDefault();document.getElementById(id).classList.add('drag-over');}
  function dragOff(e,id){e.preventDefault();document.getElementById(id).classList.remove('drag-over');}
  function dropIt(e,id){e.preventDefault();document.getElementById(id).classList.remove('drag-over');const i=document.getElementById(id).querySelector('input[type="file"]');if(e.dataTransfer.files.length){i.files=e.dataTransfer.files;prevUpload(i,id.replace('Box',''));}}

  function prevUpload(input,type){
    const file=input.files[0];if(!file)return;
    if(file.size>2*1024*1024){showToast('Ukuran file maksimal 2MB.','warning');input.value='';return;}
    const box=document.getElementById(type+'Box'),pv=document.getElementById(type+'Preview'),rm=box.querySelector('.ub-remove');
    const r=new FileReader();
    r.onload=function(e){pv.innerHTML='<img src="'+e.target.result+'" alt="Preview" class="'+(type==='avatar'?'prev-avatar':'prev-favicon')+'">';box.classList.add('has-file');rm.classList.add('show');calcComp();};
    r.readAsDataURL(file);
  }
  function clearUpload(type){
    const box=document.getElementById(type+'Box'),pv=document.getElementById(type+'Preview'),i=box.querySelector('input[type="file"]'),rm=box.querySelector('.ub-remove');
    i.value='';pv.innerHTML='';box.classList.remove('has-file');rm.classList.remove('show');calcComp();
  }

  // ── Social status ──
  document.querySelectorAll('.sf-input').forEach(input=>{
    input.addEventListener('input',function(){
      const f=this.closest('.social-field'),s=this.closest('.sf-body').querySelector('.sf-status'),dot=s.querySelector('.dot');
      if(this.value.trim()){s.className='sf-status on';f.classList.add('connected');s.innerHTML='';s.appendChild(dot);dot.className='dot';s.append(' Terhubung');}
      else{s.className='sf-status off';f.classList.remove('connected');s.innerHTML='';s.appendChild(dot);dot.className='dot';s.append(' Belum diisi');}
      calcComp();
    });
  });

  // ── Submit ──
  const form=document.getElementById('settingsForm'),btn=document.getElementById('saveBtn');
  if(form){
    form.addEventListener('submit',function(e){
      e.preventDefault();btn.classList.add('loading');btn.querySelector('.btn-label').textContent='Menyimpan...';btn.disabled=true;
      const fd=new FormData(this);
      fetch(this.action,{method:'POST',body:fd,headers:{'X-Requested-With':'XMLHttpRequest','X-CSRF-TOKEN':document.querySelector('input[name="_token"]').value}})
      .then(r=>r.json()).then(data=>{
        if(data.success){
          showToast(data.message||'Pengaturan berhasil disimpan!','success');
          if(data.avatar_url){document.getElementById('avatarPreview').innerHTML='<img src="'+data.avatar_url+'" class="prev-avatar">';document.getElementById('avatarBox').classList.add('has-file');document.querySelector('#avatarBox .ub-remove').classList.add('show');}
          if(data.favicon_url){document.getElementById('faviconPreview').innerHTML='<img src="'+data.favicon_url+'" class="prev-favicon">';document.getElementById('faviconBox').classList.add('has-file');document.querySelector('#faviconBox .ub-remove').classList.add('show');}
          calcComp();
        }else{if(data.errors)Object.values(data.errors).forEach(m=>showToast(m[0]||m,'error'));else showToast(data.message||'Terjadi kesalahan.','error');}
      }).catch(()=>showToast('Gagal menghubungi server.','error'))
      .finally(()=>{btn.classList.remove('loading');btn.querySelector('.btn-label').textContent='Simpan Perubahan';btn.disabled=false;});
    });
  }

  // ── Toast ──
  function showToast(msg,type='success'){
    const c=document.getElementById('toast-container');
    const icons={success:'<svg viewBox="0 0 24 24" stroke="currentColor"><polyline points="20 6 9 17 4 12"/></svg>',error:'<svg viewBox="0 0 24 24" stroke="currentColor"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>',warning:'<svg viewBox="0 0 24 24" stroke="currentColor"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>'};
    const t=document.createElement('div');t.className='toast '+type;t.style.position='relative';
    t.innerHTML='<div class="toast-icon">'+(icons[type]||icons.success)+'</div><span>'+msg+'</span><div class="toast-bar"><div class="toast-bar-fill"></div></div>';
    c.appendChild(t);requestAnimationFrame(()=>requestAnimationFrame(()=>t.classList.add('show')));
    setTimeout(()=>{t.classList.remove('show');setTimeout(()=>t.remove(),400);},3500);
  }
</script>
@endsection