@extends('admin.layout')

@section('title', 'Skills')
@section('pageTitle', 'Manage Skills')

@section('content')
<style>
  /* ==========================================
     TOAST NOTIFICATION STYLE (DITAMBAHKAN)
     ========================================== */
  :root {
    --toast-success: #10b981;
    --toast-error: #ef4444;
    --toast-bg: #ffffff;
  }

  #toast-container {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 9999;
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  .toast {
    background: var(--toast-bg);
    border-radius: 10px;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
    display: flex;
    align-items: center;
    padding: 1rem;
    min-width: 300px;
    max-width: 400px;
    border-left: 5px solid var(--toast-success);
    transform: translateX(120%);
    transition: transform 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55), opacity 0.4s ease;
    opacity: 0;
    position: relative;
    overflow: hidden;
  }

  .toast.show {
    transform: translateX(0);
    opacity: 1;
  }

  .toast.hide {
    transform: translateX(120%);
    opacity: 0;
  }

  .toast-bg-icon {
    position: absolute;
    right: -10px;
    bottom: -10px;
    width: 80px;
    height: 80px;
    opacity: 0.05;
    transform: rotate(-15deg);
    pointer-events: none;
  }

  .toast-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #ecfdf5;
    color: var(--toast-success);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    margin-right: 12px;
  }

  .toast-icon svg {
    width: 22px;
    height: 22px;
    stroke-width: 2.5;
    stroke-linecap: round;
    stroke-linejoin: round;
    fill: none;
  }

  .toast-content {
    flex: 1;
    z-index: 1;
  }

  .toast-title {
    font-weight: 700;
    font-size: 0.9rem;
    color: var(--text);
    margin-bottom: 2px;
    display: flex;
    align-items: center;
    gap: 6px;
  }

  .toast-message {
    font-size: 0.8rem;
    color: var(--text-light);
    line-height: 1.4;
  }

  .toast-progress {
    position: absolute;
    bottom: 0;
    left: 0;
    height: 3px;
    background: var(--toast-success);
    width: 100%;
    transform-origin: left;
    animation: toastProgress 4s linear forwards;
  }

  @keyframes toastProgress {
    from { transform: scaleX(1); }
    to { transform: scaleX(0); }
  }

  /* ==========================================
     STYLE ASLI HALAMAN SKILLS
     ========================================== */
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
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
    background: var(--primary);
    border-color: var(--primary);
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

  .add-card-body.open { max-height: 600px; }

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

  /* === ICON UPLOAD INLINE === */
  .icon-upload-row {
    display: flex;
    align-items: flex-end;
    gap: 1rem;
  }

  .icon-upload-box {
    width: 80px;
    height: 80px;
    border: 2px dashed var(--border);
    border-radius: 14px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all .2s;
    position: relative;
    flex-shrink: 0;
    overflow: hidden;
    background: var(--bg);
  }

  .icon-upload-box:hover {
    border-color: var(--primary);
    background: #fafaff;
  }

  .icon-upload-box input[type="file"] {
    position: absolute;
    inset: 0;
    opacity: 0;
    cursor: pointer;
  }

  .icon-upload-box .iub-placeholder {
    text-align: center;
  }

  .icon-upload-box .iub-placeholder svg {
    width: 22px;
    height: 22px;
    stroke: #cbd5e1;
    fill: none;
    stroke-width: 2;
    stroke-linecap: round;
    stroke-linejoin: round;
  }

  .icon-upload-box .iub-placeholder span {
    font-size: .65rem;
    color: #94a3b8;
    margin-top: .2rem;
    display: block;
  }

  .icon-upload-box img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    padding: 8px;
  }

  .icon-upload-info { flex: 1; }

  .icon-upload-info label {
    font-size: .85rem;
    font-weight: 600;
    color: var(--text);
    margin-bottom: .4rem;
    display: block;
  }

  .icon-upload-info p {
    font-size: .78rem;
    color: var(--text-light);
    line-height: 1.5;
  }

  .icon-upload-info p code {
    background: var(--bg);
    padding: .1rem .4rem;
    border-radius: 4px;
    font-size: .75rem;
  }

  /* === FORM ACTIONS INLINE === */
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

  .btn-add {
    padding: .6rem 1.5rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: .85rem;
    border: none;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    cursor: pointer;
    transition: all .15s;
    font-family: 'Inter', sans-serif;
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    box-shadow: 0 3px 10px rgba(99,102,241,.25);
  }

  .btn-add:hover {
    transform: translateY(-1px);
    box-shadow: 0 5px 15px rgba(99,102,241,.35);
  }

  .btn-add svg {
    width: 16px;
    height: 16px;
    stroke: #fff;
    fill: none;
    stroke-width: 2.5;
    stroke-linecap: round;
    stroke-linejoin: round;
  }

  /* === SKILL LIST === */
  .skills-list-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1rem;
  }

  .skills-list-header h3 {
    font-size: 1.05rem;
    font-weight: 600;
  }

  .skills-count {
    font-size: .8rem;
    padding: .3rem .75rem;
    border-radius: 50px;
    background: var(--bg);
    color: var(--text-light);
    font-weight: 500;
  }

  .skills-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
  }

  /* === SKILL CARD === */
  .skill-item {
    background: var(--bg-card);
    border-radius: 14px;
    border: 1px solid var(--border);
    overflow: hidden;
    transition: all .2s;
    position: relative;
  }

  .skill-item:hover {
    border-color: #c7d2fe;
    box-shadow: 0 4px 15px rgba(99,102,241,.08);
  }

  .skill-item-top {
    padding: 1.25rem 1.25rem 0;
    display: flex;
    align-items: flex-start;
    gap: 1rem;
  }

  .skill-item-icon {
    width: 52px;
    height: 52px;
    border-radius: 12px;
    background: var(--bg);
    border: 1px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    overflow: hidden;
    padding: 6px;
  }

  .skill-item-icon img {
    width: 100%;
    height: 100%;
    object-fit: contain;
  }

  .skill-item-icon .no-icon {
    font-size: .7rem;
    color: #cbd5e1;
    font-weight: 500;
    text-align: center;
    line-height: 1.2;
  }

  .skill-item-info { flex: 1; min-width: 0; }

  .skill-item-name {
    font-size: 1rem;
    font-weight: 700;
    color: var(--text);
    margin-bottom: .25rem;
    display: flex;
    align-items: center;
    gap: .5rem;
  }

  .skill-item-name .sort-badge {
    font-size: .65rem;
    font-weight: 600;
    padding: .15rem .5rem;
    border-radius: 50px;
    background: #f1f5f9;
    color: var(--text-light);
  }

  .skill-item-desc {
    font-size: .82rem;
    color: var(--text-light);
    line-height: 1.5;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .skill-item-tags {
    padding: .75rem 1.25rem;
    display: flex;
    flex-wrap: wrap;
    gap: .35rem;
  }

  .skill-tag {
    padding: .2rem .6rem;
    border-radius: 50px;
    font-size: .72rem;
    font-weight: 500;
    background: #eef2ff;
    color: #4f46e5;
  }

  .skill-item-actions {
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

  .sia-btn:hover {
    background: var(--bg);
  }

  .sia-btn.sia-edit:hover {
    border-color: #c7d2fe;
    color: var(--primary);
    background: #fafaff;
  }

  .sia-btn.sia-delete:hover {
    border-color: #fca5a5;
    color: #ef4444;
    background: #fef2f2;
  }

  /* === EMPTY STATE === */
  .skills-empty {
    grid-column: 1 / -1;
    text-align: center;
    padding: 4rem 2rem;
    color: var(--text-light);
  }

  .skills-empty .se-icon {
    width: 72px;
    height: 72px;
    border-radius: 18px;
    background: var(--bg);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
  }

  .skills-empty .se-icon svg {
    width: 32px;
    height: 32px;
    stroke: var(--border);
    fill: none;
    stroke-width: 1.5;
    stroke-linecap: round;
    stroke-linejoin: round;
  }

  .skills-empty h4 {
    font-size: 1rem;
    font-weight: 600;
    color: var(--text);
    margin-bottom: .4rem;
  }

  .skills-empty p {
    font-size: .85rem;
    max-width: 300px;
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
    max-width: 560px;
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
    stroke: var(--primary);
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

  .modal-foot {
    padding: 1rem 1.75rem;
    border-top: 1px solid var(--border);
    display: flex;
    justify-content: flex-end;
    gap: .6rem;
    background: var(--bg);
    border-radius: 0 0 18px 18px;
  }

  /* === RESPONSIVE === */
  @media (max-width: 1024px) {
    .skills-grid { grid-template-columns: 1fr; }
  }

  @media (max-width: 768px) {
    .add-card-form { grid-template-columns: 1fr; }
    .add-card-form .af-full { grid-column: 1; }
    .icon-upload-row { flex-direction: column; align-items: stretch; }
    .icon-upload-box { width: 100%; height: 100px; flex-direction: row; gap: .5rem; padding: .75rem; }
    .icon-upload-box .iub-placeholder { display: flex; align-items: center; gap: .5rem; }
    .modal-body { grid-template-columns: 1fr; }
    .modal-body .mb-full { grid-column: 1; }
  }
</style>

<!-- Container untuk Notifikasi -->
<div id="toast-container"></div>

<!-- ========== ADD NEW SKILL ========== -->
<div class="add-card">
  <div class="add-card-head" onclick="toggleAddForm()">
    <div class="ach-left">
      <div class="ach-icon">
        <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      </div>
      <div>
        <h3>Tambah Skill Baru</h3>
        <div class="ach-sub">Klik untuk membuka form</div>
      </div>
    </div>
    <div class="ach-toggle" id="addToggle">
      <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
    </div>
  </div>
  <div class="add-card-body" id="addBody">
    <form method="POST" action="{{ route('admin.skills.store') }}" enctype="multipart/form-data" class="add-card-form" id="addSkillForm">
      @csrf
      <div class="field">
        <label>Nama Skill <span class="req">*</span></label>
        <input type="text" name="name" required placeholder="Contoh: JavaScript">
      </div>
      <div class="field">
        <label>Urutan</label>
        <input type="number" name="sort_order" value="{{ $skills->count() }}" placeholder="0">
      </div>
      <div class="field af-full">
        <label>Deskripsi</label>
        <textarea name="description" rows="2" placeholder="Deskripsi singkat skill ini..."></textarea>
      </div>
      <div class="field af-full">
        <label>Tags <span class="hint">Pisahkan dengan koma</span></label>
        <input type="text" name="tags" placeholder="React, Hooks, State Management">
      </div>
      <div class="field af-full">
        <div class="icon-upload-row">
          <div class="icon-upload-box" id="addIconBox">
            <input type="file" name="icon_image" accept="image/*" required onchange="previewAddIcon(this)">
            <div class="iub-placeholder" id="addIconPlaceholder">
              <svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
              <span>Icon</span>
            </div>
          </div>
          <div class="icon-upload-info">
            <label>Gambar Icon <span class="req">*</span></label>
            <p>Upload logo/icon skill dalam format <code>PNG</code>, <code>JPG</code>, atau <code>SVG</code>. Ukuran ideal: <code>80×80px</code> dengan background transparan.</p>
          </div>
        </div>
      </div>
      <div class="af-actions">
        <button type="reset" class="btn-reset">Reset</button>
        <button type="submit" class="btn-add" id="addSkillBtn">
          <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
          Tambah Skill
        </button>
      </div>
    </form>
  </div>
</div>

<!-- ========== SKILL LIST ========== -->
<div class="skills-list-header">
  <h3>Daftar Skills</h3>
  <span class="skills-count">{{ $skills->count() }} skill terdaftar</span>
</div>

<div class="skills-grid">
  @if($skills->count())
    @foreach($skills as $skill)
    <div class="skill-item">
      <div class="skill-item-top">
        <div class="skill-item-icon">
          @if($skill->icon_image)
            <img src="{{ Storage::url($skill->icon_image) }}" alt="{{ $skill->name }}">
          @else
            <div class="no-icon">No<br>Icon</div>
          @endif
        </div>
        <div class="skill-item-info">
          <div class="skill-item-name">
            {{ $skill->name }}
            <span class="sort-badge">#{{ $skill->sort_order }}</span>
          </div>
          <div class="skill-item-desc">{{ $skill->description }}</div>
        </div>
      </div>
      @if($skill->tags)
      <div class="skill-item-tags">
        @foreach(explode(',', $skill->tags) as $tag)
          @if(trim($tag))
            <span class="skill-tag">{{ trim($tag) }}</span>
          @endif
        @endforeach
      </div>
      @endif
      <div class="skill-item-actions">
        <button class="sia-btn sia-edit" onclick='openEditModal(
          {{ $skill->id }},
          `{{ addslashes($skill->name) }}`,
          `{{ addslashes($skill->description ?? '') }}`,
          `{{ addslashes($skill->tags ?? '') }}`,
          {{ $skill->sort_order }},
          `{{ $skill->icon_image ?? '' }}`
        )'>
          <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
          Edit
        </button>
        <form action="{{ route('admin.skills.destroy', $skill) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus skill \"{{ addslashes($skill->name) }}\"?')">
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
    <div class="skills-empty">
      <div class="se-icon">
        <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
      </div>
      <h4>Belum ada skill</h4>
      <p>Tambahkan skill pertamamu untuk mulai membangun portofolio.</p>
    </div>
  @endif
</div>

<!-- ========== EDIT MODAL ========== -->
<div class="modal-overlay" id="editModal">
  <div class="modal-box">
    <div class="modal-head">
      <h3>
        <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
        Edit Skill
      </h3>
      <button class="modal-close" onclick="closeEditModal()">
        <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
      </button>
    </div>
    <form method="POST" id="editForm" enctype="multipart/form-data">
      @csrf @method('PUT')
      <div class="modal-body">
        <div class="field">
          <label>Nama Skill <span class="req">*</span></label>
          <input type="text" name="name" id="editName" required>
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
          <div class="icon-upload-row">
            <div class="icon-upload-box" id="editIconBox">
              <input type="file" name="icon_image" accept="image/*" onchange="previewEditIcon(this)">
              <div class="iub-placeholder" id="editIconPlaceholder">
                <svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                <span>Icon</span>
              </div>
            </div>
            <div class="icon-upload-info">
              <label>Gambar Icon</label>
              <p>Kosongkan jika tidak ingin mengubah. Format: <code>PNG</code>, <code>JPG</code>, <code>SVG</code>.</p>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-foot">
        <button type="button" class="btn-reset" onclick="closeEditModal()">Batal</button>
        <button type="submit" class="btn-add" id="saveEditBtn">
          <svg viewBox="0 0 24 24" style="stroke-width:2.5"><polyline points="20 6 9 17 4 12"/></svg>
          Simpan Perubahan
        </button>
      </div>
    </form>
  </div>
</div>

<script>
  // =============================================
  // TOAST NOTIFICATION SYSTEM
  // =============================================
  function showToast(title, message, type = 'success') {
    const container = document.getElementById('toast-container');
    
    const colorVar = type === 'success' ? 'var(--toast-success)' : 'var(--toast-error)';
    const bgColor = type === 'success' ? '#ecfdf5' : '#fef2f2';
    
    const iconSvg = type === 'success' 
      ? '<svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>'
      : '<svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>';

    const toast = document.createElement('div');
    toast.className = 'toast';
    toast.style.borderLeftColor = colorVar;
    
    toast.innerHTML = `
      <svg class="toast-bg-icon" viewBox="0 0 24 24" style="color:${colorVar}">
        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
      </svg>
      <div class="toast-icon" style="color: ${colorVar}; background: ${bgColor}">
        ${iconSvg}
      </div>
      <div class="toast-content">
        <div class="toast-title">${title}</div>
        <div class="toast-message">${message}</div>
      </div>
      <div class="toast-progress" style="background: ${colorVar}"></div>
    `;

    container.appendChild(toast);

    requestAnimationFrame(() => {
      toast.classList.add('show');
    });

    setTimeout(() => {
      toast.classList.remove('show');
      toast.classList.add('hide');
      setTimeout(() => {
        toast.remove();
      }, 400);
    }, 4000);
  }

  // =============================================
  // CEK & HILANGKAN NOTIFIKASI LAMA (DOUBLE FIX)
  // =============================================
  document.addEventListener('DOMContentLoaded', () => {
    
    // 1. Hapus/sembunyikan notifikasi lama dari Layout (antisipasi dobel)
    const oldAlerts = document.querySelectorAll('.alert, .alert-success, .alert-danger, .alert-info');
    oldAlerts.forEach(alert => {
      alert.style.display = 'none';
    });

    // 2. Cek session dari Controller dan tampilkan Toast Baru
    @if(session('success'))
      showToast('Berhasil!', '{{ session('success') }}', 'success');
    @endif
    
    @if(session('error'))
      showToast('Gagal!', '{{ session('error') }}', 'error');
    @endif
  });

// === TOGGLE ADD FORM ===
function toggleAddForm() {
  const body = document.getElementById('addBody');
  const toggle = document.getElementById('addToggle');
  body.classList.toggle('open');
  toggle.classList.toggle('open');
}

// === PREVIEW ICONS ===
function previewAddIcon(input) {
  const box = document.getElementById('addIconBox');
  const ph = document.getElementById('addIconPlaceholder');
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = function(e) {
      ph.style.display = 'none';
      const img = document.createElement('img');
      img.src = e.target.result;
      box.appendChild(img);
    };
    reader.readAsDataURL(input.files[0]);
  }
}

function previewEditIcon(input) {
  const box = document.getElementById('editIconBox');
  const ph = document.getElementById('editIconPlaceholder');
  // Remove old preview img
  const oldImg = box.querySelector('img');
  if (oldImg) oldImg.remove();

  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = function(e) {
      ph.style.display = 'none';
      const img = document.createElement('img');
      img.src = e.target.result;
      box.appendChild(img);
    };
    reader.readAsDataURL(input.files[0]);
  } else {
    ph.style.display = '';
  }
}

// === EDIT MODAL ===
function openEditModal(id, name, desc, tags, sort, icon) {
  document.getElementById('editForm').action = '/admin/skills/' + id;
  document.getElementById('editName').value = name;
  document.getElementById('editDesc').value = desc;
  document.getElementById('editTags').value = tags;
  document.getElementById('editSort').value = sort;

  // Reset icon preview
  const box = document.getElementById('editIconBox');
  const ph = document.getElementById('editIconPlaceholder');
  const oldImg = box.querySelector('img');
  if (oldImg) oldImg.remove();

  if (icon) {
    ph.style.display = 'none';
    const img = document.createElement('img');
    img.src = '/storage/' + icon;
    box.appendChild(img);
  } else {
    ph.style.display = '';
  }

  document.getElementById('editModal').classList.add('open');
  document.body.style.overflow = 'hidden';
}

function closeEditModal() {
  document.getElementById('editModal').classList.remove('open');
  document.body.style.overflow = '';
}

// Close on overlay click
document.getElementById('editModal').addEventListener('click', function(e) {
  if (e.target === this) closeEditModal();
});

// Close on Escape
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') closeEditModal();
});

// =============================================
// ANIMASI TOMBOL FORM (ADD & EDIT)
// =============================================
document.getElementById('addSkillForm').addEventListener('submit', function() {
  const btn = document.getElementById('addSkillBtn');
  const origHTML = btn.innerHTML;
  
  btn.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Menyimpan...';
  btn.style.pointerEvents = 'none';
  btn.style.opacity = '.7';
});

document.getElementById('editForm').addEventListener('submit', function() {
  const btn = document.getElementById('saveEditBtn');
  const origHTML = btn.innerHTML;
  
  btn.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Menyimpan...';
  btn.style.pointerEvents = 'none';
  btn.style.opacity = '.7';
});
</script>

@endsection