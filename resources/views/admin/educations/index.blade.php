@extends('admin.layout')

@section('title', 'Education')
@section('pageTitle', 'Manage Education')

@section('content')

<!-- ALERT CONTAINER -->
<div id="alert-container"></div>

<style>
  /* === REUSED STYLES (From Projects/Experiences) === */
  
  .add-card {
    background: var(--bg-card); border-radius: 16px; border: 1px solid var(--border);
    overflow: hidden; margin-bottom: 1.5rem;
  }

  .add-card-head {
    padding: 1.25rem 1.75rem; border-bottom: 1px solid var(--border);
    display: flex; align-items: center; justify-content: space-between;
    background: var(--bg); cursor: pointer; transition: background .15s;
  }
  .add-card-head:hover { background: #f1f5f9; }
  .add-card-head .ach-left { display: flex; align-items: center; gap: .75rem; }
  .add-card-head .ach-icon {
    width: 38px; height: 38px; border-radius: 10px;
    background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
    display: flex; align-items: center; justify-content: center;
  }
  .add-card-head .ach-icon svg { width: 18px; height: 18px; stroke: #fff; fill: none; stroke-width: 2; }
  .add-card-head h3 { font-size: .95rem; font-weight: 600; }
  .add-card-head .ach-sub { font-size: .78rem; color: var(--text-light); margin-top: .1rem; }
  .add-card-head .ach-toggle { width: 32px; height: 32px; border-radius: 8px; border: 1px solid var(--border); background: #fff; display: flex; align-items: center; justify-content: center; transition: all .2s; }
  .add-card-head .ach-toggle.open { background: #6366f1; border-color: #6366f1; transform: rotate(45deg); }
  .add-card-head .ach-toggle svg { width: 16px; height: 16px; stroke: var(--text); fill: none; stroke-width: 2; }
  .add-card-head .ach-toggle.open svg { stroke: #fff; }

  .add-card-body { max-height: 0; overflow: hidden; transition: max-height .4s ease; }
  .add-card-body.open { max-height: 800px; }
  .add-card-form { padding: 1.75rem; display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; }
  .add-card-form .af-full { grid-column: 1 / -1; }
  .field label { display: block; font-size: .85rem; font-weight: 600; color: var(--text); margin-bottom: .4rem; }
  .field input { width: 100%; padding: .7rem 1rem; border: 1.5px solid var(--border); border-radius: 10px; font-size: .9rem; font-family: 'Inter', sans-serif; transition: all .2s; background: #fff; color: var(--text); }
  .field input:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(99,102,241,.1); }
  .af-actions { grid-column: 1 / -1; display: flex; justify-content: flex-end; gap: .6rem; padding-top: .5rem; border-top: 1px solid var(--border); }

  /* === EDUCATION CARD LIST === */
  .edu-list { display: flex; flex-direction: column; gap: 1.25rem; }
  .edu-card { background: var(--bg-card); border-radius: 16px; border: 1px solid var(--border); overflow: hidden; transition: all .25s; }
  .edu-card:hover { border-color: #a7f3d0; box-shadow: 0 8px 25px rgba(16,185,129,.08); transform: translateY(-3px); }
  .edu-card-body { padding: 1.5rem; }
  .edu-school { font-size: 1.05rem; font-weight: 700; color: var(--text); margin-bottom: .2rem; }
  .edu-meta { display: flex; align-items: center; gap: 1rem; font-size: .8rem; color: var(--text-light); margin-bottom: .5rem; }
  .edu-badge { background: rgba(99,102,241,.1); color: var(--primary-dark); padding: .3rem .6rem; border-radius: 50px; font-weight: 600; }
  .edu-actions { border-top: 1px solid var(--border); padding-top: .75rem; display: flex; justify-content: flex-end; gap: .5rem; background: var(--bg); }

  .sia-btn { padding: .4rem .75rem; border-radius: 8px; font-weight: 600; font-size: .78rem; border: 1px solid var(--border); background: #fff; color: var(--text); cursor: pointer; transition: all .15s; font-family: 'Inter', sans-serif; display: inline-flex; align-items: center; gap: .3rem; }
  .sia-btn svg { width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 2; }
  .sia-btn:hover { background: var(--bg); }
  .sia-btn.sia-edit:hover { border-color: #a7f3d0; color: #059669; background: #f0fdf4; }
  .sia-btn.sia-delete:hover { border-color: #fca5a5; color: #ef4444; background: #fef2f2; }
  .btn-add-green { padding: .6rem 1.5rem; border-radius: 10px; font-weight: 600; font-size: .85rem; border: none; background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); color: #fff; cursor: pointer; display: inline-flex; align-items: center; gap: .4rem; box-shadow: 0 3px 10px rgba(99,102,241,.25); position: relative; }
  .btn-add-green:hover { transform: translateY(-1px); box-shadow: 0 5px 15px rgba(99,102,241,.35); }
  .btn-reset { padding: .6rem 1.1rem; border-radius: 10px; font-weight: 600; font-size: .85rem; border: 1.5px solid var(--border); background: #fff; color: var(--text); cursor: pointer; transition: all .15s; font-family: 'Inter', sans-serif; }
  .btn-reset:hover { background: var(--bg); }

  /* === ALERTS === */
  #alert-container { margin-bottom: 1.5rem; position: relative; z-index: 50; }
  .custom-alert { display: flex; align-items: flex-start; padding: 1.25rem 1.5rem; border-radius: 14px; font-size: 0.95rem; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05); animation: slideDown 0.4s cubic-bezier(0.16, 1, 0.3, 1); position: relative; overflow: hidden; border: 1px solid transparent; }
  .custom-alert.success { background-color: #f0fdf9; border-color: #ccfbf1; color: #047857; }
  .custom-alert.error { background-color: #fef2f2; border-color: #fecaca; color: #b91c1c; }
  .ca-icon { flex-shrink: 0; width: 28px; height: 28px; background: #10b981; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 16px; box-shadow: 0 2px 4px rgba(16, 185, 129, 0.2); }
  .custom-alert.error .ca-icon { background: #ef4444; box-shadow: 0 2px 4px rgba(239, 68, 68, 0.2); }
  .ca-icon svg { width: 16px; height: 16px; stroke-width: 2.5; stroke-linecap: round; stroke-linejoin: round; }
  .ca-title { font-weight: 700; font-size: 1rem; margin-bottom: 2px; display: block; }
  .ca-msg { font-weight: 400; line-height: 1.5; opacity: 0.9; font-size: 0.9rem; }
  .ca-close { background: transparent; border: none; cursor: pointer; opacity: 0.4; padding: 4px; margin-left: 12px; transition: all 0.2s; border-radius: 6px; display: flex; align-items: center; justify-content: center; }
  .ca-close:hover { opacity: 1; background-color: rgba(0,0,0,0.05); }
  .btn-loading { color: transparent !important; pointer-events: none; position: relative; }
  .btn-loading::after { content: ""; position: absolute; left: 50%; top: 50%; width: 18px; height: 18px; border: 2px solid rgba(255,255,255,0.3); border-radius: 50%; border-top-color: #fff; animation: spin 0.8s linear infinite; transform: translate(-50%, -50%); }
  @keyframes spin { to { transform: translate(-50%, -50%) rotate(360deg); } }
  @keyframes slideDown { from { opacity: 0; transform: translateY(-15px); } to { opacity: 1; transform: translateY(0); } }

  /* === EMPTY STATE === */
  .projects-empty { text-align: center; padding: 4rem 2rem; color: var(--text-light); border-radius: 16px; border: 2px dashed var(--border); background: #f8fafc; }
  .projects-empty .pe-icon { width: 72px; height: 72px; border-radius: 18px; background: #fff; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; }
  .projects-empty .pe-icon svg { width: 32px; height: 32px; stroke: var(--border); fill: none; stroke-width: 1.5; stroke-linecap: round; stroke-linejoin: round; }
  .projects-empty h4 { font-size: 1rem; font-weight: 600; color: var(--text); margin-bottom: .4rem; }
  .projects-empty p { font-size: .85rem; max-width: 320px; margin: 0 auto; line-height: 1.5; }
</style>

<!-- ========== ADD NEW EDUCATION ========== -->
<div class="add-card">
  <div class="add-card-head" onclick="toggleAddForm()">
    <div class="ach-left">
      <div class="ach-icon">
        <svg viewBox="0 0 24 24"><path d="M22 10v6M2 10l10-5 10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
      </div>
      <div>
        <h3>Tambah Pendidikan</h3>
        <div class="ach-sub">Klik untuk membuka form</div>
      </div>
    </div>
    <div class="ach-toggle" id="addToggle">
      <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
    </div>
  </div>
  <div class="add-card-body" id="addBody">
    <form method="POST" action="{{ route('admin.educations.store') }}" class="add-card-form" id="createEduForm">
      @csrf
      <div class="field">
        <label>Nama Sekolah/Kampus <span class="text-danger">*</span></label>
        <input type="text" name="school" required placeholder="Contoh: Universitas Indonesia">
      </div>
      <div class="field">
        <label>Gelar / Jurusan <span class="text-danger">*</span></label>
        <input type="text" name="degree" required placeholder="Contoh: S1 Teknik Informatika">
      </div>
      <div class="field">
        <label>Periode <span class="text-danger">*</span></label>
        <input type="text" name="period" required placeholder="2020 - 2024">
      </div>
      <div class="field">
        <label>IPK / Nilai Akhir</label>
        <input type="text" name="gpa" placeholder="3.85 / 4.00">
      </div>
      <div class="af-actions">
        <button type="reset" class="btn-reset">Reset</button>
        <button type="submit" class="btn-add-green" id="btnAddEdu">
          <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
          Simpan Pendidikan
        </button>
      </div>
    </form>
  </div>
</div>

<!-- ========== EDUCATION LIST ========== -->
<div class="edu-list">
  @if($educations->count())
    @foreach($educations as $edu)
    <div class="edu-card">
      <div class="edu-card-body">
        <div class="edu-school">{{ $edu->school }}</div>
        <div class="edu-school" style="font-size: .95rem; font-weight: 500; font-style: italic; color: var(--primary);">
          {{ $edu->degree }}
        </div>
        <div class="edu-meta">
          <span class="edu-badge">{{ $edu->period }}</span>
          <span style="display:flex; align-items:center; gap:4px;">
             <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M16 8h-6a2 2 0 1 0 0 4h4"/></svg>
             GPA: {{ $edu->gpa }}
          </span>
        </div>
      </div>
      
      <div class="edu-actions">
        <a href="{{ route('admin.educations.edit', $edu->id) }}" class="sia-btn sia-edit">
          <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
          Edit
        </a>
        <form action="{{ route('admin.educations.destroy', $edu->id) }}" method="POST" style="display:inline;">
          @csrf @method('DELETE')
          <button type="submit" class="sia-btn sia-delete" onclick="return confirm('Hapus pendidikan ini?')">
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
        <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
      </div>
      <h4>Belum ada data pendidikan</h4>
      <p>Tambahkan riwayat pendidikan formal Anda.</p>
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

  if (sessionSuccess && sessionSuccess.length > 0 && sessionSuccess !== '""') { showInlineAlert('Berhasil!', sessionSuccess, 'success'); }
  if (sessionError && sessionError.length > 0 && sessionError !== '""') { showInlineAlert('Gagal!', sessionError, 'error'); }
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

  alert.innerHTML = `<div class="ca-icon">${iconSvg}</div><div class="ca-content"><span class="ca-title">${title}</span><span class="ca-msg">${message}</span></div><button class="ca-close" onclick="this.parentElement.remove()"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>`;

  container.appendChild(alert);
  setTimeout(() => { if(alert.parentElement) { alert.style.opacity = '0'; alert.style.transform = 'translateY(-10px)'; setTimeout(() => { if(alert.parentElement) alert.remove(); }, 400); } }, 4000);
}

// 3. TOGGLE & LOADING
function toggleAddForm() {
  document.getElementById('addBody').classList.toggle('open');
  document.getElementById('addToggle').classList.toggle('open');
}

const createForm = document.getElementById('createEduForm');
const btnAdd = document.getElementById('btnAddEdu');
if(createForm) createForm.addEventListener('submit', function() { if(btnAdd) btnAdd.classList.add('btn-loading'); });
</script>

@endsection