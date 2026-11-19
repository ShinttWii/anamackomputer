<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Password Baru â€” aMK Panel</title>
<link rel="stylesheet" href="{{ asset('css/bootstrap-icons.min.css') }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap">
<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html { height: 100%; font-size: 16px; }
body {
  font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
  background: #172554; min-height: 100%; height: 100vh;
  display: flex; flex-direction: column;
  align-items: center; justify-content: center;
  padding: 1.5rem; position: relative; overflow: hidden;
  -webkit-font-smoothing: antialiased;
}
body::before { content:''; position:fixed; top:-150px; right:-150px; width:500px; height:500px; border-radius:50%; background:radial-gradient(circle, rgba(242,140,40,.2) 0%, transparent 65%); pointer-events:none; z-index:0; }
body::after  { content:''; position:fixed; bottom:-120px; left:-120px; width:420px; height:420px; border-radius:50%; background:radial-gradient(circle, rgba(142,202,230,.15) 0%, transparent 65%); pointer-events:none; z-index:0; }

.auth-card { background:#fff; border-radius:20px; padding:2.5rem 2.25rem; width:100%; max-width:420px; box-shadow:0 24px 48px rgba(0,0,0,.35), 0 4px 16px rgba(0,0,0,.15); position:relative; z-index:1; animation:cardIn .35s cubic-bezier(.22,.61,.36,1) both; }
@keyframes cardIn { from{opacity:0;transform:translateY(20px) scale(.96);} to{opacity:1;transform:translateY(0) scale(1);} }

.auth-logo { width:54px; height:54px; background:#16a34a; border-radius:14px; display:flex; align-items:center; justify-content:center; color:#fff; font-size:1.6rem; margin:0 auto 1.25rem; box-shadow:0 4px 16px rgba(22,163,74,.4); }
.auth-title { font-size:1.35rem; font-weight:800; color:#172554; text-align:center; margin-bottom:.3rem; letter-spacing:-.025em; }
.auth-sub { font-size:.84rem; color:#6B7280; text-align:center; margin-bottom:1.5rem; line-height:1.6; }

.auth-alert { border-radius:8px; border:none; border-left:3px solid; font-size:.83rem; padding:.65rem .9rem; margin-bottom:1rem; }
.auth-alert-danger { background:#fef2f2; border-color:#ef4444; color:#b91c1c; }

.auth-field { margin-bottom:.9rem; }
.auth-field:last-of-type { margin-bottom:1.25rem; }
.auth-label { display:block; font-size:.8rem; font-weight:600; color:#374151; margin-bottom:.4rem; }
.auth-hint  { font-size:.75rem; color:#9CA3AF; margin-top:.3rem; }
.auth-invalid { display:block; font-size:.76rem; color:#ef4444; margin-top:.3rem; }

.auth-input-group { display:flex; align-items:stretch; border:1.5px solid #D1D5DB; border-radius:8px; overflow:hidden; background:#fff; transition:border-color .2s, box-shadow .2s; }
.auth-input-group:focus-within { border-color:#F28C28; box-shadow:0 0 0 3px rgba(242,140,40,.15); }
.auth-icon { display:flex; align-items:center; justify-content:center; width:42px; flex-shrink:0; background:#F9FAFB; color:#9CA3AF; font-size:.95rem; border-right:1px solid #E5E7EB; }
.auth-input { flex:1; min-width:0; border:none; outline:none; padding:.65rem .9rem; font-size:.875rem; font-family:inherit; color:#111827; background:transparent; }
.auth-input::placeholder { color:#9CA3AF; }
.auth-eye { display:flex; align-items:center; justify-content:center; width:40px; flex-shrink:0; background:#F9FAFB; border:none; border-left:1px solid #E5E7EB; color:#9CA3AF; cursor:pointer; font-size:.95rem; transition:color .15s, background .15s; outline:none; }
.auth-eye:hover { color:#172554; background:#F3F4F6; }

.auth-btn { display:flex; align-items:center; justify-content:center; gap:.4rem; width:100%; padding:.75rem 1rem; background:#16a34a; color:#fff; font-size:.9rem; font-weight:700; font-family:inherit; border:none; border-radius:8px; cursor:pointer; box-shadow:0 2px 8px rgba(22,163,74,.3); transition:background .2s, transform .15s, box-shadow .2s; }
.auth-btn:hover { background:#15803d; transform:translateY(-1px); box-shadow:0 4px 14px rgba(22,163,74,.4); }
.auth-btn:active { transform:translateY(0); }

@media (max-width:480px) { body{padding:1rem;} .auth-card{padding:2rem 1.5rem;border-radius:16px;} }
</style>
</head>
<body>
<div class="auth-card">

  <div class="auth-logo"><i class="bi bi-shield-check-fill"></i></div>
  <div class="auth-title">Buat Password Baru</div>
  <div class="auth-sub">Kode verifikasi berhasil. Buat password baru untuk akun Anda.</div>

  @if(session('error'))
    <div class="auth-alert auth-alert-danger"><i class="bi bi-exclamation-circle"></i> {{ session('error') }}</div>
  @endif

  <form method="POST" action="{{ route('admin.password.new.save') }}" novalidate>
    @csrf

    <div class="auth-field">
      <label class="auth-label" for="newPwd">Password Baru</label>
      <div class="auth-input-group">
        <div class="auth-icon"><i class="bi bi-lock"></i></div>
        <input type="password" id="newPwd" name="password"
               class="auth-input" placeholder="Minimal 8 karakter"
               autocomplete="new-password">
        <button type="button" class="auth-eye" id="toggleNew">
          <i class="bi bi-eye" id="eyeNew"></i>
        </button>
      </div>
      <div class="auth-hint">Minimal 8 karakter.</div>
      @error('password')<span class="auth-invalid">{{ $message }}</span>@enderror
    </div>

    <div class="auth-field">
      <label class="auth-label" for="confirmPwd">Konfirmasi Password</label>
      <div class="auth-input-group">
        <div class="auth-icon"><i class="bi bi-lock-fill"></i></div>
        <input type="password" id="confirmPwd" name="password_confirmation"
               class="auth-input" placeholder="Ulangi password baru"
               autocomplete="new-password">
        <button type="button" class="auth-eye" id="toggleConfirm">
          <i class="bi bi-eye" id="eyeConfirm"></i>
        </button>
      </div>
      @error('password_confirmation')<span class="auth-invalid">{{ $message }}</span>@enderror
    </div>

    <button type="submit" class="auth-btn">
      <i class="bi bi-check-circle"></i>Simpan Password Baru
    </button>
  </form>
</div>

<script>
(function () {
  'use strict';
  function mkToggle(btnId, inputId, iconId) {
    var btn   = document.getElementById(btnId);
    var input = document.getElementById(inputId);
    var icon  = document.getElementById(iconId);
    if (!btn) return;
    btn.addEventListener('click', function () {
      var show = (input.type === 'password');
      input.type     = show ? 'text' : 'password';
      icon.className = show ? 'bi bi-eye-slash' : 'bi bi-eye';
    });
  }
  mkToggle('toggleNew',     'newPwd',     'eyeNew');
  mkToggle('toggleConfirm', 'confirmPwd', 'eyeConfirm');
})();
</script>
</body>
</html>

