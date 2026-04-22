@extends('admin.layout')

@section('title', 'Add Experience')
@section('pageTitle', 'Add Work Experience')

@section('content')

<style>
  /* === FORM STYLES === */
  .form-card {
    background: var(--bg-card);
    border-radius: 18px;
    border: 1px solid var(--border);
    max-width: 800px;
    margin: 0 auto;
    box-shadow: 0 4px 20px rgba(0,0,0,0.03);
    overflow: hidden;
  }

  .form-header {
    background: #fff;
    padding: 1.5rem 2rem;
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    gap: 1rem;
  }

  .form-header .fh-icon {
    width: 40px; height: 40px;
    border-radius: 10px;
    background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.25);
  }
  .form-header .fh-icon svg { width: 20px; height: 20px; stroke: #fff; fill: none; stroke-width: 2; }

  .form-header h2 { font-size: 1.1rem; font-weight: 700; margin: 0; color: var(--text); }
  .form-header p { font-size: 0.85rem; color: var(--text-light); margin: 0; }

  .form-body { padding: 2rem; }

  .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }
  .form-grid .full { grid-column: 1 / -1; }

  .field label {
    display: block; font-size: 0.85rem; font-weight: 600; color: var(--text);
    margin-bottom: 0.5rem;
  }
  .field input, .field textarea {
    width: 100%; padding: 0.8rem 1rem;
    border: 1.5px solid var(--border); border-radius: 10px;
    font-size: 0.95rem; font-family: 'Inter', sans-serif;
    transition: all 0.2s; background: #fff; color: var(--text);
  }
  .field input:focus, .field textarea:focus {
    outline: none; border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
  }
  .field textarea { min-height: 120px; resize: vertical; line-height: 1.6; }

  .form-actions {
    border-top: 1px solid var(--border);
    padding-top: 1.5rem;
    margin-top: 1rem;
    display: flex; justify-content: flex-end; gap: 0.8rem;
  }

  .btn-cancel {
    padding: 0.6rem 1.5rem; border-radius: 8px; font-weight: 600; font-size: 0.9rem;
    border: 1.5px solid var(--border); background: #fff; color: var(--text);
    cursor: pointer; transition: all 0.15s; font-family: 'Inter', sans-serif;
    text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;
  }
  .btn-cancel:hover { background: var(--bg); }

  .btn-submit {
    padding: 0.6rem 1.8rem; border-radius: 8px; font-weight: 600; font-size: 0.9rem;
    border: none; background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
    color: #fff; cursor: pointer; transition: all 0.15s;
    font-family: 'Inter', sans-serif; box-shadow: 0 4px 10px rgba(99,102,241,0.2);
    display: inline-flex; align-items: center; gap: 0.5rem;
  }
  .btn-submit:hover { transform: translateY(-1px); box-shadow: 0 6px 15px rgba(99,102,241,0.3); }
  .btn-submit svg { width: 16px; height: 16px; stroke: #fff; fill: none; stroke-width: 2.5; }

  @media (max-width: 768px) { .form-grid { grid-template-columns: 1fr; } }
</style>

<div class="form-card">
  <div class="form-header">
    <div class="fh-icon">
      <svg viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
    </div>
    <div>
      <h2>Add Work Experience</h2>
      <p>Tambahkan pengalaman kerja baru ke CV Anda.</p>
    </div>
  </div>

  <div class="form-body">
    <form method="POST" action="{{ route('admin.experiences.store') }}">
      @csrf
      <div class="form-grid">
        <div class="field">
          <label>Nama Perusahaan <span style="color:#ef4444">*</span></label>
          <input type="text" name="company" value="{{ old('company') }}" required placeholder="e.g. Google, Tokopedia">
        </div>
        <div class="field">
          <label>Lokasi</label>
          <input type="text" name="location" value="{{ old('location') }}" placeholder="e.g. Jakarta, Indonesia">
        </div>
        <div class="field">
          <label>Posisi / Role <span style="color:#ef4444">*</span></label>
          <input type="text" name="role" value="{{ old('role') }}" required placeholder="e.g. Frontend Developer">
        </div>
        <div class="field">
          <label>Periode <span style="color:#ef4444">*</span></label>
          <input type="text" name="period" value="{{ old('period') }}" required placeholder="e.g. Jan 2023 - Sekarang">
        </div>
        <div class="field full">
          <label>Deskripsi Pekerjaan</label>
          <textarea name="details" placeholder="Jelaskan tanggung jawab dan pencapaian Anda...">{{ old('details') }}</textarea>
        </div>
      </div>

      <div class="form-actions">
        <a href="{{ route('admin.experiences.index') }}" class="btn-cancel">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
          Cancel
        </a>
        <button type="submit" class="btn-submit" id="btnSave">
          <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
          Save Experience
        </button>
      </div>
    </form>
  </div>
</div>

<script>
  const btnSave = document.getElementById('btnSave');
  const form = document.querySelector('form');
  if(form && btnSave) {
    form.addEventListener('submit', () => {
      btnSave.innerHTML = 'Saving...';
      btnSave.style.opacity = '0.8';
    });
  }
</script>

@endsection