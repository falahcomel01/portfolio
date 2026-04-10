@extends('admin.layout')

@section('title', 'Projects')
@section('pageTitle', 'Manage Projects')

@section('content')

<!-- ALERT CONTAINER (Posisi Notifikasi) -->
<div id="alert-container"></div>

<style>
  /* ===============================
    ORIGINAL STYLES (Preserved)
    =============================== */
  /* === ADD FORM CARD === */
  .add-card {
    background: var(--bg-card);
    border-radius: 16px;
    border: 1px solid var(--border);
    overflow: hidden;
    margin-bottom: 1.5rem;
  }

  .add-card-head {
    padding: 1.25rem 1.75rem;
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: var(--bg);
    cursor: pointer;
    transition: background .15s;
  }

  .add-card-head:hover { background: #f1f5f9; }

  .add-card-head .ach-left {
    display: flex;
    align-items: center;
    gap: .75rem;
  }

  .add-card-head .ach-icon {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .add-card-head .ach-icon svg {
    width: 18px;
    height: 18px;
    stroke: #fff;
    fill: none;
    stroke-width: 2;
    stroke-linecap: round;
    stroke-linejoin: round;
  }

  .add-card-head h3 { font-size: .95rem; font-weight: 600; }
  .add-card-head .ach-sub { font-size: .78rem; color: var(--text-light); margin-top: .1rem; }

  .add-card-head .ach-toggle {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    border: 1px solid var(--border);
    background: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all .2s;
  }

  .add-card-head .ach-toggle.open {
    background: #10b981;
    border-color: #10b981;
    transform: rotate(45deg);
  }

  .add-card-head .ach-toggle svg {
    width: 16px;
    height: 16px;
    stroke: var(--text);
    fill: none;
    stroke-width: 2;
    stroke-linecap: round;
    stroke-linejoin: round;
    transition: stroke .2s;
  }

  .add-card-head .ach-toggle.open svg { stroke: #fff; }

  .add-card-body {
    max-height: 0;
    overflow: hidden;
    transition: max-height .4s ease;
  }

  .add-card-body.open { max-height: 800px; }

  .add-card-form {
    padding: 1.75rem;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.25rem;
  }

  .add-card-form .af-full { grid-column: 1 / -1; }

  .add-card-form .field label {
    display: block;
    font-size: .85rem;
    font-weight: 600;
    color: var(--text);
    margin-bottom: .4rem;
  }

  .add-card-form .field label .req { color: #ef4444; }
  .add-card-form .field label .hint {
    font-weight: 400;
    color: var(--text-light);
    font-size: .78rem;
    display: block;
    margin-top: .15rem;
  }

  .add-card-form .field input,
  .add-card-form .field textarea {
    width: 100%;
    padding: .7rem 1rem;
    border: 1.5px solid var(--border);
    border-radius: 10px;
    font-size: .9rem;
    font-family: 'Inter', sans-serif;
    transition: all .2s;
    background: #fff;
    color: var(--text);
  }

  .add-card-form .field input:focus,
  .add-card-form .field textarea:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(99,102,241,.1);
  }

  .add-card-form .field textarea {
    min-height: 90px;
    resize: vertical;
    line-height: 1.6;
  }

  /* === THUMBNAIL UPLOAD === */
  .thumb-upload-area {
    border: 2px dashed var(--border);
    border-radius: 14px;
    padding: 2rem;
    text-align: center;
    cursor: pointer;
    transition: all .2s;
    position: relative;
    overflow: hidden;
    background: var(--bg);
  }

  .thumb-upload-area:hover {
    border-color: #10b981;
    background: #f0fdf4;
  }

  .thumb-upload-area.has-image {
    padding: 0;
    border-style: solid;
    border-color: var(--border);
  }

  .thumb-upload-area input[type="file"] {
    position: absolute;
    inset: 0;
    opacity: 0;
    cursor: pointer;
  }

  .tua-placeholder {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: .5rem;
  }

  .tua-placeholder .tua-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    background: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 1px 4px rgba(0,0,0,.06);
  }

  .tua-placeholder .tua-icon svg {
    width: 22px;
    height: 22px;
    stroke: #94a3b8;
    fill: none;
    stroke-width: 2;
    stroke-linecap: round;
    stroke-linejoin: round;
  }

  .tua-placeholder .tua-label {
    font-size: .85rem;
    font-weight: 600;
    color: var(--text);
  }

  .tua-placeholder .tua-hint {
    font-size: .75rem;
    color: var(--text-light);
  }

  .thumb-upload-area img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    display: block;
  }

  /* === FORM ACTIONS === */
  .af-actions {
    grid-column: 1 / -1;
    display: flex;
    justify-content: flex-end;
    gap: .6rem;
    padding-top: .5rem;
    border-top: 1px solid var(--border);
  }

  .btn-reset {
    padding: .6rem 1.1rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: .85rem;
    border: 1.5px solid var(--border);
    background: #fff;
    color: var(--text);
    cursor: pointer;
    transition: all .15s;
    font-family: 'Inter', sans-serif;
  }

  .btn-reset:hover { background: var(--bg); }

  .btn-add-green {
    padding: .6rem 1.5rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: .85rem;
    border: none;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: #fff;
    cursor: pointer;
    transition: all .15s;
    font-family: 'Inter', sans-serif;
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    box-shadow: 0 3px 10px rgba(16,185,129,.25);
    position: relative;
  }

  .btn-add-green:hover {
    transform: translateY(-1px);
    box-shadow: 0 5px 15px rgba(16,185,129,.35);
  }

  .btn-add-green svg {
    width: 16px;
    height: 16px;
    stroke: #fff;
    fill: none;
    stroke-width: 2.5;
    stroke-linecap: round;
    stroke-linejoin: round;
  }

  /* === LIST HEADER === */
  .list-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1rem;
  }

  .list-header h3 { font-size: 1.05rem; font-weight: 600; }

  .list-count {
    font-size: .8rem;
    padding: .3rem .75rem;
    border-radius: 50px;
    background: var(--bg);
    color: var(--text-light);
    font-weight: 500;
  }

  /* === PROJECT GRID === */
  .projects-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.25rem;
  }

  /* === PROJECT CARD === */
  .project-card {
    background: var(--bg-card);
    border-radius: 16px;
    border: 1px solid var(--border);
    overflow: hidden;
    transition: all .25s;
  }

  .project-card:hover {
    border-color: #a7f3d0;
    box-shadow: 0 8px 25px rgba(16,185,129,.08);
    transform: translateY(-3px);
  }

  .pc-thumb {
    height: 180px;
    background: var(--bg);
    position: relative;
    overflow: hidden;
  }

  .pc-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .4s;
  }

  .project-card:hover .pc-thumb img {
    transform: scale(1.05);
  }

  .pc-thumb .pc-fallback {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3.5rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
  }

  .pc-thumb .pc-no-img {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: .5rem;
    color: #cbd5e1;
  }

  .pc-thumb .pc-no-img svg {
    width: 36px;
    height: 36px;
    stroke: #e2e8f0;
    fill: none;
    stroke-width: 1.5;
    stroke-linecap: round;
    stroke-linejoin: round;
  }

  .pc-thumb .pc-no-img span {
    font-size: .8rem;
    font-weight: 500;
  }

  .pc-thumb .pc-sort-badge {
    position: absolute;
    top: .75rem;
    left: .75rem;
    background: rgba(0,0,0,.55);
    backdrop-filter: blur(6px);
    color: #fff;
    font-size: .72rem;
    font-weight: 600;
    padding: .25rem .6rem;
    border-radius: 50px;
  }

  .pc-thumb .pc-url-badge {
    position: absolute;
    top: .75rem;
    right: .75rem;
    background: rgba(255,255,255,.9);
    backdrop-filter: blur(6px);
    color: var(--text);
    font-size: .72rem;
    font-weight: 600;
    padding: .25rem .6rem;
    border-radius: 50px;
    display: flex;
    align-items: center;
    gap: .25rem;
    text-decoration: none;
    transition: all .15s;
  }

  .pc-thumb .pc-url-badge:hover {
    background: #fff;
    box-shadow: 0 2px 8px rgba(0,0,0,.1);
  }

  .pc-thumb .pc-url-badge svg {
    width: 12px;
    height: 12px;
    stroke: var(--text);
    fill: none;
    stroke-width: 2;
    stroke-linecap: round;
    stroke-linejoin: round;
  }

  .pc-body {
    padding: 1.25rem;
  }

  .pc-title {
    font-size: 1.05rem;
    font-weight: 700;
    color: var(--text);
    margin-bottom: .4rem;
    line-height: 1.3;
  }

  .pc-desc {
    font-size: .82rem;
    color: var(--text-light);
    line-height: 1.6;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    margin-bottom: .75rem;
  }

  .pc-tags {
    display: flex;
    flex-wrap: wrap;
    gap: .35rem;
  }

  .pc-tag {
    padding: .2rem .6rem;
    border-radius: 50px;
    font-size: .72rem;
    font-weight: 500;
    background: #ecfdf5;
    color: #065f46;
  }

  .pc-actions {
    padding: .75rem 1.25rem;
    border-top: 1px solid var(--border);
    display: flex;
    justify-content: flex-end;
    gap: .5rem;
    background: var(--bg);
  }

  .sia-btn {
    padding: .4rem .75rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: .78rem;
    border: 1px solid var(--border);
    background: #fff;
    color: var(--text);
    cursor: pointer;
    transition: all .15s;
    font-family: 'Inter', sans-serif;
    display: inline-flex;
    align-items: center;
    gap: .3rem;
  }

  .sia-btn svg {
    width: 14px;
    height: 14px;
    stroke: currentColor;
    fill: none;
    stroke-width: 2;
    stroke-linecap: round;
    stroke-linejoin: round;
  }

  .sia-btn:hover { background: var(--bg); }

  .sia-btn.sia-edit:hover {
    border-color: #a7f3d0;
    color: #059669;
    background: #f0fdf4;
  }

  .sia-btn.sia-delete:hover {
    border-color: #fca5a5;
    color: #ef4444;
    background: #fef2f2;
  }

  /* === EMPTY STATE === */
  .projects-empty {
    grid-column: 1 / -1;
    text-align: center;
    padding: 4rem 2rem;
    color: var(--text-light);
  }

  .projects-empty .pe-icon {
    width: 72px;
    height: 72px;
    border-radius: 18px;
    background: var(--bg);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
  }

  .projects-empty .pe-icon svg {
    width: 32px;
    height: 32px;
    stroke: var(--border);
    fill: none;
    stroke-width: 1.5;
    stroke-linecap: round;
    stroke-linejoin: round;
  }

  .projects-empty h4 {
    font-size: 1rem;
    font-weight: 600;
    color: var(--text);
    margin-bottom: .4rem;
  }

  .projects-empty p {
    font-size: .85rem;
    max-width: 320px;
    margin: 0 auto;
    line-height: 1.5;
  }

  /* === EDIT MODAL === */
  .modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(15, 23, 42, .5);
    backdrop-filter: blur(4px);
    z-index: 200;
    align-items: center;
    justify-content: center;
    padding: 1rem;
  }

  .modal-overlay.open { display: flex; }

  .modal-box {
    background: #fff;
    border-radius: 18px;
    width: 100%;
    max-width: 600px;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 25px 60px rgba(0,0,0,.15);
    animation: modalIn .25s ease;
  }

  @keyframes modalIn {
    from { opacity: 0; transform: scale(.95) translateY(10px); }
    to { opacity: 1; transform: scale(1) translateY(0); }
  }

  .modal-head {
    padding: 1.5rem 1.75rem;
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .modal-head h3 {
    font-size: 1.05rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: .6rem;
  }

  .modal-head h3 svg {
    width: 20px;
    height: 20px;
    stroke: #059669;
    fill: none;
    stroke-width: 2;
    stroke-linecap: round;
    stroke-linejoin: round;
  }

  .modal-close {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    border: 1px solid var(--border);
    background: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all .15s;
  }

  .modal-close:hover {
    background: #fef2f2;
    border-color: #fca5a5;
  }

  .modal-close svg {
    width: 16px;
    height: 16px;
    stroke: var(--text-light);
    fill: none;
    stroke-width: 2;
    stroke-linecap: round;
    stroke-linejoin: round;
  }

  .modal-body {
    padding: 1.75rem;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.25rem;
  }

  .modal-body .mb-full { grid-column: 1 / -1; }

  .modal-body .field label {
    display: block;
    font-size: .85rem;
    font-weight: 600;
    color: var(--text);
    margin-bottom: .4rem;
  }

  .modal-body .field label .hint {
    font-weight: 400;
    color: var(--text-light);
    font-size: .78rem;
  }

  .modal-body .field label .req { color: #ef4444; }

  .modal-body .field input,
  .modal-body .field textarea {
    width: 100%;
    padding: .7rem 1rem;
    border: 1.5px solid var(--border);
    border-radius: 10px;
    font-size: .9rem;
    font-family: 'Inter', sans-serif;
    transition: all .2s;
    background: #fff;
    color: var(--text);
  }

  .modal-body .field input:focus,
  .modal-body .field textarea:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(99,102,241,.1);
  }

  .modal-body .field textarea {
    min-height: 80px;
    resize: vertical;
  }

  .modal-thumb-preview {
    border: 2px dashed var(--border);
    border-radius: 14px;
    padding: 1.5rem;
    text-align: center;
    cursor: pointer;
    transition: all .2s;
    position: relative;
    overflow: hidden;
    background: var(--bg);
  }

  .modal-thumb-preview:hover {
    border-color: #10b981;
    background: #f0fdf4;
  }

  .modal-thumb-preview.has-img {
    padding: 0;
    border-style: solid;
    border-color: var(--border);
  }

  .modal-thumb-preview input[type="file"] {
    position: absolute;
    inset: 0;
    opacity: 0;
    cursor: pointer;
  }

  .modal-thumb-preview img {
    width: 100%;
    height: 180px;
    object-fit: cover;
    display: block;
  }

  .modal-foot {
    padding: 1rem 1.75rem;
    border-top: 1px solid var(--border);
    display: flex;
    justify-content: flex-end;
    gap: .6rem;
    background: var(--bg);
    border-radius: 0 0 18px 18px;
  }

  /* ===============================
    NEW PRETTY ALERT STYLES
    =============================== */
  #alert-container {
    margin-bottom: 1.5rem;
    position: relative;
    z-index: 50; /* Agar muncul di atas elemen jika ada overlap */
  }

  .custom-alert {
    display: flex;
    align-items: flex-start;
    padding: 1.25rem 1.5rem;
    border-radius: 14px;
    font-size: 0.95rem;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05); /* Shadow lebih soft */
    animation: slideDown 0.4s cubic-bezier(0.16, 1, 0.3, 1); /* Animasi lebih smooth */
    position: relative;
    overflow: hidden;
    border: 1px solid transparent;
  }

  /* Success Style */
  .custom-alert.success {
    background-color: #f0fdf9; /* Emerald 50 - sangat muda */
    border-color: #ccfbf1; /* Emerald 200 */
    color: #047857;
  }

  .custom-alert.error {
    background-color: #fef2f2;
    border-color: #fecaca;
    color: #b91c1c;
  }

  .ca-icon {
    flex-shrink: 0;
    width: 28px;
    height: 28px; /* Icon sedikit lebih besar */
    background: #10b981;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 16px; /* Jarak lebih lega */
    box-shadow: 0 2px 4px rgba(16, 185, 129, 0.2);
  }

  .custom-alert.error .ca-icon {
    background: #ef4444;
    box-shadow: 0 2px 4px rgba(239, 68, 68, 0.2);
  }

  .ca-icon svg {
    width: 16px;
    height: 16px;
    stroke-width: 2.5; /* Ikon lebih tegas */
    stroke-linecap: round;
    stroke-linejoin: round;
  }

  .ca-content {
    flex: 1;
    padding-top: 2px; /* Align center dengan icon */
  }

  .ca-title {
    font-weight: 700;
    font-size: 1rem; /* Judul sedikit lebih besar */
    margin-bottom: 2px;
    display: block;
    letter-spacing: -0.01em;
  }

  .ca-msg {
    font-weight: 400;
    line-height: 1.5;
    opacity: 0.9; /* Deskripsi sedikit transparan agar tidak terlalu berat */
    font-size: 0.9rem;
  }

  .ca-close {
    background: transparent;
    border: none;
    cursor: pointer;
    opacity: 0.4;
    padding: 4px;
    margin-left: 12px;
    transition: all 0.2s;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .ca-close:hover { 
    opacity: 1; 
    background-color: rgba(0,0,0,0.05);
  }

  /* Animations */
  @keyframes slideDown {
    from { opacity: 0; transform: translateY(-15px); }
    to { opacity: 1; transform: translateY(0); }
  }

  @keyframes fadeOut {
    from { opacity: 1; transform: scale(1); }
    to { opacity: 0; transform: scale(0.98); }
  }

  /* Loading Spinner for Buttons */
  .btn-loading {
    color: transparent !important;
    pointer-events: none;
    position: relative;
  }

  .btn-loading::after {
    content: "";
    position: absolute;
    left: 50%;
    top: 50%;
    width: 18px;
    height: 18px;
    border: 2px solid rgba(255,255,255,0.3);
    border-radius: 50%;
    border-top-color: #fff;
    animation: spin 0.8s linear infinite;
    transform: translate(-50%, -50%);
  }

  @keyframes spin { to { transform: translate(-50%, -50%) rotate(360deg); } }

  /* === RESPONSIVE === */
  @media (max-width: 1024px) {
    .projects-grid { grid-template-columns: 1fr; }
  }

  @media (max-width: 768px) {
    .add-card-form { grid-template-columns: 1fr; }
    .add-card-form .af-full { grid-column: 1; }
    .modal-body { grid-template-columns: 1fr; }
    .modal-body .mb-full { grid-column: 1; }
    .custom-alert { padding: 1rem; }
  }
</style>

<!-- ========== ADD NEW PROJECT ========== -->
<div class="add-card">
  <div class="add-card-head" onclick="toggleAddForm()">
    <div class="ach-left">
      <div class="ach-icon">
        <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      </div>
      <div>
        <h3>Tambah Project Baru</h3>
        <div class="ach-sub">Klik untuk membuka form</div>
      </div>
    </div>
    <div class="ach-toggle" id="addToggle">
      <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
    </div>
  </div>
  <div class="add-card-body" id="addBody">
    <form method="POST" action="{{ route('admin.projects.store') }}" enctype="multipart/form-data" class="add-card-form" id="createProjectForm">
      @csrf
      <div class="field">
        <label>Judul Project <span class="req">*</span></label>
        <input type="text" name="title" required placeholder="Contoh: E-Commerce Website">
      </div>
      <div class="field">
        <label>URL Project</label>
        <input type="url" name="url" placeholder="https://example.com">
      </div>
      <div class="field af-full">
        <label>Deskripsi</label>
        <textarea name="description" rows="2" placeholder="Deskripsi singkat project..."></textarea>
      </div>
      <div class="field">
        <label>Tags <span class="hint">Pisahkan dengan koma</span></label>
        <input type="text" name="tags" placeholder="Laravel, Vue, Tailwind">
      </div>
      <div class="field">
        <label>Urutan</label>
        <input type="number" name="sort_order" value="{{ $projects->count() }}" placeholder="0">
      </div>
      <div class="field af-full">
        <label>Thumbnail <span class="hint">PNG, JPG, WebP. Max 2MB.</span></label>
        <div class="thumb-upload-area" id="addThumbArea">
          <input type="file" name="thumbnail" accept="image/*" onchange="previewAddThumb(this)">
          <div class="tua-placeholder" id="addThumbPlaceholder">
            <div class="tua-icon">
              <svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
            </div>
            <div class="tua-label">Upload Thumbnail</div>
            <div class="tua-hint">Klik atau seret gambar ke sini</div>
          </div>
        </div>
      </div>
      <!-- BAGIAN ICON FALLBACK & PREVIEW DIHAPUS DISINI -->
      <div class="af-actions">
        <button type="reset" class="btn-reset">Reset</button>
        <button type="submit" class="btn-add-green" id="btnAddProject">
          <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
          Tambah Project
        </button>
      </div>
    </form>
  </div>
</div>

<!-- ========== PROJECT LIST ========== -->
<div class="list-header">
  <h3>Daftar Projects</h3>
  <span class="list-count">{{ $projects->count() }} project terdaftar</span>
</div>

<div class="projects-grid">
  @if($projects->count())
    @foreach($projects as $project)
    <div class="project-card">
      <div class="pc-thumb">
        @if($project->thumbnail)
          <img src="{{ Storage::url($project->thumbnail) }}" alt="{{ $project->title }}">
        @elseif($project->icon)
          <div class="pc-fallback">{{ $project->icon }}</div>
        @else
          <div class="pc-no-img">
            <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
            <span>Tidak ada gambar</span>
          </div>
        @endif
        <span class="pc-sort-badge">#{{ $project->sort_order }}</span>
        @if($project->url)
          <a href="{{ $project->url }}" target="_blank" class="pc-url-badge">
            <svg viewBox="0 0 24 24"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
            Live
          </a>
        @endif
      </div>
      <div class="pc-body">
        <div class="pc-title">{{ $project->title }}</div>
        <div class="pc-desc">{{ $project->description }}</div>
        @if($project->tags)
        <div class="pc-tags">
          @foreach(explode(',', $project->tags) as $tag)
            @if(trim($tag))
              <span class="pc-tag">{{ trim($tag) }}</span>
            @endif
          @endforeach
        </div>
        @endif
      </div>
      <div class="pc-actions">
        <button class="sia-btn sia-edit" onclick='openEditModal(
          {{ $project->id }},
          `{{ addslashes($project->title) }}`,
          `{{ addslashes($project->description ?? "") }}`,
          `{{ addslashes($project->tags ?? "") }}`,
          `{{ addslashes($project->icon ?? "") }}`,
          `{{ $project->url ?? "" }}`,
          {{ $project->sort_order }},
          `{{ $project->thumbnail ?? "" }}`
        )'>
          <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
          Edit
        </button>
        <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus project \"{{ addslashes($project->title) }}\"?')">
          @csrf @method('DELETE')
          <button type="submit" class="sia-btn sia-delete">
            <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
            Hapus
          </button>
        </form>
      </div>
    </div>
    @endforeach
  @else
    <div class="projects-empty">
      <div class="pe-icon">
        <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
      </div>
      <h4>Belum ada project</h4>
      <p>Tambahkan project pertamamu untuk memperlihatkan karya terbaikmu.</p>
    </div>
  @endif
</div>

<!-- ========== EDIT MODAL ========== -->
<div class="modal-overlay" id="editModal">
  <div class="modal-box">
    <div class="modal-head">
      <h3>
        <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
        Edit Project
      </h3>
      <button class="modal-close" onclick="closeEditModal()">
        <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
      </button>
    </div>
    <form method="POST" id="editForm" enctype="multipart/form-data">
      @csrf @method('PUT')
      <div class="modal-body">
        <div class="field mb-full">
          <label>Judul Project <span class="req">*</span></label>
          <input type="text" name="title" id="editTitle" required>
        </div>
        <div class="field">
          <label>URL Project</label>
          <input type="url" name="url" id="editUrl">
        </div>
        <div class="field">
          <label>Urutan</label>
          <input type="number" name="sort_order" id="editSort">
        </div>
        <div class="field mb-full">
          <label>Deskripsi</label>
          <textarea name="description" id="editDesc" rows="2"></textarea>
        </div>
        <div class="field mb-full">
          <label>Tags <span class="hint">Pisahkan dengan koma</span></label>
          <input type="text" name="tags" id="editTags">
        </div>
        <div class="field mb-full">
          <label>Thumbnail</label>
          <div class="modal-thumb-preview" id="editThumbArea">
            <input type="file" name="thumbnail" accept="image/*" onchange="previewEditThumb(this)">
            <div class="tua-placeholder" id="editThumbPlaceholder">
              <div class="tua-icon">
                <svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
              </div>
              <div class="tua-label">Upload Thumbnail Baru</div>
              <div class="tua-hint">Kosongkan jika tidak ingin mengubah</div>
            </div>
          </div>
        </div>
        <!-- BAGIAN ICON FALLBACK & PREVIEW DIHAPUS DISINI -->
      </div>
      <div class="modal-foot">
        <button type="button" class="btn-reset" onclick="closeEditModal()">Batal</button>
        <button type="submit" class="btn-add-green" id="btnSaveProject">
          <svg viewBox="0 0 24 24" style="stroke-width:2.5"><polyline points="20 6 9 17 4 12"/></svg>
          Simpan Perubahan
        </button>
      </div>
    </form>
  </div>
</div>

<script>
// ==========================================
// 1. CLEANUP OLD NOTIFICATIONS & INIT
// ==========================================
document.addEventListener('DOMContentLoaded', () => {
  // Remove all old notifications aggressively to prevent duplicates
  const oldAlerts = document.querySelectorAll('.alert, .flash-message, [role="alert"], .custom-alert');
  oldAlerts.forEach(el => el.remove());

  // Clear container just in case
  const container = document.getElementById('alert-container');
  if(container) container.innerHTML = '';

  // Check for Laravel Session Messages
  const sessionSuccess = "{{ session('success') ?? '' }}";
  const sessionError = "{{ session('error') ?? '' }}";

  if (sessionSuccess && sessionSuccess.length > 0 && sessionSuccess !== '""') {
    showInlineAlert('Berhasil!', sessionSuccess, 'success');
  }
  
  if (sessionError && sessionError.length > 0 && sessionError !== '""') {
    showInlineAlert('Gagal!', sessionError, 'error');
  }
});

// ==========================================
// 2. PRETTY INLINE ALERT LOGIC
// ==========================================
function showInlineAlert(title, message, type = 'success') {
  const container = document.getElementById('alert-container');
  if(!container) return;

  // Clear container immediately to avoid stacking
  container.innerHTML = '';

  const alert = document.createElement('div');
  alert.className = `custom-alert ${type}`;
  
  // Icons
  const successIcon = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><polyline points="20 6 9 17 4 12"/></svg>`;
  const errorIcon = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>`;
  
  const iconSvg = type === 'success' ? successIcon : errorIcon;

  alert.innerHTML = `
    <div class="ca-icon">
      ${iconSvg}
    </div>
    <div class="ca-content">
      <span class="ca-title">${title}</span>
      <span class="ca-msg">${message}</span>
    </div>
    <button class="ca-close" onclick="this.parentElement.remove()">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
    </button>
  `;

  container.appendChild(alert);

  // Auto remove after 4.5 seconds with smooth animation
  setTimeout(() => {
    if(alert.parentElement) {
      alert.style.animation = 'fadeOut 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards';
      alert.addEventListener('animationend', () => {
        if(alert.parentElement) alert.remove();
      });
    }
  }, 4500);
}

// ==========================================
// 3. FORM SUBMISSIONS & LOADING STATES
// ==========================================

// Add Form
const createForm = document.getElementById('createProjectForm');
const btnAdd = document.getElementById('btnAddProject');

if (createForm) {
  createForm.addEventListener('submit', function() {
    if(btnAdd) btnAdd.classList.add('btn-loading');
  });
}

// Edit Form
const editForm = document.getElementById('editForm');
const btnSave = document.getElementById('btnSaveProject');

if (editForm) {
  editForm.addEventListener('submit', function() {
    if(btnSave) btnSave.classList.add('btn-loading');
  });
}

// ==========================================
// 4. EXISTING LOGIC (UI INTERACTIONS)
// ==========================================

// === TOGGLE ADD FORM ===
function toggleAddForm() {
  const body = document.getElementById('addBody');
  const toggle = document.getElementById('addToggle');
  body.classList.toggle('open');
  toggle.classList.toggle('open');
}

// === THUMBNAIL PREVIEWS ===
function previewAddThumb(input) {
  const area = document.getElementById('addThumbArea');
  const ph = document.getElementById('addThumbPlaceholder');
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = function(e) {
      if(ph) ph.style.display = 'none';
      area.classList.add('has-image');
      const existingImg = area.querySelector('img');
      if(existingImg) existingImg.remove();
      
      const img = document.createElement('img');
      img.src = e.target.result;
      area.appendChild(img);
    };
    reader.readAsDataURL(input.files[0]);
  }
}

function previewEditThumb(input) {
  const area = document.getElementById('editThumbArea');
  const ph = document.getElementById('editThumbPlaceholder');
  const oldImg = area.querySelector('img');
  if (oldImg) oldImg.remove();

  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = function(e) {
      if(ph) ph.style.display = 'none';
      area.classList.add('has-image');
      const img = document.createElement('img');
      img.src = e.target.result;
      area.appendChild(img);
    };
    reader.readAsDataURL(input.files[0]);
  } else {
    if(ph) ph.style.display = '';
    area.classList.remove('has-image');
  }
}

// === EDIT MODAL ===
function openEditModal(id, title, desc, tags, icon, url, sort, thumb) {
  const form = document.getElementById('editForm');
  if(form) form.action = '/admin/projects/' + id;
  
  const editTitle = document.getElementById('editTitle');
  const editDesc = document.getElementById('editDesc');
  const editTags = document.getElementById('editTags');
  const editIcon = document.getElementById('editIcon'); // Keep var definition for safety, though not used
  const editUrl = document.getElementById('editUrl');
  const editSort = document.getElementById('editSort');
  
  // Icon preview logic removed
  // const editEmojiPreview = document.getElementById('editEmojiPreview'); 

  if(editTitle) editTitle.value = title;
  if(editDesc) editDesc.value = desc;
  if(editTags) editTags.value = tags;
  // if(editIcon) editIcon.value = icon; // Removed
  if(editUrl) editUrl.value = url;
  if(editSort) editSort.value = sort;
  // if(editEmojiPreview) editEmojiPreview.textContent = icon || '🌐'; // Removed

  // Reset thumb preview
  const area = document.getElementById('editThumbArea');
  const ph = document.getElementById('editThumbPlaceholder');
  const oldImg = area.querySelector('img');
  if (oldImg) oldImg.remove();

  if (thumb) {
    if(ph) ph.style.display = 'none';
    area.classList.add('has-image');
    const img = document.createElement('img');
    img.src = '/storage/' + thumb;
    area.appendChild(img);
  } else {
    if(ph) ph.style.display = '';
    area.classList.remove('has-image');
  }

  document.getElementById('editModal').classList.add('open');
  document.body.style.overflow = 'hidden';
}

function closeEditModal() {
  document.getElementById('editModal').classList.remove('open');
  document.body.style.overflow = '';
  
  if(btnSave) btnSave.classList.remove('btn-loading');
}

// Close on overlay click
const modal = document.getElementById('editModal');
if(modal) {
  modal.addEventListener('click', function(e) {
    if (e.target === this) closeEditModal();
  });
}

// Close on Escape
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') closeEditModal();
});

// Drag & drop highlight for thumbnail areas
document.querySelectorAll('.thumb-upload-area, .modal-thumb-preview').forEach(area => {
  ['dragenter', 'dragover'].forEach(evt => {
    area.addEventListener(evt, e => {
      e.preventDefault();
      e.stopPropagation();
      area.style.borderColor = '#10b981';
      area.style.background = '#f0fdf4';
    });
  });
  ['dragleave', 'drop'].forEach(evt => {
    area.addEventListener(evt, e => {
      e.preventDefault();
      e.stopPropagation();
      area.style.borderColor = '';
      area.style.background = '';
    });
  });
});
</script>

@endsection