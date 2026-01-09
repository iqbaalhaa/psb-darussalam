<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>@yield('title', 'Admin Panel') — PSB DARUSSALAM AL-HAFIDZ</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="{{ asset('backend/assets/css/admin.css') }}" />
  <link rel="stylesheet" href="{{ asset('backend/assets/css/admin-style.css') }}" />
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


<script src="{{ asset('backend/assets/js/admin.js') }}"></script>
@stack('scripts')
</body>
</html>
