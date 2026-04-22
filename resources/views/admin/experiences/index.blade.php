@extends('admin.layout')

@section('title', 'Work Experiences')
@section('pageTitle', 'Manage Experiences')

@section('content')

<!-- ALERT CONTAINER -->
<div id="alert-container"></div>

<style>
  /* ============================================
    REUSED STYLES (From Projects View)
    ============================================ */
  
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
    background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); /* Primary Gradient */
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }

  .add-card-head .ach-icon svg {
    width: 18px; height: 18px;
    stroke: #fff; fill: none; stroke-width: 2;
    stroke-linecap: round; stroke-linejoin: round;
  }

  .add-card-head h3 { font-size: .95rem; font-weight: 600; }
  .add-card-head .ach-sub { font-size: .78rem; color: var(--text-light); margin-top: .1rem; }

  .add-card-head .ach-toggle {
    width: 32px; height: 32px; border-radius: 8px;
    border: 1px solid var(--border); background: #fff;
    display: flex; align-items: center; justify-content: center;
    transition: all .2s;
  }
  .add-card-head .ach-toggle.open {
    background: #6366f1; border-color: #6366f1; transform: rotate(45deg);
  }
  .add-card-head .ach-toggle svg {
    width: 16px; height: 16px; stroke: var(--text); fill: none;
    stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;
  }
  .add-card-head .ach-toggle.open svg { stroke: #fff; }

  .add-card-body {
    max-height: 0; overflow: hidden; transition: max-height .4s ease;
  }
  .add-card-body.open { max-height: 800px; }

  .add-card-form {
    padding: 1.75rem; display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;
  }
  .add-card-form .af-full { grid-column: 1 / -1; }

  .field label {
    display: block; font-size: .85rem; font-weight: 600;
    color: var(--text); margin-bottom: .4rem;
  }
  .field input, .field textarea {
    width: 100%; padding: .7rem 1rem;
    border: 1.5px solid var(--border); border-radius: 10px;
    font-size: .9rem; font-family: 'Inter', sans-serif;
    transition: all .2s; background: #fff; color: var(--text);
  }
  .field input:focus, .field textarea:focus {
    outline: none; border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(99,102,241,.1);
  }
  .field textarea { min-height: 90px; resize: vertical; line-height: 1.6; }

  /* === EXPERIENCE CARD (LIST ITEM) === */
  .exp-list { display: flex; flex-direction: column; gap: 1.25rem; }

  .exp-card {
    background: var(--bg-card); border-radius: 16px;
    border: 1px solid var(--border); overflow: hidden;
    transition: all .25s; position: relative;
  }
  .exp-card:hover {
    border-color: #a7f3d0;
    box-shadow: 0 8px 25px rgba(16,185,129,.08); /* Greenish hover hint */
  }

  .exp-card-body { padding: 1.5rem; }

  .exp-header {
    display: flex; justify-content: space-between; align-items: flex-start;
    margin-bottom: .5rem;
  }

  .exp-company {
    font-size: 1.05rem; font-weight: 700; color: var(--text);
    display: flex; align-items: center; gap: .5rem;
  }

  .exp-location {
    font-size: .8rem; font-weight: 500; color: var(--text-light);
    background: #f1f5f9; padding: .2rem .5rem; border-radius: 6px;
  }

  .exp-period {
    font-size: .78rem; font-weight: 600;
    background: rgba(99,102,241,.1); color: var(--primary-dark);
    padding: .4rem .8rem; border-radius: 50px; border: 1px solid rgba(99,102,241,.2);
    flex-shrink: 0;
  }

  .exp-role {
    font-size: .95rem; font-weight: 600; color: var(--primary);
    margin-bottom: .75rem; font-style: italic;
  }

  .exp-details {
    font-size: .85rem; color: var(--text-light); line-height: 1.6;
    text-align: justify; display: -webkit-box; -webkit-line-clamp: 3;
    -webkit-box-orient: vertical; overflow: hidden; margin-bottom: 1rem;
  }

  .exp-actions {
    border-top: 1px solid var(--border); padding-top: .75rem;
    display: flex; justify-content: flex-end; gap: .5rem; background: var(--bg);
  }

  .sia-btn {
    padding: .4rem .75rem; border-radius: 8px; font-weight: 600; font-size: .78rem;
    border: 1px solid var(--border); background: #fff; color: var(--text);
    cursor: pointer; transition: all .15s; font-family: 'Inter', sans-serif;
    display: inline-flex; align-items: center; gap: .3rem;
  }
  .sia-btn svg { width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
  .sia-btn:hover { background: var(--bg); }

  .sia-btn.sia-edit:hover { border-color: #a7f3d0; color: #059669; background: #f0fdf4; }
  .sia-btn.sia-delete:hover { border-color: #fca5a5; color: #ef4444; background: #fef2f2; }

  /* === EMPTY STATE === */
  .projects-empty {
    text-align: center; padding: 4rem 2rem; color: var(--text-light);
    border-radius: 16px; border: 2px dashed var(--border); background: #f8fafc;
  }
  .projects-empty .pe-icon {
    width: 72px; height: 72px; border-radius: 18px; background: #fff;
    display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
  }
  .projects-empty .pe-icon svg {
    width: 32px; height: 32px; stroke: var(--border); fill: none;
    stroke-width: 1.5; stroke-linecap: round; stroke-linejoin: round;
  }
  .projects-empty h4 { font-size: 1rem; font-weight: 600; color: var(--text); margin-bottom: .4rem; }
  .projects-empty p { font-size: .85rem; max-width: 320px; margin: 0 auto; line-height: 1.5; }

  /* === ALERTS & LOADING === */
  #alert-container { margin-bottom: 1.5rem; position: relative; z-index: 50; }
  .custom-alert {
    display: flex; align-items: flex-start; padding: 1.25rem 1.5rem;
    border-radius: 14px; font-size: 0.95rem;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    animation: slideDown 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    position: relative; overflow: hidden; border: 1px solid transparent;
  }
  .custom-alert.success { background-color: #f0fdf9; border-color: #ccfbf1; color: #047857; }
  .custom-alert.error { background-color: #fef2f2; border-color: #fecaca; color: #b91c1c; }
  .ca-icon { flex-shrink: 0; width: 28px; height: 28px; background: #10b981; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 16px; box-shadow: 0 2px 4px rgba(16, 185, 129, 0.2); }
  .custom-alert.error .ca-icon { background: #ef4444; box-shadow: 0 2px 4px rgba(239, 68, 68, 0.2); }
  .ca-icon svg { width: 16px; height: 16px; stroke-width: 2.5; stroke-linecap: round; stroke-linejoin: round; }
  .ca-content { flex: 1; padding-top: 2px; }
  .ca-title { font-weight: 700; font-size: 1rem; margin-bottom: 2px; display: block; }
  .ca-msg { font-weight: 400; line-height: 1.5; opacity: 0.9; font-size: 0.9rem; }
  .ca-close { background: transparent; border: none; cursor: pointer; opacity: 0.4; padding: 4px; margin-left: 12px; transition: all 0.2s; border-radius: 6px; display: flex; align-items: center; justify-content: center; }
  .ca-close:hover { opacity: 1; background-color: rgba(0,0,0,0.05); }
  .btn-loading { color: transparent !important; pointer-events: none; position: relative; }
  .btn-loading::after { content: ""; position: absolute; left: 50%; top: 50%; width: 18px; height: 18px; border: 2px solid rgba(255,255,255,0.3); border-radius: 50%; border-top-color: #fff; animation: spin 0.8s linear infinite; transform: translate(-50%, -50%); }
  @keyframes spin { to { transform: translate(-50%, -50%) rotate(360deg); } }
  @keyframes slideDown { from { opacity: 0; transform: translateY(-15px); } to { opacity: 1; transform: translateY(0); } }
</style>

<!-- ========== ADD NEW EXPERIENCE ========== -->
<div class="add-card">
  <div class="add-card-head" onclick="toggleAddForm()">
    <div class="ach-left">
      <div class="ach-icon">
        <svg viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
      </div>
      <div>
        <h3>Tambah Pengalaman Kerja</h3>
        <div class="ach-sub">Klik untuk membuka form</div>
      </div>
    </div>
    <div class="ach-toggle" id="addToggle">
      <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
    </div>
  </div>
  <div class="add-card-body" id="addBody">
    <form method="POST" action="{{ route('admin.experiences.store') }}" class="add-card-form" id="createExpForm">
      @csrf
      <div class="field">
        <label>Nama Perusahaan <span class="text-danger">*</span></label>
        <input type="text" name="company" required placeholder="Contoh: PT. Teknologi Indonesia">
      </div>
      <div class="field">
        <label>Lokasi</label>
        <input type="text" name="location" placeholder="Kota, Negara">
      </div>
      <div class="field">
        <label>Periode <span class="text-danger">*</span></label>
        <input type="text" name="period" required placeholder="Jan 2023 - Sekarang">
      </div>
      <div class="field">
        <label>Posisi / Role <span class="text-danger">*</span></label>
        <input type="text" name="role" required placeholder="Frontend Developer">
      </div>
      <div class="field af-full">
        <label>Deskripsi Pekerjaan</label>
        <textarea name="details" rows="4" placeholder="Deskripsikan tanggung jawab dan pencapaian Anda..."></textarea>
      </div>
      <div class="af-actions">
        <button type="reset" class="sia-btn">Reset</button>
        <button type="submit" class="sia-btn" style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); border: none; color: #fff; box-shadow: 0 3px 10px rgba(99,102,241,.25);" id="btnAddExp">
          <svg viewBox="0 0 24 24" style="stroke:#fff; stroke-width:2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
          Simpan Pengalaman
        </button>
      </div>
    </form>
  </div>
</div>

<!-- ========== EXPERIENCE LIST ========== -->
<div class="exp-list">
  @if($experiences->count())
    @foreach($experiences as $exp)
    <div class="exp-card">
      <div class="exp-card-body">
        <div class="exp-header">
          <div>
            <div class="exp-company">{{ $exp->company }}</div>
            <div class="exp-location">{{ $exp->location ?? 'Remote' }}</div>
          </div>
          <div class="exp-period">{{ $exp->period }}</div>
        </div>
        
        <div class="exp-role">{{ $exp->role }}</div>
        
        <div class="exp-details" title="{{ $exp->details }}">
          {{ $exp->details }}
        </div>
      </div>
      
      <div class="exp-actions">
        <a href="{{ route('admin.experiences.edit', $exp->id) }}" class="sia-btn sia-edit">
          <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
          Edit
        </a>
        <form action="{{ route('admin.experiences.destroy', $exp->id) }}" method="POST" style="display:inline;">
          @csrf @method('DELETE')
          <button type="submit" class="sia-btn sia-delete" onclick="return confirm('Hapus pengalaman ini?')">
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
      <h4>Belum ada pengalaman kerja</h4>
      <p>Tambahkan pengalaman kerja pertamamu untuk memperlihatkan karir profesional Anda.</p>
    </div>
  @endif
</div>

<script>
// 1. CLEANUP & ALERTS
document.addEventListener('DOMContentLoaded', () => {
  const oldAlerts = document.querySelectorAll('.alert, .flash-message, [role="alert"], .custom-alert');
  oldAlerts.forEach(el => el.remove());

  const container = document.getElementById('alert-container');
  if(container) container.innerHTML = '';

  const sessionSuccess = "{{ session('success') ?? '' }}";
  const sessionError = "{{ session('error') ?? '' }}";

  if (sessionSuccess && sessionSuccess.length > 0 && sessionSuccess !== '""') {
    showInlineAlert('Berhasil!', sessionSuccess, 'success');
  }
  
  if (sessionError && sessionError.length > 0 && sessionError !== '""') {
    showInlineAlert('Gagal!', sessionError, 'error');
  }
});

// 2. ALERT LOGIC
function showInlineAlert(title, message, type = 'success') {
  const container = document.getElementById('alert-container');
  if(!container) return;

  container.innerHTML = '';

  const alert = document.createElement('div');
  alert.className = `custom-alert ${type}`;
  
  const successIcon = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><polyline points="20 6 9 17 4 12"/></svg>`;
  const errorIcon = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>`;
  
  const iconSvg = type === 'success' ? successIcon : errorIcon;

  alert.innerHTML = `
    <div class="ca-icon">${iconSvg}</div>
    <div class="ca-content">
      <span class="ca-title">${title}</span>
      <span class="ca-msg">${message}</span>
    </div>
    <button class="ca-close" onclick="this.parentElement.remove()">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
    </button>
  `;

  container.appendChild(alert);

  setTimeout(() => {
    if(alert.parentElement) {
      alert.style.opacity = '0';
      alert.style.transform = 'translateY(-10px)';
      alert.style.transition = 'all 0.4s ease';
      setTimeout(() => { if(alert.parentElement) alert.remove(); }, 400);
    }
  }, 4000);
}

// 3. FORM TOGGLE & LOADING
function toggleAddForm() {
  const body = document.getElementById('addBody');
  const toggle = document.getElementById('addToggle');
  body.classList.toggle('open');
  toggle.classList.toggle('open');
}

const createForm = document.getElementById('createExpForm');
const btnAdd = document.getElementById('btnAddExp');

if (createForm) {
  createForm.addEventListener('submit', function() {
    if(btnAdd) btnAdd.classList.add('btn-loading');
  });
}
</script>

@endsection