@extends('admin.layout')

@section('title', 'Detail Pesan')
@section('pageTitle', 'Detail Pesan')

@section('content')
<style>
  /* === BACK NAV === */
  .back-nav {
    display: flex;
    align-items: center;
    gap: .75rem;
    margin-bottom: 1.5rem;
  }

  .back-link {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    font-size: .85rem;
    font-weight: 500;
    color: var(--text-light);
    text-decoration: none;
    padding: .4rem .75rem;
    border-radius: 8px;
    transition: all .15s;
  }

  .back-link:hover {
    background: var(--bg);
    color: var(--text);
  }

  .back-link svg {
    width: 16px;
    height: 16px;
    stroke: currentColor;
    fill: none;
    stroke-width: 2;
    stroke-linecap: round;
    stroke-linejoin: round;
  }

  .back-sep {
    width: 1px;
    height: 20px;
    background: var(--border);
  }

  .back-title {
    font-size: .85rem;
    color: var(--text-light);
  }

  /* === DETAIL LAYOUT === */
  .detail-layout {
    display: grid;
    grid-template-columns: 340px 1fr;
    gap: 1.5rem;
    align-items: start;
  }

  /* === SENDER CARD === */
  .sender-card {
    background: var(--bg-card);
    border-radius: 16px;
    border: 1px solid var(--border);
    overflow: hidden;
    position: sticky;
    top: 80px;
  }

  .sender-avatar-area {
    height: 120px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: flex-end;
    justify-content: center;
    padding-bottom: 0;
    position: relative;
  }

  .sender-avatar-area .status-indicator {
    position: absolute;
    top: .75rem;
    right: .75rem;
    font-size: .72rem;
    font-weight: 600;
    padding: .25rem .65rem;
    border-radius: 50px;
    backdrop-filter: blur(6px);
  }

  .status-indicator.read-si {
    background: rgba(255,255,255,.2);
    color: #fff;
  }

  .status-indicator.new-si {
    background: rgba(255,255,255,.25);
    color: #fff;
    display: flex;
    align-items: center;
    gap: .3rem;
  }

  .status-indicator.new-si .pulse-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #fbbf24;
    animation: pulse 2s ease-in-out infinite;
  }

  @keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: .3; }
  }

  .sender-avatar-img {
    width: 72px;
    height: 72px;
    border-radius: 16px;
    background: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 1.75rem;
    color: var(--primary);
    transform: translateY(36px);
    box-shadow: 0 4px 15px rgba(0,0,0,.1);
  }

  .sender-body {
    padding: 2.5rem 1.5rem 1.5rem;
    text-align: center;
  }

  .sender-name {
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--text);
    margin-bottom: .35rem;
  }

  .sender-email {
    font-size: .85rem;
    color: var(--primary);
    text-decoration: none;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: .3rem;
    margin-bottom: 1.25rem;
  }

  .sender-email:hover { text-decoration: underline; }

  .sender-email svg {
    width: 14px;
    height: 14px;
    stroke: var(--primary);
    fill: none;
    stroke-width: 2;
    stroke-linecap: round;
    stroke-linejoin: round;
  }

  .sender-divider {
    height: 1px;
    background: var(--border);
    margin-bottom: 1.25rem;
  }

  .sender-meta {
    display: flex;
    flex-direction: column;
    gap: .75rem;
    text-align: left;
  }

  .sm-item {
    display: flex;
    align-items: flex-start;
    gap: .6rem;
    font-size: .82rem;
    color: var(--text-light);
  }

  .sm-item svg {
    width: 16px;
    height: 16px;
    stroke: #94a3b8;
    fill: none;
    stroke-width: 2;
    stroke-linecap: round;
    stroke-linejoin: round;
    flex-shrink: 0;
    margin-top: 1px;
  }

  .sm-item strong {
    color: var(--text);
    font-weight: 600;
  }

  .sender-actions {
    padding: 0 1.5rem 1.5rem;
    display: flex;
    flex-direction: column;
    gap: .5rem;
  }

  .sa-btn {
    padding: .65rem 1rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: .85rem;
    border: none;
    cursor: pointer;
    transition: all .15s;
    font-family: 'Inter', sans-serif;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: .5rem;
    text-decoration: none;
  }

  .sa-btn svg {
    width: 16px;
    height: 16px;
    fill: none;
    stroke-width: 2;
    stroke-linecap: round;
    stroke-linejoin: round;
  }

  .sa-email {
    background: #fff;
    color: var(--text);
    border: 1.5px solid var(--border);
  }

  .sa-email:hover {
    background: var(--bg);
    border-color: #c7d2fe;
    color: var(--primary);
  }

  .sa-email svg { stroke: var(--text); }

  /* === MESSAGE CARD === */
  .message-card {
    background: var(--bg-card);
    border-radius: 16px;
    border: 1px solid var(--border);
    overflow: hidden;
  }

  .msg-card-header {
    padding: 1.25rem 1.75rem;
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: var(--bg);
  }

  .msg-card-header .mch-left {
    display: flex;
    align-items: center;
    gap: .6rem;
  }

  .msg-card-header .mch-icon {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    background: #eef2ff;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .msg-card-header .mch-icon svg {
    width: 16px;
    height: 16px;
    stroke: #6366f1;
    fill: none;
    stroke-width: 2;
    stroke-linecap: round;
    stroke-linejoin: round;
  }

  .msg-card-header .mch-label {
    font-size: .9rem;
    font-weight: 600;
  }

  .msg-card-header .mch-time {
    font-size: .8rem;
    color: var(--text-light);
    display: flex;
    align-items: center;
    gap: .35rem;
  }

  .msg-card-header .mch-time svg {
    width: 14px;
    height: 14px;
    stroke: var(--text-light);
    fill: none;
    stroke-width: 2;
    stroke-linecap: round;
    stroke-linejoin: round;
  }

  .msg-card-body {
    padding: 2rem 1.75rem;
  }

  .msg-bubble {
    background: var(--bg);
    border-radius: 16px;
    border-top-left-radius: 4px;
    padding: 1.5rem;
    font-size: .95rem;
    line-height: 1.8;
    color: var(--text);
    position: relative;
  }

  .msg-bubble::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    border-radius: 16px 0 0 16px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  }

  .msg-card-footer {
    padding: 1rem 1.75rem;
    border-top: 1px solid var(--border);
    display: flex;
    justify-content: flex-end;
    gap: .6rem;
    background: var(--bg);
  }

  .footer-btn {
    padding: .5rem 1rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: .82rem;
    border: 1px solid var(--border);
    background: #fff;
    color: var(--text);
    cursor: pointer;
    transition: all .15s;
    font-family: 'Inter', sans-serif;
    display: inline-flex;
    align-items: center;
    gap: .35rem;
    text-decoration: none;
  }

  .footer-btn svg {
    width: 14px;
    height: 14px;
    stroke: currentColor;
    fill: none;
    stroke-width: 2;
    stroke-linecap: round;
    stroke-linejoin: round;
  }

  .footer-btn:hover { background: var(--bg); }

  .footer-btn.fb-delete:hover {
    background: #fef2f2;
    border-color: #fca5a5;
    color: #ef4444;
  }

  /* === RESPONSIVE === */
  @media (max-width: 900px) {
    .detail-layout {
      grid-template-columns: 1fr;
    }
    .sender-card {
      position: static;
    }
    .sender-avatar-area { height: 100px; }
    .sender-avatar-img {
      width: 64px;
      height: 64px;
      font-size: 1.5rem;
      transform: translateY(32px);
    }
    .sender-body { padding-top: 2rem; }
  }
</style>

<!-- BACK NAV -->
<div class="back-nav">
  <a href="{{ route('admin.contacts') }}" class="back-link">
    <svg viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
    Kembali
  </a>
  <div class="back-sep"></div>
  <span class="back-title">Detail Pesan dari {{ $contact->nama }}</span>
</div>

<div class="detail-layout">
  <!-- === SENDER CARD === -->
  <div class="sender-card">
    <div class="sender-avatar-area">
      @if($contact->is_read)
        <div class="status-indicator read-si">Dibaca</div>
      @else
        <div class="status-indicator new-si">
          <span class="pulse-dot"></span>
          Baru
        </div>
      @endif
      <div class="sender-avatar-img">
        {{ strtoupper(substr($contact->nama, 0, 1)) }}
      </div>
    </div>

    <div class="sender-body">
      <div class="sender-name">{{ $contact->nama }}</div>
      <a href="mailto:{{ $contact->email }}" class="sender-email">
        <svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
        {{ $contact->email }}
      </a>
    </div>

    <div class="sender-meta" style="padding: 0 1.5rem;">
      <div class="sender-divider"></div>
      <div class="sm-item">
        <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        <div>
          <strong>{{ $contact->created_at->format('d F Y') }}</strong><br>
          {{ $contact->created_at->format('H:i') }} WIB
        </div>
      </div>
      <div class="sm-item">
        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        <div>{{ $contact->created_at->diffForHumans() }}</div>
      </div>
    </div>

    <div class="sender-actions">
      {{-- TOMBOL WA DIHAPUS KARENA USER TIDAK MENGINPUT NOMOR WA --}}
      
      {{-- TOMBOL EMAIL DIPERTAHANKAN DENGAN PERBAIKAN KUTIP --}}
      <a href="mailto:{{ $contact->email }}?subject=Re: Pesan dari portofolio&body={{ urlencode("Halo " . addslashes($contact->nama) . ",\n\nTerima kasih telah menghubungi saya.\n\n") }}" class="sa-btn sa-email">
        <svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
        Balas via Email
      </a>
    </div>
  </div>

  <!-- === MESSAGE CARD === -->
  <div class="message-card">
    <div class="msg-card-header">
      <div class="mch-left">
        <div class="mch-icon">
          <svg viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
        </div>
        <span class="mch-label">Isi Pesan</span>
      </div>
      <div class="mch-time">
        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        {{ $contact->created_at->format('H:i') }}
      </div>
    </div>

    <div class="msg-card-body">
      <div class="msg-bubble">
        {{ nl2br(e($contact->pesan)) }}
      </div>
    </div>

    <div class="msg-card-footer">
      <a href="{{ route('admin.contacts') }}" class="footer-btn">
        <svg viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        Kembali
      </a>
      <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" onsubmit="return confirm('Hapus pesan ini? Tindakan ini tidak bisa dibatalkan.')">
        @csrf @method('DELETE')
        <button type="submit" class="footer-btn fb-delete">
          <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
          Hapus Pesan
        </button>
      </form>
    </div>
  </div>
</div>

@endsection