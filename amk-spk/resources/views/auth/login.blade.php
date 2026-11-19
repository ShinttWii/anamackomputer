<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Admin â€” aMK Panel</title>
{{-- Bootstrap Icons untuk ikon saja â€” tidak butuh Bootstrap CSS/JS --}}
<link rel="stylesheet" href="{{ asset('css/bootstrap-icons.min.css') }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap">
<style>
/* â”€â”€ Reset total â€” tidak bergantung pada CSS eksternal apapun â”€â”€ */
*, *::before, *::after {
  box-sizing: border-box;
  margin: 0; padding: 0;
}

html {
  height: 100%;
  font-size: 16px;
}

body {
  font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
  background: #172554;
  min-height: 100%;
  height: 100vh;
  /* Pastikan body sendiri centered â€” tidak pakai flex agar tidak konflik */
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 1.5rem;
  position: relative;
  overflow: hidden;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}

/* â”€â”€ Dekorasi background â”€â”€ */
body::before {
  content: '';
  position: fixed; top: -150px; right: -150px;
  width: 500px; height: 500px; border-radius: 50%;
  background: radial-gradient(circle, rgba(242,140,40,.2) 0%, transparent 65%);
  pointer-events: none;
  z-index: 0;
}
body::after {
  content: '';
  position: fixed; bottom: -120px; left: -120px;
  width: 420px; height: 420px; border-radius: 50%;
  background: radial-gradient(circle, rgba(142,202,230,.15) 0%, transparent 65%);
  pointer-events: none;
  z-index: 0;
}

/* â”€â”€ Card â”€â”€ */
.auth-card {
  background: #ffffff;
  border-radius: 20px;
  padding: 2.5rem 2.25rem;
  width: 100%;
  max-width: 420px;
  box-shadow: 0 24px 48px rgba(0,0,0,.35), 0 4px 16px rgba(0,0,0,.15);
  position: relative;
  z-index: 1;
  animation: cardIn .35s cubic-bezier(.22,.61,.36,1) both;
}

@keyframes cardIn {
  from { opacity: 0; transform: translateY(20px) scale(.96); }
  to   { opacity: 1; transform: translateY(0)    scale(1);   }
}

/* â”€â”€ Logo â”€â”€ */
.auth-logo {
  width: 54px; height: 54px;
  background: #F28C28;
  border-radius: 14px;
  display: flex; align-items: center; justify-content: center;
  color: #fff; font-size: 1.6rem;
  margin: 0 auto 1.25rem;
  box-shadow: 0 4px 16px rgba(242,140,40,.45);
}

/* â”€â”€ Judul â”€â”€ */
.auth-title {
  font-size: 1.35rem;
  font-weight: 800;
  color: #172554;
  text-align: center;
  margin-bottom: .3rem;
  letter-spacing: -.025em;
  line-height: 1.2;
}

.auth-sub {
  font-size: .83rem;
  color: #6B7280;
  text-align: center;
  line-height: 1.65;
  margin-bottom: 1.75rem;
}
.auth-sub strong { color: #F28C28; font-weight: 700; }

/* â”€â”€ Alert â”€â”€ */
.auth-alert {
  border-radius: 8px;
  border: none;
  border-left: 3px solid;
  font-size: .83rem;
  padding: .65rem .9rem;
  margin-bottom: 1.1rem;
  line-height: 1.5;
}
.auth-alert-danger  { background: #fef2f2; border-color: #ef4444; color: #b91c1c; }
.auth-alert-success { background: #f0fdf4; border-color: #22c55e; color: #15803d; }

/* â”€â”€ Form â”€â”€ */
.auth-field { margin-bottom: .9rem; }
.auth-field:last-of-type { margin-bottom: 1.25rem; }

.auth-label {
  display: block;
  font-size: .8rem;
  font-weight: 600;
  color: #374151;
  margin-bottom: .4rem;
  letter-spacing: .01em;
}

.auth-input-group {
  display: flex;
  align-items: stretch;
  border: 1.5px solid #D1D5DB;
  border-radius: 8px;
  overflow: hidden;
  background: #fff;
  transition: border-color .2s, box-shadow .2s;
}
.auth-input-group:focus-within {
  border-color: #F28C28;
  box-shadow: 0 0 0 3px rgba(242,140,40,.15);
}
.auth-input-group.is-error { border-color: #ef4444; }
.auth-input-group.is-error:focus-within { box-shadow: 0 0 0 3px rgba(239,68,68,.12); }

.auth-icon {
  display: flex; align-items: center; justify-content: center;
  width: 42px; flex-shrink: 0;
  background: #F9FAFB;
  color: #9CA3AF;
  font-size: .95rem;
  border-right: 1px solid #E5E7EB;
}

.auth-input {
  flex: 1;
  min-width: 0;
  border: none;
  outline: none;
  padding: .65rem .9rem;
  font-size: .875rem;
  font-family: inherit;
  color: #111827;
  background: transparent;
  line-height: 1.4;
}
.auth-input::placeholder { color: #9CA3AF; font-size: .875rem; }

.auth-eye {
  display: flex; align-items: center; justify-content: center;
  width: 40px; flex-shrink: 0;
  background: #F9FAFB;
  border: none;
  border-left: 1px solid #E5E7EB;
  color: #9CA3AF;
  cursor: pointer;
  font-size: .95rem;
  transition: color .15s, background .15s;
  outline: none;
}
.auth-eye:hover { color: #172554; background: #F3F4F6; }

.auth-invalid {
  display: block;
  font-size: .76rem;
  color: #ef4444;
  margin-top: .3rem;
}

/* â”€â”€ Tombol â”€â”€ */
.auth-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: .4rem;
  width: 100%;
  padding: .75rem 1rem;
  background: #F28C28;
  color: #fff;
  font-size: .9rem;
  font-weight: 700;
  font-family: inherit;
  line-height: 1;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  box-shadow: 0 2px 8px rgba(242,140,40,.35);
  transition: background .2s, transform .15s, box-shadow .2s;
  margin-top: .25rem;
  text-decoration: none;
}
.auth-btn:hover  { background: #D97706; transform: translateY(-1px); box-shadow: 0 4px 14px rgba(242,140,40,.45); }
.auth-btn:active { transform: translateY(0); }

/* â”€â”€ Link â”€â”€ */
.auth-link {
  display: block;
  text-align: center;
  font-size: .8rem;
  color: #9CA3AF;
  text-decoration: none;
  transition: color .15s;
  margin-top: .9rem;
}
.auth-link:hover { color: #F28C28; }

/* â”€â”€ Divider â”€â”€ */
.auth-divider {
  border: none;
  border-top: 1px solid #F3F4F6;
  margin: 1.2rem 0;
}

/* â”€â”€ Responsive â”€â”€ */
/* ── Responsive ── */
@media (max-width: 480px) {
  body { padding: .75rem; }
  .auth-card {
    padding: 1.5rem 1.25rem;
    border-radius: 14px;
    max-width: 340px;
  }
  .auth-logo   { width: 40px; height: 40px; font-size: 1.2rem; margin-bottom: .9rem; }
  .auth-title  { font-size: 1.05rem; }
  .auth-sub    { font-size: .75rem; margin-bottom: 1.25rem; }
  .auth-label  { font-size: .73rem; }
  .auth-input  { font-size: .8rem; padding: .55rem .8rem; }
  .auth-input::placeholder { font-size: .8rem; }
  .auth-icon   { width: 36px; font-size: .85rem; }
  .auth-eye    { width: 34px; font-size: .85rem; }
  .auth-btn    { font-size: .82rem; padding: .62rem 1rem; }
  .auth-link   { font-size: .73rem; margin-top: .7rem; }
  .auth-field  { margin-bottom: .7rem; }
  .auth-divider{ margin: .9rem 0; }
  .auth-alert  { font-size: .75rem; padding: .5rem .75rem; }
}
</style>
</head>
<body>

<div class="auth-card">

  {{-- Logo --}}
  <div class="auth-logo">
    <i class="bi bi-laptop"></i>
  </div>

  <div class="auth-title">Panel Admin</div>
  <div class="auth-sub">
    Sistem Pakar Diagnosis MacBook<br>
    <strong>anaMac Komputer (aMK)</strong>
  </div>

  {{-- Flash Messages --}}
  @if(session('error'))
    <div class="auth-alert auth-alert-danger">
      <i class="bi bi-exclamation-circle me-1"></i>{{ session('error') }}
    </div>
  @endif
  @if(session('success'))
    <div class="auth-alert auth-alert-success">
      <i class="bi bi-check-circle me-1"></i>{{ session('success') }}
    </div>
  @endif

  <form method="POST" action="{{ route('admin.login.post') }}" novalidate>
    @csrf

    {{-- Username --}}
    <div class="auth-field">
      <label class="auth-label" for="usernameInput">Username</label>
      <div class="auth-input-group @error('username') is-error @enderror">
        <div class="auth-icon"><i class="bi bi-person"></i></div>
        <input type="text"
               id="usernameInput"
               name="username"
               value="{{ old('username') }}"
               class="auth-input"
               placeholder="Masukkan username"
               autofocus
               autocomplete="username">
      </div>
      @error('username')
        <span class="auth-invalid">{{ $message }}</span>
      @enderror
    </div>

    {{-- Password --}}
    <div class="auth-field">
      <label class="auth-label" for="passwordInput">Password</label>
      <div class="auth-input-group @error('password') is-error @enderror">
        <div class="auth-icon"><i class="bi bi-lock"></i></div>
        <input type="password"
               id="passwordInput"
               name="password"
               class="auth-input"
               placeholder="Masukkan password"
               autocomplete="current-password">
        <button type="button" class="auth-eye" id="togglePwd" aria-label="Tampilkan password">
          <i class="bi bi-eye" id="eyeIcon"></i>
        </button>
      </div>
      @error('password')
        <span class="auth-invalid">{{ $message }}</span>
      @enderror
    </div>

    {{-- Tombol Masuk --}}
    <button type="submit" class="auth-btn">
      <i class="bi bi-box-arrow-in-right"></i>Masuk
    </button>

    {{-- Lupa Password --}}
    <a href="{{ route('admin.password.request') }}" class="auth-link">
      <i class="bi bi-key"></i> Lupa Password?
    </a>

  </form>

  <hr class="auth-divider">

  <a href="{{ route('beranda') }}" class="auth-link">
    <i class="bi bi-arrow-left"></i> Kembali ke Beranda
  </a>

</div>

{{-- TIDAK ada Bootstrap JS, TIDAK ada main.js, TIDAK ada style.css / admin.css --}}
<script>
(function () {
  'use strict';
  var btn   = document.getElementById('togglePwd');
  var input = document.getElementById('passwordInput');
  var icon  = document.getElementById('eyeIcon');
  if (!btn || !input) return;
  btn.addEventListener('click', function () {
    var show = (input.type === 'password');
    input.type  = show ? 'text' : 'password';
    icon.className = show ? 'bi bi-eye-slash' : 'bi bi-eye';
    btn.setAttribute('aria-label', show ? 'Sembunyikan password' : 'Tampilkan password');
  });
})();
</script>
</body>
</html>

