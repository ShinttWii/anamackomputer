<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Lupa Password â€” aMK Panel</title>
<link rel="stylesheet" href="{{ asset('css/bootstrap-icons.min.css') }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap">
<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html { height: 100%; font-size: 16px; }
body {
  font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
  background: #172554;
  min-height: 100%; height: 100vh;
  display: flex; flex-direction: column;
  align-items: center; justify-content: center;
  padding: 1.5rem; position: relative; overflow: hidden;
  -webkit-font-smoothing: antialiased;
}
body::before { content:''; position:fixed; top:-150px; right:-150px; width:500px; height:500px; border-radius:50%; background:radial-gradient(circle, rgba(242,140,40,.2) 0%, transparent 65%); pointer-events:none; z-index:0; }
body::after  { content:''; position:fixed; bottom:-120px; left:-120px; width:420px; height:420px; border-radius:50%; background:radial-gradient(circle, rgba(142,202,230,.15) 0%, transparent 65%); pointer-events:none; z-index:0; }

.auth-card { background:#fff; border-radius:20px; padding:2.5rem 2.25rem; width:100%; max-width:420px; box-shadow:0 24px 48px rgba(0,0,0,.35), 0 4px 16px rgba(0,0,0,.15); position:relative; z-index:1; animation:cardIn .35s cubic-bezier(.22,.61,.36,1) both; }
@keyframes cardIn { from{opacity:0;transform:translateY(20px) scale(.96);} to{opacity:1;transform:translateY(0) scale(1);} }

.auth-logo { width:54px; height:54px; background:#172554; border-radius:14px; display:flex; align-items:center; justify-content:center; color:#fff; font-size:1.6rem; margin:0 auto 1.25rem; box-shadow:0 4px 16px rgba(23,37,84,.4); }
.auth-title { font-size:1.35rem; font-weight:800; color:#172554; text-align:center; margin-bottom:.3rem; letter-spacing:-.025em; }
.auth-sub { font-size:.84rem; color:#6B7280; text-align:center; line-height:1.65; margin-bottom:1.5rem; }

.auth-alert { border-radius:8px; border:none; border-left:3px solid; font-size:.83rem; padding:.65rem .9rem; margin-bottom:1.1rem; display:flex; align-items:flex-start; gap:.5rem; line-height:1.5; }
.auth-alert-body { flex:1; }
.auth-alert-title { font-weight:700; margin-bottom:.15rem; }
.auth-alert-danger  { background:#fef2f2; border-color:#ef4444; color:#b91c1c; }
.auth-alert-success { background:#f0fdf4; border-color:#22c55e; color:#15803d; }

.auth-field { margin-bottom:1rem; }
.auth-label { display:block; font-size:.8rem; font-weight:600; color:#374151; margin-bottom:.4rem; }
.auth-input-group { display:flex; align-items:stretch; border:1.5px solid #D1D5DB; border-radius:8px; overflow:hidden; background:#fff; transition:border-color .2s, box-shadow .2s; }
.auth-input-group:focus-within { border-color:#F28C28; box-shadow:0 0 0 3px rgba(242,140,40,.15); }
.auth-icon { display:flex; align-items:center; justify-content:center; width:42px; flex-shrink:0; background:#F9FAFB; color:#9CA3AF; font-size:.95rem; border-right:1px solid #E5E7EB; }
.auth-input { flex:1; min-width:0; border:none; outline:none; padding:.65rem .9rem; font-size:.875rem; font-family:inherit; color:#111827; background:transparent; }
.auth-input::placeholder { color:#9CA3AF; }

.auth-btn { display:flex; align-items:center; justify-content:center; gap:.4rem; width:100%; padding:.75rem 1rem; background:#F28C28; color:#fff; font-size:.9rem; font-weight:700; font-family:inherit; border:none; border-radius:8px; cursor:pointer; box-shadow:0 2px 8px rgba(242,140,40,.35); transition:background .2s, transform .15s, box-shadow .2s; }
.auth-btn:hover { background:#D97706; transform:translateY(-1px); box-shadow:0 4px 14px rgba(242,140,40,.45); }
.auth-btn:active { transform:translateY(0); }

.auth-divider { border:none; border-top:1px solid #F3F4F6; margin:1.2rem 0; }
.auth-link { display:block; text-align:center; font-size:.8rem; color:#9CA3AF; text-decoration:none; transition:color .15s; }
.auth-link:hover { color:#F28C28; }

@media (max-width:480px) { body{padding:1rem;} .auth-card{padding:2rem 1.5rem;border-radius:16px;} }
</style>
</head>
<body>
<div class="auth-card">

  <div class="auth-logo"><i class="bi bi-key-fill"></i></div>
  <div class="auth-title">Lupa Password</div>
  <div class="auth-sub">Masukkan email akun admin. Kami akan mengirim <strong style="color:#172554;">kode verifikasi 6 digit</strong> ke email tersebut.</div>

  @if(session('success'))
    <div class="auth-alert auth-alert-success">
      <i class="bi bi-check-circle-fill flex-shrink-0"></i>
      <div class="auth-alert-body">{{ session('success') }}</div>
    </div>
  @endif
  @if(session('error'))
    <div class="auth-alert auth-alert-danger">
      <i class="bi bi-exclamation-circle-fill flex-shrink-0"></i>
      <div class="auth-alert-body">
        <div class="auth-alert-title">Email Tidak Ditemukan</div>
        {{ session('error') }}
      </div>
    </div>
  @endif
  @if($errors->has('email'))
    <div class="auth-alert auth-alert-danger">
      <i class="bi bi-exclamation-circle-fill flex-shrink-0"></i>
      <div class="auth-alert-body">{{ $errors->first('email') }}</div>
    </div>
  @endif

  <form method="POST" action="{{ route('admin.password.email') }}" novalidate>
    @csrf
    <div class="auth-field">
      <label class="auth-label" for="emailInput">Alamat Email Admin</label>
      <div class="auth-input-group">
        <div class="auth-icon"><i class="bi bi-envelope"></i></div>
        <input type="email" id="emailInput" name="email"
               value="{{ old('email') }}" class="auth-input"
               placeholder="email@contoh.com" autofocus>
      </div>
    </div>
    <button type="submit" class="auth-btn">
      <i class="bi bi-send"></i>Kirim Kode Verifikasi
    </button>
  </form>

  <hr class="auth-divider">
  <a href="{{ route('admin.login') }}" class="auth-link">
    <i class="bi bi-arrow-left"></i> Kembali ke Login
  </a>

</div>
</body>
</html>

