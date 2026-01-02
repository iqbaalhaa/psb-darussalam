@php
  $isActive = fn($name) => request()->routeIs($name) ? 'active' : '';
@endphp

<aside class="sidebar">
  <div class="brand">
    <img src="{{ asset('backend/assets/img/logo.svg') }}" alt="Logo">
    <div class="title">
      <strong>PSB Darussalam Al-Hafidz</strong>
      <span>Admin Panel</span>
    </div>

    {{-- tombol close (mobile) --}}
    <button class="icon-btn" style="margin-left:auto" data-close-sidebar title="Tutup sidebar">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
        <path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
      </svg>
    </button>
  </div>

  <nav class="nav">
    <div class="section">Menu</div>

    <a class="{{ $isActive('admin.dashboard') }}" href="{{ route('admin.dashboard') }}">
      <span class="icon">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
          <path d="M4 13h7V4H4v9Zm9 7h7V11h-7v9ZM4 20h7v-5H4v5Zm9-16v5h7V4h-7Z" fill="currentColor" opacity=".9"/>
        </svg>
      </span>
      Dashboard
    </a>

    <a class="{{ $isActive('admin.pendaftar.index') }}" href="{{ route('admin.pendaftar.index') }}">
      <span class="icon">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
          <path d="M16 11c1.66 0 3-1.79 3-4s-1.34-4-3-4-3 1.79-3 4 1.34 4 3 4Zm-8 0c1.66 0 3-1.79 3-4S9.66 3 8 3 5 4.79 5 7s1.34 4 3 4Zm0 2c-2.67 0-8 1.34-8 4v2h10v-2c0-1.03.39-1.93 1.03-2.68C10.06 13.53 8.94 13 8 13Zm8 0c-.94 0-2.06.53-3.03 1.32C13.61 15.07 14 15.97 14 17v2h10v-2c0-2.66-5.33-4-8-4Z" fill="currentColor" opacity=".9"/>
        </svg>
      </span>
      Data Pendaftar
      <span class="badge-pill">{{ $pendingCount ?? 12 }}</span>
    </a>

    <a class="{{ $isActive('admin.pengumuman.index') }}" href="{{ route('admin.pengumuman.index') }}">
      <span class="icon">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
          <path d="M3 11v2c0 .55.45 1 1 1h1l3 4h2l-3-4h2l10 3V7L9 10H4c-.55 0-1 .45-1 1Z" fill="currentColor" opacity=".9"/>
        </svg>
      </span>
      Pengumuman
    </a>

    <a class="{{ $isActive('admin.laporan.index') }}" href="{{ route('admin.laporan.index') }}">
      <span class="icon">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
          <path d="M7 2h10l4 4v16a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2Zm9 1v4h4" fill="currentColor" opacity=".9"/>
          <path d="M8 12h8M8 16h8M8 8h5" stroke="currentColor" stroke-width="2" stroke-linecap="round" opacity=".6"/>
        </svg>
      </span>
      Laporan
    </a>

    <div class="section">Pengaturan</div>

    <a class="{{ $isActive('admin.akun.index') }}" href="{{ route('admin.akun.index') }}">
      <span class="icon">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
          <path d="M12 2 20 6v6c0 5-3.4 9.4-8 10-4.6-.6-8-5-8-10V6l8-4Z" fill="currentColor" opacity=".9"/>
        </svg>
      </span>
      Akun & Role
    </a>

    {{-- Logout: nanti sesuaikan dengan auth yang kamu pakai --}}
    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
      <span class="icon">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
          <path d="M10 17v2a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
          <path d="M15 12H7" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
          <path d="M15 12l-3-3m3 3-3 3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M22 12h-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" opacity=".45"/>
        </svg>
      </span>
      Logout
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
      @csrf
    </form>
  </nav>
</aside>
