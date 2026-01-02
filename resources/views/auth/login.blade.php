@extends('auth.layouts.auth')

@section('title', 'Login')

@section('content')
  <div class="auth-card">
    <div class="auth-brand">
      <img src="{{ asset('backend/assets/img/logo.svg') }}" alt="Logo" />
      <div>
        <h1>Admin PSB</h1>
        <p>Masuk untuk mengelola pendaftaran santri baru.</p>
      </div>
    </div>

    {{-- Alert error global --}}
    @if ($errors->any())
      <div class="auth-alert">
        <strong>Login gagal.</strong>
        <div style="margin-top:6px;">
          @foreach ($errors->all() as $error)
            <div>• {{ $error }}</div>
          @endforeach
        </div>
      </div>
    @endif

    <form method="POST" action="{{ route('login.authenticate') }}" class="auth-form">
      @csrf

      <label class="auth-label" for="email">Email</label>
      <div class="auth-field">
        <input
          id="email"
          type="email"
          name="email"
          value="{{ old('email') }}"
          placeholder="contoh: admin@pondok.id"
          required
          autofocus
        />
      </div>

      <label class="auth-label" for="password" style="margin-top:12px;">Password</label>
      <div class="auth-field" style="position:relative;">
        <input
          id="password"
          type="password"
          name="password"
          placeholder="Masukkan password"
          required
        />
        <button type="button" class="auth-toggle" data-toggle-password="#password" title="Lihat/Sembunyikan">
          👁
        </button>
      </div>

      <div class="auth-row">
        <label class="auth-check">
          <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
          <span>Ingat saya</span>
        </label>

        @if (Route::has('password.request'))
          <a class="auth-link" href="{{ route('password.request') }}">Lupa password?</a>
        @endif
      </div>

      <button type="submit" class="btn primary" style="width:100%; justify-content:center; margin-top:12px;">
        Masuk
      </button>

      <div class="auth-note">
        <span>© {{ date('Y') }} PSB DARUSSALAM AL-HAFIDZ</span>
      </div>
    </form>
  </div>

  @push('scripts')
  <script>
    // Toggle password show/hide
    document.querySelectorAll('[data-toggle-password]').forEach(btn => {
      btn.addEventListener('click', () => {
        const target = btn.getAttribute('data-toggle-password');
        const input = document.querySelector(target);
        if (!input) return;
        input.type = input.type === 'password' ? 'text' : 'password';
      });
    });
  </script>
  @endpush
@endsection
