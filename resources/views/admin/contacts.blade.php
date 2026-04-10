@extends('admin.layout')

@section('title', 'Pesan')
@section('pageTitle', 'Pesan Masuk')

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
    border: 2px solid rgba(0,0,0,0.3);
    border-radius: 50%;
    border-top-color: currentColor;
    animation: spin 0.8s linear infinite;
    transform: translate(-50%, -50%);
  }
  
  /* Override spinner color for white buttons (Delete) */
  .btn-loading.btn-danger-spinner::after {
     border-color: rgba(239, 68, 68, 0.3);
     border-top-color: #ef4444;
  }

  @keyframes spin { to { transform: translate(-50%, -50%) rotate(360deg); } }

  /* ===============================
     DELETE CONFIRMATION MODAL STYLES
     =============================== */
  .modal-overlay {
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

  .modal-overlay.show { display: flex; }

  .modal-sm {
    background: var(--bg-card);
    border-radius: 16px;
    border: 1px solid var(--border);
    width: 100%;
    max-width: 400px;
    padding: 2rem;
    box-shadow: 0 20px 60px rgba(0,0,0,.15);
    animation: modalIn .25s ease;
  }

  .modal-sm .mm-icon {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    background: #fef2f2;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.15rem;
  }

  .modal-sm .mm-icon svg {
    width: 24px;
    height: 24px;
    stroke: #ef4444;
    fill: none;
    stroke-width: 2;
    stroke-linecap: round;
    stroke-linejoin: round;
  }

  .modal-sm h3 {
    font-size: 1.05rem;
    font-weight: 700;
    text-align: center;
    color: var(--text);
    margin-bottom: .5rem;
  }

  .modal-sm p {
    font-size: .85rem;
    color: var(--text-light);
    text-align: center;
    line-height: 1.6;
    margin-bottom: 1.5rem;
  }

  .modal-sm p strong { color: var(--text); }

  .modal-actions {
    display: flex;
    gap: .6rem;
  }

  .modal-btn {
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
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .modal-btn:hover { background: var(--bg); }

  .modal-btn.danger {
    background: #ef4444;
    border-color: #ef4444;
    color: #fff;
  }

  .modal-btn.danger:hover { background: #dc2626; border-color: #dc2626; }

  @keyframes modalIn {
    from { opacity: 0; transform: scale(.95) translateY(8px); }
    to { opacity: 1; transform: scale(1) translateY(0); }
  }

  /* ===============================
     ORIGINAL STYLES (Preserved)
     =============================== */
  /* === STATS BAR === */
  .msg-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
    margin-bottom: 1.5rem;
  }

  .msg-stat-card {
    background: var(--bg-card);
    border-radius: 14px;
    border: 1px solid var(--border);
    padding: 1.25rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: all .2s;
  }

  .msg-stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,.06);
  }

  .ms-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }

  .ms-icon svg {
    width: 20px;
    height: 20px;
    stroke-width: 2;
    stroke-linecap: round;
    stroke-linejoin: round;
    fill: none;
  }

  .ms-icon.blue { background: #eef2ff; }
  .ms-icon.blue svg { stroke: #6366f1; }
  .ms-icon.green { background: #ecfdf5; }
  .ms-icon.green svg { stroke: #10b981; }
  .ms-icon.orange { background: #fff7ed; }
  .ms-icon.orange svg { stroke: #f59e0b; }

  .ms-info .ms-label {
    font-size: .78rem;
    color: var(--text-light);
    font-weight: 500;
    margin-bottom: .15rem;
  }

  .ms-info .ms-value {
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--text);
    line-height: 1;
  }

  /* === TOOLBAR === */
  .msg-toolbar {
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

  .msg-search {
    flex: 1;
    min-width: 200px;
    position: relative;
  }

  .msg-search svg {
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

  .msg-search input {
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

  .msg-search input:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(99,102,241,.1);
  }

  .msg-filter-btn {
    padding: .6rem 1rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: .82rem;
    border: 1.5px solid var(--border);
    background: #fff;
    color: var(--text);
    cursor: pointer;
    transition: all .15s;
    font-family: 'Inter', sans-serif;
    display: inline-flex;
    align-items: center;
    gap: .35rem;
  }

  .msg-filter-btn:hover {
    border-color: var(--primary);
    color: var(--primary);
    background: #fafaff;
  }

  .msg-filter-btn.active {
    border-color: var(--primary);
    background: var(--primary);
    color: #fff;
  }

  .msg-filter-btn svg {
    width: 14px;
    height: 14px;
    stroke: currentColor;
    fill: none;
    stroke-width: 2;
    stroke-linecap: round;
    stroke-linejoin: round;
  }

  .msg-filter-btn .filter-count {
    font-size: .7rem;
    padding: .1rem .4rem;
    border-radius: 50px;
    background: rgba(255,255,255,.3);
    line-height: 1.2;
  }

  .msg-filter-btn.active .filter-count {
    background: rgba(255,255,255,.25);
  }

  .msg-bulk-delete {
    padding: .6rem 1rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: .82rem;
    border: 1.5px solid #fecaca;
    background: #fff;
    color: #ef4444;
    cursor: pointer;
    transition: all .15s;
    font-family: 'Inter', sans-serif;
    display: none;
    align-items: center;
    gap: .35rem;
  }

  .msg-bulk-delete.show { display: inline-flex; }

  .msg-bulk-delete:hover {
    background: #fef2f2;
  }

  .msg-bulk-delete svg {
    width: 14px;
    height: 14px;
    stroke: currentColor;
    fill: none;
    stroke-width: 2;
    stroke-linecap: round;
    stroke-linejoin: round;
  }

  /* === MESSAGE LIST === */
  .msg-list {
    background: var(--bg-card);
    border-radius: 14px;
    border: 1px solid var(--border);
    overflow: hidden;
  }

  .msg-list-head {
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

  .mlh-sender { flex: 1; }
  .mlh-message { flex: 2; }
  .mlh-date { width: 100px; text-align: right; }
  .mlh-status { width: 60px; text-align: center; }

  .msg-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.15rem 1.5rem;
    border-bottom: 1px solid var(--border);
    transition: background .12s;
    text-decoration: none;
    color: var(--text);
    cursor: pointer;
    position: relative;
  }

  .msg-item:last-child { border-bottom: none; }
  .msg-item:hover { background: #f8fafc; }
  .msg-item.unread { background: #fffbeb; }
  .msg-item.unread:hover { background: #fef9ee; }

  .msg-item .mi-check {
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 4px;
  }

  .msg-item.unread .mi-check { background: var(--primary); }

  .mi-avatar {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: .9rem;
    flex-shrink: 0;
    color: #fff;
  }

  .mi-avatar.read { background: var(--border); color: var(--text-light); }
  .mi-avatar.unread-av { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }

  .mi-sender {
    flex: 1;
    min-width: 0;
  }

  .mi-name {
    font-size: .9rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: .5rem;
    margin-bottom: .15rem;
  }

  .mi-name .unread-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: var(--primary);
    flex-shrink: 0;
  }

  .mi-email {
    font-size: .75rem;
    color: var(--text-light);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .mi-message {
    flex: 2;
    min-width: 0;
    font-size: .85rem;
    color: var(--text-light);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    line-height: 1.4;
  }

  .mi-date {
    width: 100px;
    text-align: right;
    font-size: .78rem;
    color: var(--text-light);
    white-space: nowrap;
    flex-shrink: 0;
  }

  .mi-status {
    width: 60px;
    text-align: center;
    flex-shrink: 0;
  }

  .mi-status .status-badge {
    display: inline-flex;
    align-items: center;
    gap: .3rem;
    font-size: .72rem;
    font-weight: 600;
    padding: .2rem .55rem;
    border-radius: 50px;
  }

  .mi-status .status-badge.read-badge {
    background: #f1f5f9;
    color: #64748b;
  }

  .mi-status .status-badge.new-badge {
    background: #eef2ff;
    color: #4f46e5;
  }

  .mi-status .status-badge .sb-dot {
    width: 5px;
    height: 5px;
    border-radius: 50%;
  }

  .mi-status .status-badge.read-badge .sb-dot { background: #94a3b8; }
  .mi-status .status-badge.new-badge .sb-dot { background: #6366f1; }

  .mi-actions {
    display: flex;
    gap: .35rem;
    opacity: 0;
    transition: opacity .15s;
  }

  .msg-item:hover .mi-actions { opacity: 1; }

  .mi-act-btn {
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

  .mi-act-btn:hover {
    background: var(--bg);
  }

  .mi-act-btn.delete-btn:hover {
    background: #fef2f2;
    border-color: #fca5a5;
  }

  .mi-act-btn.delete-btn:hover svg { stroke: #ef4444; }

  .mi-act-btn svg {
    width: 14px;
    height: 14px;
    stroke: var(--text-light);
    fill: none;
    stroke-width: 2;
    stroke-linecap: round;
    stroke-linejoin: round;
  }

  /* === EMPTY STATE === */
  .msg-empty {
    text-align: center;
    padding: 5rem 2rem;
    color: var(--text-light);
  }

  .msg-empty .me-icon {
    width: 80px;
    height: 80px;
    border-radius: 20px;
    background: var(--bg);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.25rem;
  }

  .msg-empty .me-icon svg {
    width: 36px;
    height: 36px;
    stroke: var(--border);
    fill: none;
    stroke-width: 1.5;
    stroke-linecap: round;
    stroke-linejoin: round;
  }

  .msg-empty h4 {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--text);
    margin-bottom: .4rem;
  }

  .msg-empty p {
    font-size: .9rem;
    max-width: 340px;
    margin: 0 auto;
    line-height: 1.6;
  }

  /* === NO RESULTS === */
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

  /* === RESPONSIVE === */
  @media (max-width: 768px) {
    .msg-stats { grid-template-columns: 1fr; }
    .msg-toolbar { flex-direction: column; align-items: stretch; }
    .msg-search { min-width: auto; }
    .msg-list-head { display: none; }
    .msg-item { flex-wrap: wrap; gap: .5rem; }
    .mi-message { flex: 1 1 100%; order: 3; white-space: normal; -webkit-line-clamp: 2; display: -webkit-box; -webkit-box-orient: vertical; overflow: hidden; }
    .mi-date { width: auto; order: 2; }
    .mi-status { width: auto; order: 4; }
    .mi-actions { order: 5; opacity: 1; }
  }
</style>

@php
  $totalContacts = $contacts->count();
  $unreadContacts = $contacts->where('is_read', false)->count();
  $readContacts = $totalContacts - $unreadContacts;
  $todayContacts = $contacts->filter(fn($c) => $c->created_at->isToday())->count();
@endphp

<!-- ========== STATS ========== -->
<div class="msg-stats">
  <div class="msg-stat-card">
    <div class="ms-icon blue">
      <svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
    </div>
    <div class="ms-info">
      <div class="ms-label">Total Pesan</div>
      <div class="ms-value">{{ $totalContacts }}</div>
    </div>
  </div>
  <div class="msg-stat-card">
    <div class="ms-icon orange">
      <svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
    </div>
    <div class="ms-info">
      <div class="ms-label">Belum Dibaca</div>
      <div class="ms-value">{{ $unreadContacts }}</div>
    </div>
  </div>
  <div class="msg-stat-card">
    <div class="ms-icon green">
      <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
    </div>
    <div class="ms-info">
      <div class="ms-label">Hari Ini</div>
      <div class="ms-value">{{ $todayContacts }}</div>
    </div>
  </div>
</div>

<!-- ========== TOOLBAR ========== -->
<div class="msg-toolbar">
  <div class="msg-search">
    <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
    <input type="text" id="searchInput" placeholder="Cari nama atau pesan...">
  </div>
  <button class="msg-filter-btn" id="filterUnread" onclick="toggleFilter()">
    <svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
    Belum Dibaca
    <span class="filter-count" id="filterCount">{{ $unreadContacts }}</span>
  </button>
  <button class="msg-bulk-delete" id="bulkDeleteBtn" onclick="bulkDelete()">
    <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
    Hapus Semua
  </button>
</div>

<!-- ========== MESSAGE LIST ========== -->
<div class="msg-list">
  <div class="msg-list-head">
    <div class="mlh-sender">Pengirim</div>
    <div class="mlh-message">Pesan</div>
    <div class="mlh-date">Waktu</div>
    <div class="mlh-status">Status</div>
  </div>

  <div id="messageContainer">
    @if($contacts->count())
      @foreach($contacts as $c)
        <a href="{{ route('admin.contacts.show', $c) }}" class="msg-item {{ !$c->is_read ? 'unread' : '' }}" data-name="{{ strtolower($c->nama) }}" data-msg="{{ strtolower($c->pesan) }}" data-read="{{ $c->is_read ? '1' : '0' }}">
          <div class="mi-check"></div>
          <div class="mi-avatar {{ !$c->is_read ? 'unread-av' : 'read' }}">
            {{ strtoupper(substr($c->nama, 0, 1)) }}
          </div>
          <div class="mi-sender">
            <div class="mi-name">
              {{ $c->nama }}
              @if(!$c->is_read)<span class="unread-dot"></span>@endif
            </div>
            <div class="mi-email">{{ $c->email }}</div>
          </div>
          <div class="mi-message">{{ $c->pesan }}</div>
          <div class="mi-date">
            @if($c->created_at->isToday())
              {{ $c->created_at->format('H:i') }}
            @elseif($c->created_at->isYesterday())
              Kemarin
            @else
              {{ $c->created_at->format('d M') }}
            @endif
          </div>
          <div class="mi-status">
            @if($c->is_read)
              <span class="status-badge read-badge"><span class="sb-dot"></span>Dibaca</span>
            @else
              <span class="status-badge new-badge"><span class="sb-dot"></span>Baru</span>
            @endif
          </div>
          <div class="mi-actions">
            <!-- Delete Button - Opens Custom Modal -->
            <button type="button" class="mi-act-btn delete-btn" title="Hapus" onclick="event.preventDefault(); event.stopPropagation(); openDeleteModal('{{ $c->id }}', '{{ addslashes($c->nama) }}')">
              <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
            </button>
          </div>
        </a>
      @endforeach
    @else
      <div class="msg-empty">
        <div class="me-icon">
          <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
        </div>
        <h4>Belum Ada Pesan</h4>
        <p>Pesan dari pengunjung portofolio akan muncul di sini. Pastikan form contact di website berfungsi dengan baik.</p>
      </div>
    @endif
  </div>

  <div class="no-results" id="noResults">
    <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><line x1="8" y1="11" x2="14" y2="11"/></svg>
    <p>Tidak ada pesan yang cocok</p>
  </div>
</div>

<!-- ============================================================ -->
<!-- ========== DELETE CONFIRMATION MODAL ========== -->
<!-- ============================================================ -->
<div class="modal-overlay" id="deleteConfirmModal">
  <div class="modal-sm">
    <div class="mm-icon">
      <svg viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
    </div>
    <h3>Hapus Pesan Ini?</h3>
    <p>Yakin ingin menghapus pesan dari <strong id="deleteName"></strong>? Tindakan ini tidak dapat dibatalkan.</p>
    <div class="modal-actions">
      <button class="modal-btn" onclick="closeDeleteModal()">Batal</button>
      <form id="confirmDeleteForm" method="POST" style="flex:1;">
        @csrf @method('DELETE')
        <button type="submit" class="modal-btn danger btn-danger-spinner" id="confirmDeleteBtn">
          Ya, Hapus
        </button>
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
// 3. DELETE MODAL LOGIC (Percantik Notifikasi Hapus)
// ==========================================
const deleteModal = document.getElementById('deleteConfirmModal');
const deleteForm = document.getElementById('confirmDeleteForm');
const deleteBtn = document.getElementById('confirmDeleteBtn');

function openDeleteModal(id, name) {
  document.getElementById('deleteName').textContent = name;
  deleteForm.action = '{{ route("admin.contacts.destroy", ":id") }}'.replace(':id', id);
  deleteModal.classList.add('show');
  document.body.style.overflow = 'hidden';
}

function closeDeleteModal() {
  deleteModal.classList.remove('show');
  document.body.style.overflow = '';
  // Reset button state
  if(deleteBtn) deleteBtn.classList.remove('btn-loading');
}

// Close on overlay click
deleteModal.addEventListener('click', function(e) {
  if (e.target === this) closeDeleteModal();
});

// Close on Escape
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') closeDeleteModal();
});

// Handle Form Submission with Loading
if (deleteForm) {
  deleteForm.addEventListener('submit', function() {
    if(deleteBtn) deleteBtn.classList.add('btn-loading');
  });
}

// ==========================================
// 4. SEARCH & FILTER LOGIC
// ==========================================
const searchInput = document.getElementById('searchInput');
const filterBtn = document.getElementById('filterUnread');
const bulkBtn = document.getElementById('bulkDeleteBtn');
const container = document.getElementById('messageContainer');
const noResults = document.getElementById('noResults');
const filterCount = document.getElementById('filterCount');
let filterActive = false;

function applyFilters() {
  const query = searchInput.value.toLowerCase().trim();
  const items = container.querySelectorAll('.msg-item');
  let visible = 0;

  items.forEach(item => {
    const name = item.dataset.name || '';
    const msg = item.dataset.msg || '';
    const isRead = item.dataset.read === '1';
    const matchesSearch = !query || name.includes(query) || msg.includes(query);
    const matchesFilter = !filterActive || !isRead;

    if (matchesSearch && matchesFilter) {
      item.style.display = '';
      visible++;
    } else {
      item.style.display = 'none';
    }
  });

  noResults.style.display = visible === 0 && container.querySelector('.msg-item') ? 'block' : 'none';
}

function toggleFilter() {
  filterActive = !filterActive;
  filterBtn.classList.toggle('active', filterActive);
  bulkBtn.classList.toggle('show', filterActive);
  applyFilters();
}

searchInput.addEventListener('input', applyFilters);

function bulkDelete() {
  if (confirm('Hapus semua pesan yang belum dibaca?')) { // Native confirm allowed for bulk
    const items = container.querySelectorAll('.msg-item.unread');
    if (items.length === 0) {
      alert('Tidak ada pesan yang belum dibaca.');
      return;
    }
    
    // Add loading state to bulk button
    bulkBtn.classList.add('btn-loading', 'btn-danger-spinner');
    bulkBtn.style.pointerEvents = 'none';

    let count = 0;
    items.forEach(item => {
      const form = item.querySelector('form');
      if (form) {
        form.submit();
        count++;
      }
    });
  }
}
</script>
@endsection