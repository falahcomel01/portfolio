@extends('admin.layout')

@section('title', 'About')
@section('pageTitle', 'About Me')

@section('content')
<style>
  /* =============================================
     TOAST
     ============================================= */
  #toast-container {
    position: fixed;
    top: 5rem;
    right: 1.5rem;
    z-index: 9999;
    display: flex;
    flex-direction: column;
    gap: .6rem;
    pointer-events: none;
  }

  .toast {
    pointer-events: auto;
    display: flex;
    align-items: center;
    gap: .75rem;
    padding: .85rem 1.25rem;
    border-radius: var(--radius-sm, 10px);
    background: var(--surface, #fff);
    border: 1px solid var(--border, #e8e8ed);
    box-shadow: 0 4px 16px rgba(0,0,0,.08);
    font-size: .85rem;
    font-weight: 500;
    color: var(--text-1, #111);
    transform: translateX(110%);
    transition: transform .35s cubic-bezier(.2,.8,.2,1);
    min-width: 280px;
    position: relative;
    overflow: hidden;
  }

  .toast.show { transform: translateX(0); }

  .toast-icon {
    width: 32px; height: 32px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }

  .toast-icon svg {
    width: 16px; height: 16px;
    stroke-width: 2.5;
    stroke-linecap: round;
    stroke-linejoin: round;
    fill: none;
  }

  .toast.success { border-left: 3px solid #22c55e; }
  .toast.success .toast-icon { background: #f0fdf4; }
  .toast.success .toast-icon svg { stroke: #16a34a; }

  .toast.error { border-left: 3px solid #ef4444; }
  .toast.error .toast-icon { background: #fef2f2; }
  .toast.error .toast-icon svg { stroke: #dc2626; }

  .toast-bar {
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 2px;
  }

  .toast-bar-fill {
    height: 100%;
    animation: tBar 3.5s linear forwards;
  }

  .toast.success .toast-bar-fill { background: #22c55e; }
  .toast.error .toast-bar-fill { background: #ef4444; }
  @keyframes tBar { from { width: 100%; } to { width: 0%; } }

  /* =============================================
     LAYOUT
     ============================================= */
  .about-wrap {
    max-width: 100%;
    padding: 0 0 6rem;
  }

  .about-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    height: calc(100vh - 200px);
    min-height: 420px;
    max-height: 720px;
  }

  /* =============================================
     CARDS (shared)
     ============================================= */
  .panel {
    background: var(--surface, #fff);
    border: 1px solid var(--border, #e8e8ed);
    border-radius: var(--radius, 14px);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transition: border-color .2s ease;
  }

  .panel-head {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid var(--border, #e8e8ed);
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: var(--surface-raised, #fafafa);
    flex-shrink: 0;
  }

  .panel-head .ph-left {
    display: flex;
    align-items: center;
    gap: .7rem;
  }

  .ph-icon {
    width: 36px; height: 36px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }

  .ph-icon svg {
    width: 16px; height: 16px;
    fill: none;
    stroke-width: 2;
    stroke-linecap: round;
    stroke-linejoin: round;
  }

  .ph-icon.purple { background: #f0eeff; }
  .ph-icon.purple svg { stroke: #6d28d9; }

  .ph-icon.green { background: #ecfdf5; }
  .ph-icon.green svg { stroke: #047857; }

  .panel-head h3 {
    font-size: .88rem;
    font-weight: 700;
    color: var(--text-1, #111);
  }

  .ph-badge {
    font-size: .65rem;
    font-weight: 700;
    padding: .15rem .55rem;
    border-radius: 50px;
    letter-spacing: .04em;
    text-transform: uppercase;
  }

  .badge-html { background: #fef3c7; color: #92400e; }
  .badge-live { background: #ecfdf5; color: #065f46; display: flex; align-items: center; gap: .3rem; }
  .live-dot { width: 5px; height: 5px; border-radius: 50%; background: #22c55e; animation: livePulse 2s ease-in-out infinite; }
  @keyframes livePulse { 0%,100% { opacity: 1; } 50% { opacity: .3; } }

  /* =============================================
     EDITOR
     ============================================= */
  .toolbar {
    padding: .45rem .6rem;
    border-bottom: 1px solid var(--border, #e8e8ed);
    display: flex;
    align-items: center;
    gap: 2px;
    flex-wrap: wrap;
    flex-shrink: 0;
  }

  .tb {
    width: 30px; height: 30px;
    border-radius: 7px;
    border: 1px solid transparent;
    background: transparent;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all .15s;
    position: relative;
  }

  .tb:hover { background: var(--surface-raised, #fafafa); border-color: var(--border, #e8e8ed); }
  .tb:active { background: #eef2ff; border-color: #c7d2fe; }

  .tb svg { width: 14px; height: 14px; stroke: var(--text-2, #52525b); fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
  .tb .tb-label { font-size: .72rem; font-weight: 700; color: var(--text-1, #111); line-height: 1; font-family: 'Inter', sans-serif; }

  .tb-sep { width: 1px; height: 20px; background: var(--border, #e8e8ed); margin: 0 3px; }

  .tb[title]::after {
    content: attr(title);
    position: absolute;
    bottom: calc(100% + 6px);
    left: 50%; transform: translateX(-50%);
    background: #1e293b; color: #fff;
    font-size: .65rem; padding: .2rem .5rem;
    border-radius: 5px; white-space: nowrap;
    pointer-events: none; opacity: 0;
    transition: opacity .15s; z-index: 10;
  }
  .tb:hover[title]::after { opacity: 1; }

  .editor-body {
    flex: 1;
    padding: .75rem;
    overflow: hidden;
    min-height: 0;
  }

  .editor-body textarea {
    width: 100%; height: 100%;
    border: none; outline: none; resize: none;
    font-family: 'JetBrains Mono', 'Courier New', monospace;
    font-size: .82rem;
    line-height: 1.7;
    color: var(--text-1, #111);
    background: transparent;
    tab-size: 2;
  }

  .editor-body textarea::placeholder { color: #cbd5e1; }

  .editor-foot {
    padding: .6rem 1.25rem;
    border-top: 1px solid var(--border, #e8e8ed);
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: var(--surface-raised, #fafafa);
    flex-shrink: 0;
  }

  .ef-stats { display: flex; gap: 1rem; }

  .ef-stat {
    font-size: .72rem;
    color: var(--text-3, #a1a1aa);
    display: flex;
    align-items: center;
    gap: .3rem;
  }

  .ef-stat strong { color: var(--text-2, #52525b); font-weight: 600; font-variant-numeric: tabular-nums; }

  .ef-actions { display: flex; gap: .6rem; }

  .btn-ghost {
    padding: .5rem .9rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: .8rem;
    border: 1px solid var(--border, #e8e8ed);
    background: #fff;
    color: var(--text-2, #52525b);
    cursor: pointer;
    transition: all .15s;
    font-family: 'Inter', sans-serif;
    display: inline-flex;
    align-items: center;
    gap: .35rem;
  }

  .btn-ghost:hover { background: var(--surface-raised, #fafafa); color: var(--text-1, #111); }

  .btn-ghost svg { width: 13px; height: 13px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

  .btn-save {
    padding: .5rem 1.2rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: .8rem;
    border: none;
    background: var(--primary, #6366f1);
    color: #fff;
    cursor: pointer;
    transition: all .2s;
    font-family: 'Inter', sans-serif;
    display: inline-flex;
    align-items: center;
    gap: .35rem;
    box-shadow: 0 1px 3px rgba(99,102,241,.25);
    position: relative;
    overflow: hidden;
  }

  .btn-save:hover { background: var(--primary-hover, #4f46e5); box-shadow: 0 2px 8px rgba(99,102,241,.3); transform: translateY(-1px); }
  .btn-save:active { transform: translateY(0) scale(.98); }

  .btn-save svg { width: 14px; height: 14px; stroke: #fff; fill: none; stroke-width: 2.5; stroke-linecap: round; stroke-linejoin: round; position: relative; z-index: 1; }
  .btn-save .btn-label { position: relative; z-index: 1; }

  .btn-save.loading { pointer-events: none; opacity: .7; }
  .btn-save.loading .btn-label { opacity: 0; }
  .btn-save .spinner {
    display: none; width: 16px; height: 16px;
    border: 2px solid rgba(255,255,255,.3);
    border-top-color: #fff; border-radius: 50%;
    animation: spin .6s linear infinite;
    position: absolute; left: 50%; top: 50%;
    margin: -8px 0 0 -8px;
  }
  .btn-save.loading .spinner { display: block; }
  .btn-save.loading svg { opacity: 0; }
  @keyframes spin { to { transform: rotate(360deg); } }

  /* =============================================
     PREVIEW
     ============================================= */
  .preview-body {
    flex: 1;
    padding: 1.25rem 1.5rem;
    overflow-y: auto;
    min-height: 0;
  }

  .pv-label {
    font-size: .65rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .06em;
    color: var(--text-3, #a1a1aa);
    margin-bottom: .5rem;
  }

  .pv-content {
    font-size: .92rem;
    line-height: 1.8;
    color: var(--text-1, #111);
  }

  .pv-content p { margin-bottom: .75rem; }
  .pv-content strong { font-weight: 600; }
  .pv-content a { color: var(--primary, #6366f1); text-decoration: underline; }
  .pv-content ul, .pv-content ol { margin: .35rem 0 .75rem 1.2rem; }
  .pv-content li { margin-bottom: .25rem; }

  .pv-empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
    text-align: center;
    color: var(--text-3, #a1a1aa);
    padding: 2rem;
  }

  .pv-empty-icon {
    width: 52px; height: 52px;
    border-radius: 14px;
    background: var(--surface-raised, #fafafa);
    border: 1px solid var(--border, #e8e8ed);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: .85rem;
  }

  .pv-empty-icon svg { width: 22px; height: 22px; stroke: var(--border, #e8e8ed); fill: none; stroke-width: 1.5; stroke-linecap: round; stroke-linejoin: round; }

  .pv-empty p { font-size: .82rem; max-width: 260px; line-height: 1.6; }

  .pv-empty-hint {
    font-size: .72rem;
    margin-top: .6rem;
    padding: .35rem .8rem;
    background: var(--surface-raised, #fafafa);
    border: 1px solid var(--border, #e8e8ed);
    border-radius: 7px;
    color: var(--text-3, #a1a1aa);
    font-family: 'JetBrains Mono', monospace;
  }

  /* =============================================
     TIPS
     ============================================= */
  .tips {
    background: var(--surface, #fff);
    border: 1px solid var(--border, #e8e8ed);
    border-radius: var(--radius, 14px);
    overflow: hidden;
    margin-top: 1.25rem;
  }

  .tips-head {
    padding: .75rem 1.25rem;
    border-bottom: 1px solid var(--border, #e8e8ed);
    display: flex;
    align-items: center;
    gap: .5rem;
  }

  .tips-head svg { width: 14px; height: 14px; stroke: #d97706; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
  .tips-head span { font-size: .8rem; font-weight: 600; color: #92400e; }

  .tips-grid {
    padding: .85rem 1.25rem;
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: .45rem;
  }

  .tip {
    font-size: .75rem;
    color: var(--text-3, #a1a1aa);
    line-height: 1.45;
  }

  .tip code {
    display: block;
    background: var(--surface-raised, #fafafa);
    padding: .1rem .4rem;
    border-radius: 5px;
    font-size: .68rem;
    font-family: 'JetBrains Mono', monospace;
    color: var(--text-2, #52525b);
    white-space: nowrap;
    margin-bottom: .15rem;
    border: 1px solid var(--border, #e8e8ed);
  }

  /* =============================================
     SCROLLBAR
     ============================================= */
  .preview-body::-webkit-scrollbar,
  .editor-body textarea::-webkit-scrollbar { width: 4px; }
  .preview-body::-webkit-scrollbar-track,
  .editor-body textarea::-webkit-scrollbar-track { background: transparent; }
  .preview-body::-webkit-scrollbar-thumb,
  .editor-body textarea::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
  .preview-body::-webkit-scrollbar-thumb:hover,
  .editor-body textarea::-webkit-scrollbar-thumb:hover { background: #cbd5e1; }

  /* =============================================
     RESPONSIVE
     ============================================= */
  @media (max-width: 1024px) {
    .about-grid {
      grid-template-columns: 1fr;
      height: auto;
      max-height: none;
    }
    .preview-panel { order: -1; max-height: 320px; }
  }

  @media (max-width: 768px) {
    .tips-grid { grid-template-columns: 1fr 1fr; }
    .about-grid { height: auto; max-height: none; }
    .preview-panel { max-height: 280px; }
  }

  @media (max-width: 640px) {
    .tips-grid { grid-template-columns: 1fr; }
    .toolbar { gap: 1px; }
    .tb { width: 28px; height: 28px; }
    .editor-foot { flex-direction: column; gap: .5rem; }
    .ef-actions { width: 100%; }
    .ef-actions button { flex: 1; justify-content: center; }
    .preview-panel { max-height: 240px; }
  }

  @media (prefers-reduced-motion: reduce) {
    .toast { transition-duration: .01s; }
    .live-dot { animation: none; }
  }
</style>

<div id="toast-container"></div>

<form method="POST" action="{{ route('admin.about.update') }}" id="aboutForm">
  @csrf

  <div class="about-wrap">
    <div class="about-grid">

      <!-- ========== EDITOR ========== -->
      <div class="panel">
        <div class="panel-head">
          <div class="ph-left">
            <div class="ph-icon purple">
              <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            </div>
            <h3>HTML Editor</h3>
          </div>
          <span class="ph-badge badge-html">HTML</span>
        </div>

        <div class="toolbar">
          <button type="button" class="tb" title="Bold" onclick="insertTag('strong')"><span class="tb-label">B</span></button>
          <button type="button" class="tb" title="Italic" onclick="insertTag('em')"><span class="tb-label" style="font-style:italic">I</span></button>
          <button type="button" class="tb" title="Underline" onclick="insertTag('u')"><span class="tb-label" style="text-decoration:underline">U</span></button>
          <div class="tb-sep"></div>
          <button type="button" class="tb" title="Paragraph" onclick="insertBlock('p')">
            <svg viewBox="0 0 24 24"><line x1="17" y1="10" x2="3" y2="10"/><line x1="21" y1="6" x2="3" y2="6"/><line x1="21" y1="14" x2="3" y2="14"/><line x1="17" y1="18" x2="3" y2="18"/></svg>
          </button>
          <button type="button" class="tb" title="Heading" onclick="insertBlock('h3')">
            <svg viewBox="0 0 24 24"><path d="M4 12h8"/><path d="M4 18V6"/><path d="M12 18V6"/><path d="M21 18h-4c0-4 4-3 4-6 0-3-4-2-4-6h4"/></svg>
          </button>
          <div class="tb-sep"></div>
          <button type="button" class="tb" title="Bullet List" onclick="insertBlock('li')">
            <svg viewBox="0 0 24 24"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
          </button>
          <button type="button" class="tb" title="Numbered List" onclick="insertBlock('li', true)">
            <svg viewBox="0 0 24 24"><line x1="10" y1="6" x2="21" y2="6"/><line x1="10" y1="12" x2="21" y2="12"/><line x1="10" y1="18" x2="21" y2="18"/><path d="M4 6h1v4"/><path d="M4 10h2"/><path d="M6 18H4c0-1 2-2 2-3s-1-1.5-2-1"/></svg>
          </button>
          <div class="tb-sep"></div>
          <button type="button" class="tb" title="Link" onclick="insertLink()">
            <svg viewBox="0 0 24 24"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
          </button>
          <button type="button" class="tb" title="Line Break" onclick="insertAtCursor('&lt;br&gt;')">
            <svg viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
          </button>
        </div>

        <div class="editor-body">
          <textarea
            name="content"
            id="editorArea"
            placeholder="Tulis konten about kamu di sini...&#10;&#10;Contoh:&#10;&lt;p&gt;Paragraf pertama&lt;/p&gt;&#10;&lt;p&gt;Paragraf &lt;strong&gt;tebal&lt;/strong&gt; kedua&lt;/p&gt;"
            oninput="updatePreview()"
          >{{ $about ? $about->content : '' }}</textarea>
        </div>

        <div class="editor-foot">
          <div class="ef-stats">
            <div class="ef-stat">
              <strong id="charCount">0</strong> karakter
            </div>
            <div class="ef-stat">
              <strong id="wordCount">0</strong> kata
            </div>
            <div class="ef-stat">
              <strong id="paraCount">0</strong> paragraf
            </div>
          </div>
          <div class="ef-actions">
            <button type="button" class="btn-ghost" onclick="clearEditor()">
              <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
              Hapus
            </button>
            <button type="submit" class="btn-save" id="saveBtn">
              <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
              <div class="spinner"></div>
              <span class="btn-label">Simpan</span>
            </button>
          </div>
        </div>
      </div>

      <!-- ========== PREVIEW ========== -->
      <div class="panel preview-panel">
        <div class="panel-head">
          <div class="ph-left">
            <div class="ph-icon green">
              <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            </div>
            <h3>Live Preview</h3>
          </div>
          <span class="ph-badge badge-live">
            <span class="live-dot"></span>
            Real-time
          </span>
        </div>

        <div class="preview-body" id="previewBody">
          <div class="pv-label">Tampilan di Website</div>
          <div class="pv-content" id="previewContent">
            @if($about && $about->content)
              {!! $about->content !!}
            @else
              <div class="pv-empty">
                <div class="pv-empty-icon">
                  <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                </div>
                <p>Belum ada konten. Mulai tulis di editor sebelah kiri untuk melihat preview di sini.</p>
                <div class="pv-empty-hint">&lt;p&gt;Tulis paragraf pertama&lt;/p&gt;</div>
              </div>
            @endif
          </div>
        </div>
      </div>

    </div>
  </div>
</form>

<!-- TIPS -->
<div class="tips">
  <div class="tips-head">
    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
    <span>Panduan Tag HTML</span>
  </div>
  <div class="tips-grid">
    <div class="tip"><code>&lt;strong&gt;...&lt;/strong&gt;</code> Teks tebal</div>
    <div class="tip"><code>&lt;em&gt;...&lt;/em&gt;</code> Teks miring</div>
    <div class="tip"><code>&lt;p&gt;...&lt;/p&gt;</code> Paragraf baru</div>
    <div class="tip"><code>&lt;h3&gt;...&lt;/h3&gt;</code> Sub-judul</div>
    <div class="tip"><code>&lt;ul&gt;&lt;li&gt;...&lt;/li&gt;&lt;/ul&gt;</code> List bullet</div>
    <div class="tip"><code>&lt;ol&gt;&lt;li&gt;...&lt;/li&gt;&lt;/ol&gt;</code> List angka</div>
    <div class="tip"><code>&lt;a href="url"&gt;...&lt;/a&gt;</code> Link</div>
    <div class="tip"><code>&lt;br&gt;</code> Ganti baris</div>
  </div>
</div>

<script>
  /* ── Toast ── */
  function showToast(msg, type) {
    var c = document.getElementById('toast-container');
    var icons = {
      success: '<svg viewBox="0 0 24 24" stroke="currentColor"><polyline points="20 6 9 17 4 12"/></svg>',
      error: '<svg viewBox="0 0 24 24" stroke="currentColor"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>'
    };
    var t = document.createElement('div');
    t.className = 'toast ' + (type || 'success');
    t.style.position = 'relative';
    t.innerHTML = '<div class="toast-icon">' + (icons[type] || icons.success) + '</div><span>' + msg + '</span><div class="toast-bar"><div class="toast-bar-fill"></div></div>';
    c.appendChild(t);
    requestAnimationFrame(function() { requestAnimationFrame(function() { t.classList.add('show'); }); });
    setTimeout(function() { t.classList.remove('show'); setTimeout(function() { t.remove(); }, 400); }, 3500);
  }

  /* ── Hide old alerts, show session toasts ── */
  document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.alert,.alert-success,.alert-danger,.alert-info').forEach(function(el) { el.style.display = 'none'; });
    @if(session('success'))
      showToast('{{ session("success") }}', 'success');
    @endif
    @if(session('error'))
      showToast('{{ session("error") }}', 'error');
    @endif
  });

  /* ── Editor Logic ── */
  var editor = document.getElementById('editorArea');
  var preview = document.getElementById('previewContent');
  var charEl = document.getElementById('charCount');
  var wordEl = document.getElementById('wordCount');
  var paraEl = document.getElementById('paraCount');

  function updatePreview() {
    var val = editor.value;
    if (val.trim() === '') {
      preview.innerHTML = '<div class="pv-empty"><div class="pv-empty-icon"><svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></div><p>Belum ada konten. Mulai tulis di editor sebelah kiri untuk melihat preview di sini.</p><div class="pv-empty-hint">&lt;p&gt;Tulis paragraf pertama&lt;/p&gt;</div></div>';
    } else {
      preview.innerHTML = val;
    }
    var text = val.trim();
    charEl.textContent = text.length;
    wordEl.textContent = text === '' ? 0 : text.split(/\s+/).length;
    paraEl.textContent = text === '' ? 0 : (text.match(/<p[^>]*>|<h[1-6][^>]*>|<li[^>]*>/gi) || []).length;
  }

  function insertTag(tag) {
    var s = editor.selectionStart, e = editor.selectionEnd;
    var sel = editor.value.substring(s, e);
    var rep = '<' + tag + '>' + (sel || 'teks') + '</' + tag + '>';
    editor.value = editor.value.substring(0, s) + rep + editor.value.substring(e);
    editor.focus();
    editor.selectionStart = s + tag.length + 2;
    editor.selectionEnd = s + tag.length + 2 + (sel || 'teks').length;
    updatePreview();
  }

  function insertBlock(tag, ordered) {
    var s = editor.selectionStart, e = editor.selectionEnd;
    var sel = editor.value.substring(s, e);
    var open = ordered ? '<ol>\n  <li>' : '<ul>\n  <li>';
    var close = ordered ? '</li>\n</ol>' : '</li>\n</ul>';
    var items = sel
      ? sel.split('\n').map(function(l) { return '  <li>' + l.trim() + '</li>'; }).join('\n')
      : '  <li>Item pertama</li>\n  <li>Item kedua</li>';
    var rep = open + (sel ? items.substring(2) : items) + '\n' + close;
    editor.value = editor.value.substring(0, s) + rep + editor.value.substring(e);
    editor.focus();
    updatePreview();
  }

  function insertLink() {
    var s = editor.selectionStart, e = editor.selectionEnd;
    var sel = editor.value.substring(s, e);
    var rep = '<a href="https://example.com">' + (sel || 'teks link') + '</a>';
    editor.value = editor.value.substring(0, s) + rep + editor.value.substring(e);
    editor.focus();
    updatePreview();
  }

  function insertAtCursor(html) {
    var s = editor.selectionStart;
    editor.value = editor.value.substring(0, s) + html + editor.value.substring(s);
    editor.focus();
    editor.selectionStart = editor.selectionEnd = s + html.length;
    updatePreview();
  }

  function clearEditor() {
    if (confirm('Hapus semua konten about?')) {
      editor.value = '';
      updatePreview();
    }
  }

  editor.addEventListener('keydown', function(e) {
    if (e.key === 'Tab') { e.preventDefault(); insertAtCursor('  '); }
  });

  /* ── Form Submit ── */
  document.getElementById('aboutForm').addEventListener('submit', function(e) {
    e.preventDefault();
    var btn = document.getElementById('saveBtn');
    btn.classList.add('loading');
    btn.querySelector('.btn-label').textContent = 'Menyimpan...';
    btn.disabled = true;

    var fd = new FormData(this);
    fetch(this.action, {
      method: 'POST',
      body: fd,
      headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value }
    })
    .then(function(r) { return r.json(); })
    .then(function(data) {
      if (data.success) {
        showToast(data.message || 'Berhasil disimpan!', 'success');
      } else {
        if (data.errors) {
          Object.values(data.errors).forEach(function(m) { showToast(m[0] || m, 'error'); });
        } else {
          showToast(data.message || 'Gagal menyimpan.', 'error');
        }
      }
    })
    .catch(function() { showToast('Gagal menghubungi server.', 'error'); })
    .finally(function() {
      btn.classList.remove('loading');
      btn.querySelector('.btn-label').textContent = 'Simpan';
      btn.disabled = false;
    });
  });

  updatePreview();
</script>

@endsection