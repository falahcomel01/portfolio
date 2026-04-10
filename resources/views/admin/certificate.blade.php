@extends('admin.layout')

@section('title', 'Sertifikat')
@section('pageTitle', 'Kelola Sertifikat')

@section('content')

<!-- ALERT CONTAINER (Posisi Notifikasi Cantik) -->
<div id="alert-container"></div>

<style>
  /* ===============================
     NEW ALERT STYLES (Sesuai Request)
     =============================== */
  #alert-container {
    margin-bottom: 1.5rem;
    position: relative;
    z-index: 50;
  }

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
    margin-bottom: 0;
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

  .custom-alert.error .ca-icon {
    background: #ef4444;
    box-shadow: 0 2px 4px rgba(239, 68, 68, 0.2);
  }

  .ca-icon svg {
    width: 16px;
    height: 16px;
    stroke-width: 2.5;
    stroke-linecap: round;
    stroke-linejoin: round;
  }

  .ca-content {
    flex: 1;
    padding-top: 2px;
  }

  .ca-title {
    font-weight: 700;
    font-size: 1rem;
    margin-bottom: 2px;
    display: block;
    letter-spacing: -0.01em;
  }

  .ca-msg {
    font-weight: 400;
    line-height: 1.5;
    opacity: 0.9;
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

  @keyframes slideDown {
    from { opacity: 0; transform: translateY(-15px); }
    to { opacity: 1; transform: translateY(0); }
  }

  @keyframes fadeOut {
    from { opacity: 1; transform: scale(1); }
    to { opacity: 0; transform: scale(0.98); }
  }

  /* Loading Spinner */
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

  /* ===============================
     ORIGINAL STYLES (Preserved)
     =============================== */
  /* === STATS BAR === */
  .cert-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
    margin-bottom: 1.5rem;
  }

  .cert-stat-card {
    background: var(--bg-card);
    border-radius: 14px;
    border: 1px solid var(--border);
    padding: 1.25rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: all .2s;
  }

  .cert-stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,.06);
  }

  .cs-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }

  .cs-icon svg {
    width: 20px;
    height: 20px;
    stroke-width: 2;
    stroke-linecap: round;
    stroke-linejoin: round;
    fill: none;
  }

  .cs-icon.blue { background: #eef2ff; }
  .cs-icon.blue svg { stroke: #6366f1; }
  .cs-icon.green { background: #ecfdf5; }
  .cs-icon.green svg { stroke: #10b981; }
  .cs-icon.orange { background: #fff7ed; }
  .cs-icon.orange svg { stroke: #f59e0b; }

  .cs-info .cs-label {
    font-size: .78rem;
    color: var(--text-light);
    font-weight: 500;
    margin-bottom: .15rem;
  }

  .cs-info .cs-value {
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--text);
    line-height: 1;
  }

  /* === TOOLBAR === */
  .cert-toolbar {
    background: var(--bg-card);
    border-radius: 14px;
    border: 1px solid var(--border);
    padding: .85rem 1.25rem;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: .75rem;
    flex-wrap: wrap;
  }

  .cert-search {
    flex: 1;
    min-width: 200px;
    position: relative;
  }

  .cert-search svg {
    position: absolute;
    left: .85rem;
    top: 50%;
    transform: translateY(-50%);
    width: 16px;
    height: 16px;
    stroke: #94a3b8;
    fill: none;
    stroke-width: 2;
    stroke-linecap: round;
    stroke-linejoin: round;
  }

  .cert-search input {
    width: 100%;
    padding: .6rem 1rem .6rem 2.5rem;
    border: 1.5px solid var(--border);
    border-radius: 10px;
    font-size: .85rem;
    font-family: 'Inter', sans-serif;
    background: #fff;
    color: var(--text);
    transition: all .2s;
  }

  .cert-search input:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(99,102,241,.1);
  }

  .cert-add-btn {
    padding: .6rem 1.15rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: .82rem;
    border: 1.5px solid var(--primary);
    background: var(--primary);
    color: #fff;
    cursor: pointer;
    transition: all .15s;
    font-family: 'Inter', sans-serif;
    display: inline-flex;
    align-items: center;
    gap: .4rem;
  }

  .cert-add-btn:hover {
    background: #4f46e5;
    border-color: #4f46e5;
    transform: translateY(-1px);
    box-shadow: 0 3px 10px rgba(99,102,241,.25);
  }

  .cert-add-btn svg {
    width: 15px;
    height: 15px;
    stroke: currentColor;
    fill: none;
    stroke-width: 2.5;
    stroke-linecap: round;
    stroke-linejoin: round;
  }

  /* === LIST === */
  .cert-list {
    background: var(--bg-card);
    border-radius: 14px;
    border: 1px solid var(--border);
    overflow: hidden;
  }

  .cert-list-head {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    gap: 1rem;
    font-size: .75rem;
    font-weight: 600;
    color: var(--text-light);
    text-transform: uppercase;
    letter-spacing: .5px;
    background: var(--bg);
  }

  .clh-image { width: 64px; }
  .clh-title { flex: 2; }
  .clh-issuer { flex: 1; }
  .clh-date { width: 100px; text-align: center; }
  .clh-order { width: 64px; text-align: center; }
  .clh-actions { width: 90px; text-align: center; }

  .cert-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem 1.5rem;
    border-bottom: 1px solid var(--border);
    transition: background .12s;
    color: var(--text);
    position: relative;
  }

  .cert-item:last-child { border-bottom: none; }
  .cert-item:hover { background: #f8fafc; }

  .ci-image {
    width: 52px;
    height: 38px;
    border-radius: 8px;
    object-fit: cover;
    border: 1px solid var(--border);
    flex-shrink: 0;
    background: var(--bg);
  }

  .ci-title { flex: 2; min-width: 0; }

  .ci-title-name {
    font-size: .9rem;
    font-weight: 600;
    margin-bottom: .2rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .ci-title-link {
    display: inline-flex;
    align-items: center;
    gap: .25rem;
    font-size: .72rem;
    color: var(--primary);
    text-decoration: none;
    font-weight: 500;
    transition: color .12s;
  }

  .ci-title-link:hover { color: #4f46e5; text-decoration: underline; }

  .ci-title-link svg {
    width: 11px;
    height: 11px;
    stroke: currentColor;
    fill: none;
    stroke-width: 2;
    stroke-linecap: round;
    stroke-linejoin: round;
  }

  .ci-issuer { flex: 1; min-width: 0; }

  .ci-issuer-badge {
    display: inline-flex;
    align-items: center;
    gap: .35rem;
    font-size: .78rem;
    font-weight: 500;
    padding: .25rem .65rem;
    border-radius: 50px;
    background: var(--bg);
    color: var(--text-light);
    border: 1px solid var(--border);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 100%;
  }

  .ci-issuer-badge svg {
    width: 12px;
    height: 12px;
    stroke: currentColor;
    fill: none;
    stroke-width: 2;
    stroke-linecap: round;
    stroke-linejoin: round;
    flex-shrink: 0;
  }

  .ci-date {
    width: 100px;
    text-align: center;
    font-size: .82rem;
    color: var(--text-light);
    white-space: nowrap;
    flex-shrink: 0;
  }

  .ci-order { width: 64px; text-align: center; flex-shrink: 0; }

  .ci-order-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 30px;
    height: 30px;
    border-radius: 8px;
    font-size: .78rem;
    font-weight: 700;
    background: #f1f5f9;
    color: #475569;
    border: 1px solid #e2e8f0;
  }

  .ci-actions {
    width: 90px;
    display: flex;
    gap: .35rem;
    justify-content: center;
    opacity: 0;
    transition: opacity .15s;
    flex-shrink: 0;
  }

  .cert-item:hover .ci-actions { opacity: 1; }

  .ci-act-btn {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    border: 1px solid var(--border);
    background: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all .12s;
    text-decoration: none;
  }

  .ci-act-btn:hover { background: var(--bg); }

  .ci-act-btn.edit-btn:hover {
    border-color: var(--primary);
    background: #fafaff;
  }

  .ci-act-btn.edit-btn:hover svg { stroke: var(--primary); }

  .ci-act-btn.delete-btn:hover {
    background: #fef2f2;
    border-color: #fca5a5;
  }

  .ci-act-btn.delete-btn:hover svg { stroke: #ef4444; }

  .ci-act-btn svg {
    width: 14px;
    height: 14px;
    stroke: var(--text-light);
    fill: none;
    stroke-width: 2;
    stroke-linecap: round;
    stroke-linejoin: round;
  }

  /* === EMPTY STATE === */
  .cert-empty {
    text-align: center;
    padding: 5rem 2rem;
    color: var(--text-light);
  }

  .cert-empty .ce-icon {
    width: 80px;
    height: 80px;
    border-radius: 20px;
    background: var(--bg);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.25rem;
  }

  .cert-empty .ce-icon svg {
    width: 36px;
    height: 36px;
    stroke: var(--border);
    fill: none;
    stroke-width: 1.5;
    stroke-linecap: round;
    stroke-linejoin: round;
  }

  .cert-empty h4 {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--text);
    margin-bottom: .4rem;
  }

  .cert-empty p {
    font-size: .9rem;
    max-width: 360px;
    margin: 0 auto 1.25rem;
    line-height: 1.6;
  }

  .no-results {
    text-align: center;
    padding: 3rem 1.5rem;
    color: var(--text-light);
    display: none;
  }

  .no-results svg {
    width: 40px;
    height: 40px;
    stroke: var(--border);
    fill: none;
    stroke-width: 1.5;
    margin-bottom: .5rem;
  }

  .no-results p { font-size: .85rem; }

  /* === MODALS (Form & Delete) === */
  .cert-modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(15,23,42,.45);
    backdrop-filter: blur(4px);
    z-index: 100;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 1rem;
  }

  .cert-modal-overlay.show { display: flex; }

  /* Delete modal - small */
  .cert-modal-sm {
    background: var(--bg-card);
    border-radius: 16px;
    border: 1px solid var(--border);
    width: 100%;
    max-width: 400px;
    padding: 2rem;
    box-shadow: 0 20px 60px rgba(0,0,0,.15);
    animation: modalIn .25s ease;
  }

  .cert-modal-sm .cm-icon {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    background: #fef2f2;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.15rem;
  }

  .cert-modal-sm .cm-icon svg {
    width: 24px;
    height: 24px;
    stroke: #ef4444;
    fill: none;
    stroke-width: 2;
    stroke-linecap: round;
    stroke-linejoin: round;
  }

  .cert-modal-sm h3 {
    font-size: 1.05rem;
    font-weight: 700;
    text-align: center;
    color: var(--text);
    margin-bottom: .5rem;
  }

  .cert-modal-sm p {
    font-size: .85rem;
    color: var(--text-light);
    text-align: center;
    line-height: 1.6;
    margin-bottom: 1.5rem;
  }

  .cert-modal-sm p strong { color: var(--text); }

  .cm-actions {
    display: flex;
    gap: .6rem;
  }

  .cm-btn {
    flex: 1;
    padding: .65rem 1rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: .84rem;
    border: 1.5px solid var(--border);
    background: #fff;
    color: var(--text);
    cursor: pointer;
    transition: all .12s;
    font-family: 'Inter', sans-serif;
  }

  .cm-btn:hover { background: var(--bg); }

  .cm-btn.danger {
    background: #ef4444;
    border-color: #ef4444;
    color: #fff;
  }

  .cm-btn.danger:hover { background: #dc2626; border-color: #dc2626; }

  /* Form modal - big */
  .cert-modal-lg {
    background: var(--bg-card);
    border-radius: 16px;
    border: 1px solid var(--border);
    width: 100%;
    max-width: 560px;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 20px 60px rgba(0,0,0,.15);
    animation: modalIn .25s ease;
  }

  .cert-modal-lg .cm-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid var(--border);
    position: sticky;
    top: 0;
    background: var(--bg-card);
    border-radius: 16px 16px 0 0;
    z-index: 2;
  }

  .cert-modal-lg .cm-header h3 {
    font-size: 1.05rem;
    font-weight: 700;
    color: var(--text);
  }

  .cert-modal-lg .cm-close {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    border: 1px solid var(--border);
    background: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all .12s;
  }

  .cert-modal-lg .cm-close:hover { background: #fef2f2; border-color: #fca5a5; }
  .cert-modal-lg .cm-close:hover svg { stroke: #ef4444; }

  .cert-modal-lg .cm-close svg {
    width: 16px;
    height: 16px;
    stroke: var(--text-light);
    fill: none;
    stroke-width: 2;
    stroke-linecap: round;
    stroke-linejoin: round;
  }

  .cert-modal-lg .cm-body {
    padding: 1.5rem;
  }

  .cert-modal-lg .cm-footer {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: .6rem;
    padding: 1.25rem 1.5rem;
    border-top: 1px solid var(--border);
    position: sticky;
    bottom: 0;
    background: var(--bg-card);
    border-radius: 0 0 16px 16px;
  }

  /* Form elements inside modal */
  .cf-group { margin-bottom: 1.25rem; }
  .cf-group:last-child { margin-bottom: 0; }

  .cf-label {
    display: block;
    font-size: .84rem;
    font-weight: 600;
    color: var(--text);
    margin-bottom: .5rem;
  }

  .cf-label .cf-required { color: #ef4444; margin-left: 2px; }
  .cf-label .cf-hint { font-weight: 400; color: var(--text-light); font-size: .76rem; margin-left: .4rem; }

  .cf-input {
    width: 100%;
    padding: .65rem 1rem;
    border: 1.5px solid var(--border);
    border-radius: 10px;
    font-size: .85rem;
    font-family: 'Inter', sans-serif;
    background: #fff;
    color: var(--text);
    transition: all .2s;
    box-sizing: border-box;
  }

  .cf-input:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(99,102,241,.1);
  }

  .cf-input.has-error { border-color: #fca5a5; }
  .cf-input.has-error:focus { box-shadow: 0 0 0 3px rgba(239,68,68,.1); }

  .cf-input-icon-wrap { position: relative; }

  .cf-input-icon-wrap svg {
    position: absolute;
    left: .85rem;
    top: 50%;
    transform: translateY(-50%);
    width: 16px;
    height: 16px;
    stroke: #94a3b8;
    fill: none;
    stroke-width: 2;
    stroke-linecap: round;
    stroke-linejoin: round;
    pointer-events: none;
  }

  .cf-input-icon-wrap .cf-input { padding-left: 2.5rem; }

  .cf-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }

  .cf-error {
    display: flex;
    align-items: center;
    gap: .3rem;
    font-size: .76rem;
    color: #dc2626;
    margin-top: .4rem;
  }

  .cf-error svg {
    width: 13px;
    height: 13px;
    stroke: currentColor;
    fill: none;
    stroke-width: 2;
    stroke-linecap: round;
    stroke-linejoin: round;
    flex-shrink: 0;
  }

  /* Upload zone */
  .cf-upload {
    border: 2px dashed var(--border);
    border-radius: 12px;
    padding: 1.75rem 1.5rem;
    text-align: center;
    cursor: pointer;
    transition: all .2s;
    background: #fff;
  }

  .cf-upload:hover { border-color: var(--primary); background: #fafaff; }
  .cf-upload.dragging { border-color: var(--primary); background: #eef2ff; }
  .cf-upload.has-error { border-color: #fca5a5; background: #fef2f2; }

  .cf-upload .cu-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: var(--bg);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto .65rem;
  }

  .cf-upload .cu-icon svg {
    width: 18px;
    height: 18px;
    stroke: var(--border);
    fill: none;
    stroke-width: 1.5;
    stroke-linecap: round;
    stroke-linejoin: round;
  }

  .cf-upload .cu-text { font-size: .82rem; color: var(--text); font-weight: 500; margin-bottom: .15rem; }
  .cf-upload .cu-hint { font-size: .74rem; color: var(--text-light); }

  .cf-upload .cu-preview { display: none; }

  .cf-upload .cu-preview img {
    max-height: 160px;
    max-width: 100%;
    border-radius: 8px;
    border: 1px solid var(--border);
    margin: 0 auto;
  }

  .cf-upload .cu-preview .cu-name {
    font-size: .76rem;
    color: var(--text-light);
    margin-top: .5rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .cf-upload .cu-preview .cu-remove {
    display: inline-flex;
    align-items: center;
    gap: .25rem;
    font-size: .76rem;
    color: #dc2626;
    font-weight: 500;
    margin-top: .4rem;
    cursor: pointer;
    background: none;
    border: none;
    font-family: 'Inter', sans-serif;
    padding: 0;
  }

  .cf-upload .cu-preview .cu-remove:hover { text-decoration: underline; }

  .cf-upload .cu-preview .cu-remove svg {
    width: 12px;
    height: 12px;
    stroke: currentColor;
    fill: none;
    stroke-width: 2;
  }

  /* Current image in edit */
  .cf-current-img {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: .85rem 1rem;
    background: var(--bg);
    border-radius: 10px;
    border: 1px solid var(--border);
    margin-bottom: 1rem;
  }

  .cf-current-img img {
    width: 100px;
    height: 72px;
    object-fit: cover;
    border-radius: 8px;
    border: 1px solid var(--border);
    flex-shrink: 0;
  }

  .cf-current-img .cci-label {
    font-size: .76rem;
    font-weight: 600;
    color: var(--text-light);
    text-transform: uppercase;
    letter-spacing: .3px;
    margin-bottom: .25rem;
  }

  .cf-current-img .cci-name {
    font-size: .84rem;
    color: var(--text);
    font-weight: 500;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  /* Primary button */
  .cf-btn-primary {
    padding: .65rem 1.35rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: .84rem;
    border: 1.5px solid var(--primary);
    background: var(--primary);
    color: #fff;
    cursor: pointer;
    transition: all .12s;
    font-family: 'Inter', sans-serif;
    display: inline-flex;
    align-items: center;
    gap: .4rem;
  }

  .cf-btn-primary:hover {
    background: #4f46e5;
    border-color: #4f46e5;
    box-shadow: 0 3px 10px rgba(99,102,241,.25);
  }

  .cf-btn-primary svg {
    width: 15px;
    height: 15px;
    stroke: currentColor;
    fill: none;
    stroke-width: 2.5;
    stroke-linecap: round;
    stroke-linejoin: round;
  }

  @keyframes modalIn {
    from { opacity: 0; transform: scale(.95) translateY(8px); }
    to { opacity: 1; transform: scale(1) translateY(0); }
  }

  /* === PAGINATION === */
  .cert-pagination {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 1.25rem;
    flex-wrap: wrap;
    gap: .75rem;
  }

  .cert-pagination .pg-info {
    font-size: .8rem;
    color: var(--text-light);
  }

  .cert-pagination .pg-btns {
    display: flex;
    gap: .35rem;
    flex-wrap: wrap;
  }

  .pg-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border-radius: 8px;
    font-size: .8rem;
    color: var(--text);
    background: #fff;
    border: 1px solid var(--border);
    text-decoration: none;
    transition: all .12s;
  }

  .pg-btn:hover { background: var(--bg); }
  .pg-btn.active { color: #fff; background: var(--primary); border-color: var(--primary); font-weight: 700; }
  .pg-btn.disabled { color: var(--text-light); background: var(--bg); cursor: default; pointer-events: none; }

  /* === RESPONSIVE === */
  @media (max-width: 768px) {
    .cert-stats { grid-template-columns: 1fr; }
    .cert-toolbar { flex-direction: column; align-items: stretch; }
    .cert-search { min-width: auto; }
    .cert-list-head { display: none; }
    .cert-item { flex-wrap: wrap; gap: .65rem; padding: 1rem; }
    .ci-image { width: 100%; height: 120px; border-radius: 10px; }
    .ci-title { flex: 1 1 calc(100% - 68px); order: -1; }
    .ci-issuer { flex: none; }
    .ci-date { width: auto; }
    .ci-order { width: auto; }
    .ci-actions { opacity: 1; width: auto; }
    .cf-row { grid-template-columns: 1fr; }
    .cert-modal-lg { max-height: 95vh; margin: .5rem; }
  }
</style>

<!-- ========== STATS ========== -->
<div class="cert-stats">
  <div class="cert-stat-card">
    <div class="cs-icon blue">
      <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
    </div>
    <div class="cs-info">
      <div class="cs-label">Total Sertifikat</div>
      <div class="cs-value">{{ $totalCertificates }}</div>
    </div>
  </div>
  <div class="cert-stat-card">
    <div class="cs-icon green">
      <svg viewBox="0 0 24 24"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
    </div>
    <div class="cs-info">
      <div class="cs-label">Punya Link Verifikasi</div>
      <div class="cs-value">{{ $withUrl }}</div>
    </div>
  </div>
  <div class="cert-stat-card">
    <div class="cs-icon orange">
      <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
    </div>
    <div class="cs-info">
      <div class="cs-label">Terbaru</div>
      <div class="cs-value" style="font-size:1.15rem;">{{ $latestLabel }}</div>
    </div>
  </div>
</div>

<!-- ========== TOOLBAR ========== -->
<div class="cert-toolbar">
  <div class="cert-search">
    <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
    <input type="text" id="searchInput" placeholder="Cari judul atau penerbit sertifikat...">
  </div>
  <button type="button" class="cert-add-btn" onclick="openFormModal()">
    <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
    Tambah Sertifikat
  </button>
</div>

<!-- ========== LIST ========== -->
<div class="cert-list">
  <div class="cert-list-head">
    <div class="clh-image">Gambar</div>
    <div class="clh-title">Judul</div>
    <div class="clh-issuer">Penerbit</div>
    <div class="clh-date">Tanggal</div>
    <div class="clh-order">Urutan</div>
    <div class="clh-actions">Aksi</div>
  </div>

  <div id="certContainer">
    @if($certificates->count())
      @foreach($certificates as $cert)
        <div class="cert-item"
             data-title="{{ strtolower($cert->title) }}"
             data-issuer="{{ strtolower($cert->issuer) }}">
          <img src="{{ Storage::url($cert->image) }}" alt="{{ $cert->title }}" class="ci-image"/>
          <div class="ci-title">
            <div class="ci-title-name">{{ $cert->title }}</div>
            @if($cert->url)
            <a href="{{ $cert->url }}" target="_blank" class="ci-title-link" onclick="event.stopPropagation()">
              <svg viewBox="0 0 24 24"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
              Lihat sertifikat
            </a>
            @endif
          </div>
          <div class="ci-issuer">
            <span class="ci-issuer-badge">
              <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
              {{ $cert->issuer }}
            </span>
          </div>
         <div class="ci-date">{{ \Carbon\Carbon::parse($cert->issued_date)->format('d M Y') }}</div>
          <div class="ci-order">
            <span class="ci-order-badge">{{ $cert->sort_order }}</span>
          </div>
          <div class="ci-actions">
            <button type="button" class="ci-act-btn edit-btn" title="Edit"
                    onclick='openFormModal({{ $cert->toJson() }})'>
              <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            </button>
            <button type="button" class="ci-act-btn delete-btn" title="Hapus"
                    onclick="openDeleteModal({{ $cert->id }}, '{{ addslashes($cert->title) }}')">
              <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
            </button>
          </div>
        </div>
      @endforeach
    @else
      <div class="cert-empty">
        <div class="ce-icon">
          <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        </div>
        <h4>Belum Ada Sertifikat</h4>
        <p>Tambahkan sertifikat yang sudah kamu peroleh untuk ditampilkan di halaman portfolio.</p>
        <button type="button" class="cert-add-btn" onclick="openFormModal()" style="margin:0 auto;">
          <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
          Tambah Sertifikat
        </button>
      </div>
    @endif
  </div>

  <div class="no-results" id="noResults">
    <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><line x1="8" y1="11" x2="14" y2="11"/></svg>
    <p>Tidak ada sertifikat yang cocok</p>
  </div>
</div>

<!-- ========== PAGINATION ========== -->
@if ($certificates->hasPages())
<div class="cert-pagination">
  <span class="pg-info">Menampilkan {{ $certificates->firstItem() }}-{{ $certificates->lastItem() }} dari {{ $certificates->total() }}</span>
  <div class="pg-btns">
    @if ($certificates->onFirstPage())
      <span class="pg-btn disabled"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg></span>
    @else
      <a href="{{ $certificates->previousPageUrl() }}" class="pg-btn"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg></a>
    @endif
    @foreach ($elements as $element)
      @if (is_string($element))
        <span class="pg-btn disabled" style="pointer-events:none;border:none;">...</span>
      @elseif (is_array($element))
        @foreach ($element as $page => $url)
          @if ($page == $certificates->currentPage())
            <span class="pg-btn active">{{ $page }}</span>
          @else
            <a href="{{ $url }}" class="pg-btn">{{ $page }}</a>
          @endif
        @endforeach
      @endif
    @endforeach
    @if ($certificates->hasMorePages())
      <a href="{{ $certificates->nextPageUrl() }}" class="pg-btn"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg></a>
    @else
      <span class="pg-btn disabled"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg></span>
    @endif
  </div>
</div>
@endif


<!-- ============================================================ -->
<!-- ========== FORM MODAL (Create & Edit) ========== -->
<!-- ============================================================ -->
<div class="cert-modal-overlay" id="formModal">
  <div class="cert-modal-lg">
    <div class="cm-header">
      <h3 id="formModalTitle">Tambah Sertifikat</h3>
      <button type="button" class="cm-close" onclick="closeFormModal()">
        <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
      </button>
    </div>

    <form id="certForm" method="POST" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="_method" id="formMethod" value="POST"/>

      <div class="cm-body">
        <!-- Info section -->
        <div style="font-size:.78rem;font-weight:600;color:var(--text-light);text-transform:uppercase;letter-spacing:.5px;margin-bottom:1.25rem;padding-bottom:.75rem;border-bottom:1px solid var(--border);">Informasi Sertifikat</div>

        <div class="cf-group">
          <label class="cf-label">Judul Sertifikat <span class="cf-required">*</span></label>
          <input type="text" name="title" id="fTitle" placeholder="Misal: Belajar Fundamental Front-End Web Development" class="cf-input"/>
        </div>

        <div class="cf-group">
          <label class="cf-label">Penerbit <span class="cf-required">*</span></label>
          <input type="text" name="issuer" id="fIssuer" placeholder="Misal: Dicoding, Google, Coursera" class="cf-input"/>
        </div>

        <div class="cf-row">
          <div class="cf-group">
            <label class="cf-label">Tanggal Terbit <span class="cf-required">*</span></label>
            <input type="date" name="issued_date" id="fDate" class="cf-input"/>
          </div>
          <div class="cf-group">
            <label class="cf-label">Urutan Tampil <span class="cf-hint">kecil = duluan</span></label>
            <input type="number" name="sort_order" id="fOrder" value="0" min="0" placeholder="0" class="cf-input"/>
          </div>
        </div>

        <!-- Image section -->
        <div style="font-size:.78rem;font-weight:600;color:var(--text-light);text-transform:uppercase;letter-spacing:.5px;margin-bottom:1.25rem;padding-bottom:.75rem;border-bottom:1px solid var(--border);margin-top:.5rem;">Gambar Sertifikat</div>

        <div class="cf-current-img" id="currentImgWrap" style="display:none;">
          <img id="currentImgSrc" src="" alt=""/>
          <div>
            <div class="cci-label">Gambar Saat Ini</div>
            <div class="cci-name" id="currentImgName"></div>
          </div>
        </div>

        <div class="cf-upload" id="uploadZone" onclick="document.getElementById('fImage').click()">
          <input type="file" id="fImage" name="image" accept="image/jpeg,image/png,image/jpg,image/webp" class="hidden" onchange="handleFile(this)"/>
          <div id="uploadPlaceholder">
            <div class="cu-icon">
              <svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
            </div>
            <div class="cu-text" id="uploadText">Klik atau seret gambar ke sini</div>
            <div class="cu-hint" id="uploadHint">JPG, PNG, atau WebP — Maksimal 2MB</div>
          </div>
          <div class="cu-preview" id="uploadPreview">
            <img id="previewImg" src="" alt="Preview"/>
            <div class="cu-name" id="previewName"></div>
            <button type="button" class="cu-remove" onclick="event.stopPropagation(); clearFile()">
              <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
              Hapus gambar
            </button>
          </div>
        </div>

        <!-- Link section -->
        <div style="font-size:.78rem;font-weight:600;color:var(--text-light);text-transform:uppercase;letter-spacing:.5px;margin-bottom:1.25rem;padding-bottom:.75rem;border-bottom:1px solid var(--border);margin-top:1.25rem;">Link Verifikasi</div>

        <div class="cf-group">
          <label class="cf-label">URL Sertifikat <span class="cf-hint">opsional</span></label>
          <div class="cf-input-icon-wrap">
            <svg viewBox="0 0 24 24"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
            <input type="url" name="url" id="fUrl" placeholder="https://example.com/verify/abc123" class="cf-input"/>
          </div>
        </div>
      </div>

      <div class="cm-footer">
        <button type="button" class="cm-btn" onclick="closeFormModal()">Batal</button>
        <button type="submit" class="cf-btn-primary" id="formSubmitBtn">
          <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
          <span id="formSubmitText">Simpan Sertifikat</span>
        </button>
      </div>
    </form>
  </div>
</div>


<!-- ============================================================ -->
<!-- ========== DELETE MODAL ========== -->
<!-- ============================================================ -->
<div class="cert-modal-overlay" id="deleteModal">
  <div class="cert-modal-sm">
    <div class="cm-icon">
      <svg viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
    </div>
    <h3>Hapus Sertifikat</h3>
    <p>Yakin ingin menghapus <strong id="deleteName"></strong>? Gambar dan data terkait akan ikut terhapus.</p>
    <div class="cm-actions">
      <button class="cm-btn" onclick="closeDeleteModal()">Batal</button>
      <form id="deleteForm" method="POST">
        @csrf @method('DELETE')
        <button type="submit" class="cm-btn danger">Ya, Hapus</button>
      </form>
    </div>
  </div>
</div>


<script>
// ==========================================
// 1. CLEANUP OLD NOTIFICATIONS & INIT
// ==========================================
document.addEventListener('DOMContentLoaded', () => {
  // Aggressively remove all old/duplicate alerts including those from Layout
  const oldAlerts = document.querySelectorAll('.alert, .flash-message, [role="alert"], .cert-flash, .custom-alert');
  oldAlerts.forEach(el => el.remove());

  // Clear container
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

  // Auto remove after 4.5 seconds
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
// 3. SEARCH
// ==========================================
const searchInput = document.getElementById('searchInput');
const container = document.getElementById('certContainer');
const noResults = document.getElementById('noResults');

searchInput.addEventListener('input', function () {
  const q = this.value.toLowerCase().trim();
  const items = container.querySelectorAll('.cert-item');
  let visible = 0;
  items.forEach(item => {
    const t = item.dataset.title || '';
    const i = item.dataset.issuer || '';
    const match = !q || t.includes(q) || i.includes(q);
    item.style.display = match ? '' : 'none';
    if (match) visible++;
  });
  noResults.style.display = visible === 0 && container.querySelector('.cert-item') ? 'block' : 'none';
});

// ==========================================
// 4. FORM MODAL
// ==========================================
const formModal = document.getElementById('formModal');
const certForm = document.getElementById('certForm');
const formMethod = document.getElementById('formMethod');
const formModalTitle = document.getElementById('formModalTitle');
const formSubmitText = document.getElementById('formSubmitText');
const uploadZone = document.getElementById('uploadZone');
const fileInput = document.getElementById('fImage');
let isEdit = false;

function openFormModal(data) {
  // Reset form
  certForm.reset();
  clearFile();
  document.getElementById('currentImgWrap').style.display = 'none';
  fileInput.required = true;
  document.getElementById('uploadText').textContent = 'Klik atau seret gambar ke sini';
  document.getElementById('uploadHint').textContent = 'JPG, PNG, atau WebP — Maksimal 2MB';

  if (data && data.id) {
    // EDIT mode
    isEdit = true;
    formModalTitle.textContent = 'Edit Sertifikat';
    formSubmitText.textContent = 'Perbarui Sertifikat';
    formMethod.value = 'PUT';
    certForm.action = '{{ route("admin.certificates.update", ":id") }}'.replace(':id', data.id);

    document.getElementById('fTitle').value = data.title || '';
    document.getElementById('fIssuer').value = data.issuer || '';
    document.getElementById('fDate').value = data.issued_date || '';
    document.getElementById('fOrder').value = data.sort_order || 0;
    document.getElementById('fUrl').value = data.url || '';

    if (data.image) {
      document.getElementById('currentImgSrc').src = '{{ Storage::url("") }}' + data.image;
      document.getElementById('currentImgName').textContent = data.image.split('/').pop();
      document.getElementById('currentImgWrap').style.display = 'flex';
      fileInput.required = false;
      document.getElementById('uploadText').textContent = 'Klik untuk ganti gambar';
      document.getElementById('uploadHint').textContent = 'Kosongkan jika tidak ingin mengubah';
    }
  } else {
    // CREATE mode
    isEdit = false;
    formModalTitle.textContent = 'Tambah Sertifikat';
    formSubmitText.textContent = 'Simpan Sertifikat';
    formMethod.value = 'POST';
    certForm.action = '{{ route("admin.certificates.store") }}';
    document.getElementById('fOrder').value = 0;
  }

  formModal.classList.add('show');
  document.body.style.overflow = 'hidden';
}

function closeFormModal() {
  formModal.classList.remove('show');
  document.body.style.overflow = '';
}

formModal.addEventListener('click', function (e) {
  if (e.target === this) closeFormModal();
});

// ==========================================
// 5. FILE UPLOAD
// ==========================================
['dragenter', 'dragover'].forEach(e => {
  uploadZone.addEventListener(e, ev => { ev.preventDefault(); uploadZone.classList.add('dragging'); });
});
['dragleave', 'drop'].forEach(e => {
  uploadZone.addEventListener(e, ev => { ev.preventDefault(); uploadZone.classList.remove('dragging'); });
});
uploadZone.addEventListener('drop', e => {
  if (e.dataTransfer.files.length) {
    fileInput.files = e.dataTransfer.files;
    handleFile(fileInput);
  }
});

function handleFile(el) {
  const file = el.files[0];
  if (!file) return;
  if (file.size > 2 * 1024 * 1024) {
    el.value = '';
    alert('Ukuran file tidak boleh melebihi 2MB.');
    return;
  }
  const reader = new FileReader();
  reader.onload = e => {
    document.getElementById('previewImg').src = e.target.result;
    document.getElementById('previewName').textContent = file.name;
    document.getElementById('uploadPlaceholder').style.display = 'none';
    document.getElementById('uploadPreview').style.display = 'block';
  };
  reader.readAsDataURL(file);
}

function clearFile() {
  fileInput.value = '';
  document.getElementById('previewImg').src = '';
  document.getElementById('uploadPlaceholder').style.display = '';
  document.getElementById('uploadPreview').style.display = 'none';
}

// ==========================================
// 6. DELETE MODAL
// ==========================================
const deleteModal = document.getElementById('deleteModal');

function openDeleteModal(id, name) {
  document.getElementById('deleteName').textContent = name;
  document.getElementById('deleteForm').action = '{{ route("admin.certificates.destroy", ":id") }}'.replace(':id', id);
  deleteModal.classList.add('show');
  document.body.style.overflow = 'hidden';
}

function closeDeleteModal() {
  deleteModal.classList.remove('show');
  document.body.style.overflow = '';
}

deleteModal.addEventListener('click', function (e) {
  if (e.target === this) closeDeleteModal();
});

// ESC close all modals
document.addEventListener('keydown', function (e) {
  if (e.key === 'Escape') {
    closeFormModal();
    closeDeleteModal();
  }
});

// ==========================================
// 7. FORM SUBMISSIONS & LOADING STATES
// ==========================================
const submitBtn = document.getElementById('formSubmitBtn');
const deleteForm = document.getElementById('deleteForm');
const deleteBtn = deleteForm.querySelector('button[type="submit"]');

if (certForm) {
  certForm.addEventListener('submit', function() {
    if(submitBtn) submitBtn.classList.add('btn-loading');
  });
}

if (deleteForm) {
  deleteForm.addEventListener('submit', function() {
    if(deleteBtn) deleteBtn.classList.add('btn-loading');
  });
}
</script>
@endsection