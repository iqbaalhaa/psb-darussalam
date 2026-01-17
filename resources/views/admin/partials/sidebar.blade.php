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
                <path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
            </svg>
        </button>
    </div>

    <nav class="nav">
        <div class="section">Menu</div>

        <a class="{{ $isActive('admin.dashboard') }}" href="{{ route('admin.dashboard') }}">
            <span class="icon">
                <i class="fa-solid fa-gauge-high"></i>
            </span>
            Dashboard
        </a>

        <a class="{{ $isActive('admin.pendaftar.index') }}" href="{{ route('admin.pendaftar.index') }}">
            <span class="icon">
                <i class="fa-solid fa-users"></i>
            </span>
            Data Pendaftar
            {{-- <span class="badge-pill">{{ $pendingCount ?? 12 }}</span> --}}
        </a>

        <a class="{{ $isActive('admin.tahun.index') }}" href="{{ route('admin.tahun.index') }}">
            <span class="icon">
                <i class="fa-solid fa-calendar-days"></i>
            </span>
            Tahun Ajaran
        </a>

        <a class="{{ $isActive('admin.pengumuman.index') }}" href="{{ route('admin.pengumuman.index') }}">
            <span class="icon">
                <i class="fa-solid fa-bullhorn"></i>
            </span>
            Pengumuman
        </a>

        <a class="{{ $isActive('admin.laporan.index') }}" href="{{ route('admin.laporan.index') }}">
            <span class="icon">
                <i class="fa-solid fa-file-lines"></i>
            </span>
            Laporan
        </a>

        <div class="section">Pengaturan</div>

        <a class="{{ $isActive('admin.home-settings.edit') }}" href="{{ route('admin.home-settings.edit') }}">
            <span class="icon">
                <i class="fa-solid fa-user-gear"></i>
            </span>
            (HOME) Content Management System
        </a>

        <a class="{{ $isActive('admin.akun.index') }}" href="{{ route('admin.akun.index') }}">
            <span class="icon">
                <i class="fa-solid fa-user-gear"></i>
            </span>
            Akun & Role
        </a>

        {{-- Logout: nanti sesuaikan dengan auth yang kamu pakai --}}
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <span class="icon">
                <i class="fa-solid fa-right-from-bracket"></i>
            </span>
            Logout
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
            @csrf
        </form>
    </nav>
</aside>
