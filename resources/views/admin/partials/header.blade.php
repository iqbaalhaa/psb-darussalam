<header class="topbar">
  <div class="left">
    <button class="hamburger" data-toggle-sidebar title="Menu">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
        <path d="M4 6h16M4 12h16M4 18h16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
      </svg>
    </button>

    <div class="search" title="Cari (Ctrl+K)">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
        <path d="M21 21l-4.3-4.3m1.3-5.2a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
      </svg>
      <input type="text" placeholder="Cari pendaftar / NISN / status..." />
      <span class="k">Ctrl K</span>
    </div>
  </div>

  <div class="right">
    <button class="icon-btn" data-toggle-theme title="Toggle Theme">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
        <path d="M21 12.8A8.5 8.5 0 0 1 11.2 3 7 7 0 1 0 21 12.8Z" fill="currentColor" opacity=".9"/>
      </svg>
    </button>

    <button class="icon-btn" title="Notifikasi" onclick="alert('Notifikasi dummy')">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
        <path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 7h18s-3 0-3-7Z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        <path d="M13.73 21a2 2 0 0 1-3.46 0" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
      </svg>
    </button>

    <div class="avatar">
      <span class="dot"></span>
      <div class="meta">
        <strong>{{ auth()->user()->name ?? 'Admin' }}</strong>
        <span>PSB {{ date('Y') }}/{{ date('Y')+1 }}</span>
      </div>
    </div>
  </div>
</header>
