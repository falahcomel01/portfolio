@extends('admin.layout')

@section('title', 'Edit Education')
@section('pageTitle', 'Edit Education')

@section('content')

<style>
  /* === FORM STYLES (Consistent) === */
  .form-card { background: var(--bg-card); border-radius: 18px; border: 1px solid var(--border); max-width: 800px; margin: 0 auto; box-shadow: 0 4px 20px rgba(0,0,0,0.03); overflow: hidden; }
  .form-header { background: #fff; padding: 1.5rem 2rem; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 1rem; }
  .form-header .fh-icon { width: 40px; height: 40px; border-radius: 10px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25); }
  .form-header .fh-icon svg { width: 20px; height: 20px; stroke: #fff; fill: none; stroke-width: 2; }
  .form-header h2 { font-size: 1.1rem; font-weight: 700; margin: 0; color: var(--text); }
  .form-header p { font-size: 0.85rem; color: var(--text-light); margin: 0; }
  .form-body { padding: 2rem; }
  .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }
  .form-grid .full { grid-column: 1 / -1; }
  .field label { display: block; font-size: 0.85rem; font-weight: 600; color: var(--text); margin-bottom: 0.5rem; }
  .field input { width: 100%; padding: 0.8rem 1rem; border: 1.5px solid var(--border); border-radius: 10px; font-size: 0.95rem; font-family: 'Inter', sans-serif; transition: all 0.2s; background: #fff; color: var(--text); }
  .field input:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(99,102,241,0.1); }
  .form-actions { border-top: 1px solid var(--border); padding-top: 1.5rem; margin-top: 1rem; display: flex; justify-content: flex-end; gap: 0.8rem; }
  .btn-cancel { padding: 0.6rem 1.5rem; border-radius: 8px; font-weight: 600; font-size: 0.9rem; border: 1.5px solid var(--border); background: #fff; color: var(--text); cursor: pointer; transition: all 0.15s; font-family: 'Inter', sans-serif; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; }
  .btn-cancel:hover { background: var(--bg); }
  .btn-submit { padding: 0.6rem 1.8rem; border-radius: 8px; font-weight: 600; font-size: 0.9rem; border: none; background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); color: #fff; cursor: pointer; transition: all 0.15s; font-family: 'Inter', sans-serif; box-shadow: 0 4px 10px rgba(99,102,241,0.2); display: inline-flex; align-items: center; gap: 0.5rem; }
  .btn-submit:hover { transform: translateY(-1px); box-shadow: 0 6px 15px rgba(99,102,241,0.3); }
  .btn-submit svg { width: 16px; height: 16px; stroke: #fff; fill: none; stroke-width: 2.5; }
  @media (max-width: 768px) { .form-grid { grid-template-columns: 1fr; } }
</style>

<div class="form-card">
  <div class="form-header">
    <div class="fh-icon">
      <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
    </div>
    <div>
      <h2>Edit Education</h2>
      <p>Ubah data pendidikan yang sudah ada.</p>
    </div>
  </div>

  <div class="form-body">
    <form method="POST" action="{{ route('admin.educations.update', $education->id) }}">
      @csrf @method('PUT')
      <div class="form-grid">
        <div class="field">
          <label>Nama Sekolah/Kampus <span style="color:#ef4444">*</span></label>
          <input type="text" name="school" value="{{ old('school', $education->school) }}" required placeholder="e.g. Universitas Indonesia">
        </div>
        <div class="field">
          <label>Gelar / Jurusan <span style="color:#ef4444">*</span></label>
          <input type="text" name="degree" value="{{ old('degree', $education->degree) }}" required placeholder="e.g. S1 Teknik Informatika">
        </div>
        <div class="field">
          <label>Periode <span style="color:#ef4444">*</span></label>
          <input type="text" name="period" value="{{ old('period', $education->period) }}" required placeholder="e.g. 2020 - Sekarang">
        </div>
        <div class="field">
          <label>IPK / Nilai</label>
          <input type="text" name="gpa" value="{{ old('gpa', $education->gpa) }}" placeholder="e.g. 3.85 / 4.00">
        </div>
      </div>

      <div class="form-actions">
        <a href="{{ route('admin.educations.index') }}" class="btn-cancel">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
          Cancel
        </a>
        <button type="submit" class="btn-submit" id="btnSave">
          <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
          Update Education
        </button>
      </div>
    </form>
  </div>
</div>

<script>
  const btnSave = document.getElementById('btnSave');
  const form = document.querySelector('form');
  if(form && btnSave) { form.addEventListener('submit', () => { btnSave.innerHTML = 'Updating...'; btnSave.style.opacity = '0.8'; }); }
</script>

@endsection