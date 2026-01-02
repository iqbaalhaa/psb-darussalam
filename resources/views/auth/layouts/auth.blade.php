<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>@yield('title', 'Login') — PSB DARUSSALAM AL-HAFIDZ</title>

  {{-- Pakai CSS admin biar style konsisten --}}
  <link rel="stylesheet" href="{{ asset('backend/assets/css/admin.css') }}" />
  @stack('styles')
</head>
<body>

  <main class="auth-wrap">
    @yield('content')
  </main>

  <script src="{{ asset('backend/assets/js/admin.js') }}"></script>
  @stack('scripts')
</body>
</html>
