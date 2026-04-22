@extends('admin.layout')

@section('title', 'CV Builder')
@section('pageTitle', 'Manage CV Builder')

@section('content')

<!-- ALERT CONTAINER -->
<div id="alert-container"></div>

<style>
  /* ============================================
    STYLES (Adapted from Projects View for Consistency)
    ============================================ */
  
  /* === FORM CARD HEADER === */
  .card-header-custom {
    padding: 1.25rem 1.75rem;
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: var(--bg);
    border-top-left-radius: 16px;
    border-top-right-radius: 16px;
  }
  
  .card-header-custom .ch-left {
    display: flex;
    align-items: center;
    gap: .75rem;
  }

  .card-header-custom .ch-icon {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); /* Primary Color */
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 10px rgba(99, 102, 241, 0.2);
  }

  .card-header-custom .ch-icon svg {
    width: 18px;
    height: 18px;
    stroke: #fff;
    fill: none;
    stroke-width: 2;
    stroke-linecap: round;
    stroke-linejoin: round;
  }

  .card-header-custom h3 { font-size: .95rem; font-weight: 600; }
  .card-header-custom .ch-sub { font-size: .78rem; color: var(--text-light); margin-top: .1rem; }

  /* === FORM GRID === */
  .cv-form-grid {
    padding: 1.75rem;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.25rem;
  }

  .cv-form-grid .field-full { grid-column: 1 / -1; }

  .field label {
    display: block;
    font-size: .85rem;
    font-weight: 600;
    color: var(--text);
    margin-bottom: .4rem;
  }

  .field input, .field textarea {
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

  .field input:focus, .field textarea:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(99,102,241,.1);
  }

  .field textarea {
    min-height: 90px;
    resize: vertical;
    line-height: 1.6;
  }

  /* === BUTTONS ELEGANT & COMPACT === */
  .cv-actions {
    display: flex;
    gap: 0.8rem; /* Jarak antar tombol diperkecil */
    justify-content: flex-end;
    margin-top: 0.5rem;
    padding-top: 1rem; /* Jarak garis pemisah */
    border-top: 1px solid var(--border);
  }

  .btn-elegant {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.5rem 1.2rem; /* PADDING DIKECILKAN */
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.8rem; /* FONT DIKECILKAN */
    border: 1.5px solid var(--border);
    background: #fff;
    color: var(--text);
    cursor: pointer;
    transition: all .15s;
    font-family: 'Inter', sans-serif;
    text-decoration: none;
    gap: 0.4rem;
  }

  /* Reset Button Variant */
  .btn-reset-elegant {
    background: #fff;
    border-color: var(--border);
    color: var(--text);
  }

  .btn-reset-elegant:hover {
    background: #f8fafc;
    border-color: #cbd5e1;
    color: #475569;
  }

  /* Submit Button Variant */
  .btn-submit-elegant {
    background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
    color: white;
    border: none;
    box-shadow: 0 4px 15px rgba(99,102,241,0.25);
  }

  .btn-submit-elegant:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(99,102,241,0.35);
  }

  /* Ikon SVG Agar Proporsional dengan Tombol Kecil */
  .btn-elegant svg {
    width: 14px; /* DIKECILKAN */
    height: 14px;
    stroke: currentColor;
    fill: none;
    stroke-width: 2;
    stroke-linecap: round;
    stroke-linejoin: round;
  }

  /* Loading State */
  .btn-elegant .loading-spinner {
    width: 14px;
    height: 14px;
    border: 2px solid rgba(255,255,255,0.3);
    border-radius: 50%;
    border-top-color: #fff;
    animation: spin 0.8s linear infinite;
  }
  .btn-elegant .loading-text {
    opacity: 0;
  }

  /* === QUICK LINKS CARD === */
  .quick-link-card {
    background: var(--bg-card);
    border-radius: 16px;
    border: 1px solid var(--border);
    padding: 1.25rem;
    transition: all .2s;
    cursor: pointer;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 1rem;
    color: var(--text);
    margin-bottom: 1rem;
  }

  .quick-link-card:hover {
    border-color: var(--primary);
    background: #fff;
    box-shadow: 0 4px 15px rgba(0,0,0,.05);
    transform: translateY(-2px);
  }

  .quick-link-card .ql-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: #e0e7ff;
    color: var(--primary-dark);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }
  
  .quick-link-card .ql-icon svg {
    width: 20px;
    height: 20px;
    stroke: currentColor;
    fill: none;
    stroke-width: 2;
    stroke-linecap: round;
    stroke-linejoin: round;
  }

  .quick-link-card .ql-text h4 {
    font-size: .9rem;
    font-weight: 700;
    margin-bottom: .15rem;
  }

  .quick-link-card .ql-text p {
    font-size: .75rem;
    color: var(--text-light);
    margin: 0;
  }

  /* === ALERTS (Reused from Projects) === */
  #alert-container { margin-bottom: 1.5rem; position: relative; z-index: 50; }

  .custom-alert {
    display: flex;
    align-items: flex-start;
    padding: 1.25rem 1.5rem;
    border-radius: 14px;
    font-size: 0.95rem;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    animation: slideDown 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    position: relative;
    overflow: hidden;
    border: 1px solid transparent;
  }

  .custom-alert.success {
    background-color: #f0fdf9;
    border-color: #ccfbf1;
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
    height: 28px;
    background: #10b981;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 16px;
    box-shadow: 0 2px 4px rgba(16, 185, 129, 0.2);
  }
  .custom-alert.error .ca-icon { background: #ef4444; box-shadow: 0 2px 4px rgba(239, 68, 68, 0.2); }

  .ca-icon svg { width: 16px; height: 16px; stroke-width: 2.5; stroke-linecap: round; stroke-linejoin: round; }
  .ca-content { flex: 1; padding-top: 2px; }
  .ca-title { font-weight: 700; font-size: 1rem; margin-bottom: 2px; display: block; }
  .ca-msg { font-weight: 400; line-height: 1.5; opacity: 0.9; font-size: 0.9rem; }
  .ca-close { background: transparent; border: none; cursor: pointer; opacity: 0.4; padding: 4px; margin-left: 12px; transition: all 0.2s; border-radius: 6px; display: flex; align-items: center; justify-content: center; }
  .ca-close:hover { opacity: 1; background-color: rgba(0,0,0,0.05); }

  /* Download Card Style */
  .btn-download {
    width: 100%;
    justify-content: center;
    padding: .9rem 1.5rem;
    background: linear-gradient(135deg, #1e293b 0%, #adbfe9 100%);
    box-shadow: 0 3px 10px rgba(131, 156, 216, 0.25);
  }
  
  .btn-download:hover { background: linear-gradient(135deg, #496d9f 0%, #49699c 100%); }

  @keyframes slideDown { from { opacity: 0; transform: translateY(-15px); } to { opacity: 1; transform: translateY(0); } }
  @keyframes spin { to { transform: rotate(360deg); } }

  /* RESPONSIVE */
  @media (max-width: 768px) {
    .cv-form-grid { grid-template-columns: 1fr; }
    .cv-actions { flex-direction: column-reverse; gap: .5rem; width: 100%; }
    .btn-elegant { width: 100%; justify-content: center; }
  }
</style>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem;">
  
  <!-- KOLOM KIRI: FORM PROFIL -->
  <div>
    
    <!-- PROFILE CARD -->
    <div style="background: var(--bg-card); border-radius: 16px; border: 1px solid var(--border); overflow: hidden; margin-bottom: 1.5rem;">
      <div class="card-header-custom">
        <div class="ch-left">
          <div class="ch-icon">
            <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
          </div>
          <div>
            <h3>Personal Information</h3>
            <div class="ch-sub">Data utama yang tampil di PDF</div>
          </div>
        </div>
      </div>

      <form method="POST" action="{{ route('admin.cv-builder.profile') }}" class="cv-form-grid">
        @csrf @method('PUT')

        <!-- Nama & Title -->
        <div class="field">
          <label>Full Name <span style="color:#ef4444">*</span></label>
          <input type="text" name="name" value="{{ old('name', $profile->name ?? '') }}" required placeholder="Nama Lengkap">
        </div>
        <div class="field">
          <label>Job Title <span style="color:#ef4444">*</span></label>
          <input type="text" name="title" value="{{ old('title', $profile->title ?? '') }}" required placeholder="Contoh: Full Stack Developer">
        </div>

        <!-- Kontak -->
        <div class="field">
          <label>Phone Number</label>
          <input type="text" name="phone" value="{{ old('phone', $profile->phone ?? '') }}" placeholder="08123456789">
        </div>
        <div class="field">
          <label>Email Address</label>
          <input type="email" name="email" value="{{ old('email', $profile->email ?? '') }}" placeholder="email@example.com">
        </div>

        <div class="field">
          <label>LinkedIn URL</label>
          <input type="text" name="linkedin" value="{{ old('linkedin', $profile->linkedin ?? '') }}" placeholder="https://linkedin.com/in/...">
        </div>
        <div class="field">
          <label>Website URL</label>
          <input type="text" name="website" value="{{ old('website', $profile->website ?? '') }}" placeholder="https://website.com">
        </div>

        <div class="field field-full">
          <label>Address</label>
          <input type="text" name="address" value="{{ old('address', $profile->address ?? '') }}" placeholder="Kota, Provinsi, Negara">
        </div>

        <!-- Summary -->
        <div class="field field-full">
          <label>Professional Summary</label>
          <textarea name="summary" rows="3" placeholder="Deskripsi singkat profesional Anda...">{{ old('summary', $profile->summary ?? '') }}</textarea>
        </div>

        <!-- Skills -->
        <div class="field">
          <label>Soft Skills</label>
          <input type="text" name="soft_skills" value="{{ old('soft_skills', $profile->soft_skills ?? '') }}" placeholder="Communication, Teamwork">
        </div>
        <div class="field">
          <label>Hard Skills</label>
          <input type="text" name="hard_skills" value="{{ old('hard_skills', $profile->hard_skills ?? '') }}" placeholder="PHP, Laravel, React">
        </div>

        <!-- COMPACT ACTIONS -->
        <div class="cv-actions">
          <button type="reset" class="btn-elegant btn-reset-elegant">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 1 0 9 9 9.75 0 0 0 6.74L21 12.75 0 0 0-6.74L12 12.25a9 9 0 0 0 0-6.74L3 12.25A9 9 0 0 0 0 6.74zM9 9a7 7 0 0 1 7 0 7 7 7 0 0 1 0-7-7z"/><path d="M10 13h4v-1a1 1 0 0 0-2h-2a1 1 0 0 0-2v-2a1 1 0 0 1 2 2h2a1 1 0 0 1 2 2v1a1 1 0 0 0 2-2h-2z"/></svg>
            Reset
          </button>
          <button type="submit" class="btn-elegant btn-submit-elegant" id="btnSaveProfile">
            <svg width="14" height="14" viewBox="0 0 24 24" style="stroke-width:2.5; margin-right: 4px;"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1 2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
            <span class="btn-text">Update Profile</span>
            <span class="loading-spinner" style="display:none;"></span>
          </button>
        </div>
      </form>
    </div>

  </div>

  <!-- KOLOM KANAN: QUICK LINKS & DOWNLOAD -->
  <div>

    <!-- Quick Links Card -->
    <div style="background: var(--bg-card); border-radius: 16px; border: 1px solid var(--border); padding: 1.5rem; margin-bottom: 1.5rem;">
      <h5 style="font-size: 1rem; font-weight: 700; margin-bottom: 1rem;">Manage Data</h5>
      
      <a href="{{ route('admin.experiences.index') }}" class="quick-link-card">
        <div class="ql-icon">
          <svg viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
        </div>
        <div class="ql-text">
          <h4>Work Experiences</h4>
          <p>Kelola riwayat kerja</p>
        </div>
      </a>

      <a href="{{ route('admin.educations.index') }}" class="quick-link-card">
        <div class="ql-icon">
          <svg viewBox="0 0 24 24"><path d="M22 10v6M2 10l10-5 10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
        </div>
        <div class="ql-text">
          <h4>Education</h4>
          <p>Riwayat pendidikan formal</p>
        </div>
      </a>

      <a href="{{ route('admin.organizations.index') }}" class="quick-link-card" style="margin-bottom: 0;">
        <div class="ql-icon">
          <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        </div>
        <div class="ql-text">
          <h4>Organizations</h4>
          <p>Pengalaman organisasi</p>
        </div>
      </a>
    </div>

    <!-- Download Card -->
    <div style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); border-radius: 16px; padding: 1.5rem; color: #fff; text-align: center; border: 1px solid rgba(255,255,255,0.1);">
      <div style="width: 50px; height: 50px; background: rgba(255,255,255,0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="20 6 9 17 4 12"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
      </div>
      <h4 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 0.5rem;">Ready to Download?</h4>
      <p style="font-size: 0.85rem; color: rgba(255,255,255,0.6); margin-bottom: 1.5rem;">Generate PDF CV dengan data terbaru.</p>
      
      <a href="{{ route('download.cv') }}" target="_blank" class="btn-elegant btn-download" id="btnDownloadCV">
        Download PDF CV
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
      </a>
    </div>

  </div>
</div>

<script>
// 1. CLEANUP & INIT ALERTS
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

// 3. FORM SUBMISSION HANDLING
const profileForm = document.querySelector('form[method="POST"]');
const btnSaveProfile = document.getElementById('btnSaveProfile');

if (profileForm) {
  profileForm.addEventListener('submit', function() {
    if(btnSaveProfile) {
      const spinner = btnSaveProfile.querySelector('.loading-spinner');
      const text = btnSaveProfile.querySelector('.btn-text');
      
      if(spinner) spinner.style.display = 'inline-block';
      if(text) text.classList.add('loading-text');
    }
  });
}

// Optional: Loading state for download (Simulated)
const btnDownload = document.getElementById('btnDownloadCV');
if(btnDownload) {
  btnDownload.addEventListener('click', function() {
    const originalText = this.innerHTML;
    this.style.opacity = '0.7';
    this.innerHTML = `Downloading...`;
    setTimeout(() => {
        this.style.opacity = '1';
        this.innerHTML = originalText;
    }, 2000);
  });
}
</script>

@endsection