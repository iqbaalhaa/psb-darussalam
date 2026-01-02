<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>@yield('title', 'Admin Panel') — PSB DARUSSALAM AL-HAFIDZ</title>

  <link rel="stylesheet" href="{{ asset('backend/assets/css/admin.css') }}" />
  @stack('styles')
</head>
<body>

<div class="container">

  {{-- Sidebar --}}
  @include('admin.partials.sidebar')

  {{-- Content --}}
  <section class="content">

    {{-- Mobile backdrop --}}
    <div data-sidebar-backdrop
      style="display:none; position:fixed; inset:0; background:rgba(2,6,23,.45); z-index:55"></div>

    {{-- Header / Topbar --}}
    @include('admin.partials.header')

    {{-- Main Content --}}
    <main class="main">
      @yield('content')
    </main>

    {{-- Footer --}}
    @include('admin.partials.footer')
  </section>

</div>

{{-- Global Modal (optional - bisa dipakai untuk detail pendaftar) --}}
<div class="modal-backdrop">
  <div class="modal" role="dialog" aria-modal="true">
    <header>
      <strong data-modal-title>Detail</strong>
      <button class="icon-btn" data-close-modal title="Tutup">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
          <path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        </svg>
      </button>
    </header>
    <div class="body" data-modal-body>...</div>
    <div class="footer">
      <button class="btn" data-close-modal type="button">Tutup</button>
    </div>
  </div>
</div>

<script src="{{ asset('backend/assets/js/admin.js') }}"></script>
@stack('scripts')
</body>
</html>
