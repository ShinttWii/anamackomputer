<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Verifikasi Kode â€” aMK Panel</title>
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

.auth-logo { width:54px; height:54px; background:#172554; border-radius:14px; display:flex; align-items:center; justify-content:center; color:#fff; font-size:1.6rem; margin:0 auto 1.25rem; box-shadow:0 4px 16px rgba(23,37,84,.4); }
.auth-title { font-size:1.35rem; font-weight:800; color:#172554; text-align:center; margin-bottom:.3rem; letter-spacing:-.025em; }
.auth-sub { font-size:.83rem; color:#6B7280; text-align:center; line-height:1.65; margin-bottom:1.5rem; }

.auth-alert { border-radius:8px; border:none; border-left:3px solid; font-size:.83rem; padding:.65rem .9rem; margin-bottom:1rem; display:flex; align-items:center; gap:.5rem; line-height:1.5; }
.auth-alert-danger  { background:#fef2f2; border-color:#ef4444; color:#b91c1c; }
.auth-alert-success { background:#f0fdf4; border-color:#22c55e; color:#15803d; }

/* OTP boxes */
.otp-wrap { display:flex; gap:.5rem; justify-content:center; margin-bottom:1.5rem; }
.otp-digit {
  width:48px; height:56px; text-align:center;
  font-size:1.5rem; font-weight:800; color:#172554;
  border:1.5px solid #D1D5DB; border-radius:8px;
  outline:none; background:#fff; font-family:inherit;
  transition:border-color .2s, box-shadow .2s, background .2s;
}
.otp-digit:focus { border-color:#F28C28; box-shadow:0 0 0 3px rgba(242,140,40,.15); background:#FFFBF5; }
.otp-digit.filled { border-color:#172554; background:#EFF6FF; }

.auth-btn { display:flex; align-items:center; justify-content:center; gap:.4rem; width:100%; padding:.75rem 1rem; background:#F28C28; color:#fff; font-size:.9rem; font-weight:700; font-family:inherit; border:none; border-radius:8px; cursor:pointer; box-shadow:0 2px 8px rgba(242,140,40,.35); transition:background .2s, transform .15s, box-shadow .2s; margin-bottom:.75rem; }
.auth-btn:hover { background:#D97706; transform:translateY(-1px); }
.auth-btn:disabled { opacity:.5; cursor:not-allowed; transform:none; }

.auth-resend { text-align:center; font-size:.82rem; color:#9CA3AF; margin-bottom:.5rem; }
.auth-resend a { color:#F28C28; font-weight:600; text-decoration:none; }
.auth-resend a:hover { text-decoration:underline; }

.auth-divider { border:none; border-top:1px solid #F3F4F6; margin:1.1rem 0; }
.auth-link { display:block; text-align:center; font-size:.8rem; color:#9CA3AF; text-decoration:none; transition:color .15s; }
.auth-link:hover { color:#F28C28; }

@media (max-width:480px) {
  body{padding:1rem;}
  .auth-card{padding:2rem 1.25rem;border-radius:16px;}
  .otp-digit{width:40px;height:50px;font-size:1.25rem;}
}
</style>
</head>
<body>
<div class="auth-card">

  <div class="auth-logo"><i class="bi bi-shield-lock-fill"></i></div>
  <div class="auth-title">Masukkan Kode</div>
  <div class="auth-sub">
    Kode 6 digit dikirim ke <strong style="color:#F28C28;">{{ session('otp_email') }}</strong><br>
    <span style="font-size:.75rem;">Cek kotak masuk atau spam. Berlaku <strong style="color:#172554;">2 menit</strong>.</span>
  </div>

  @if(session('success'))
    <div class="auth-alert auth-alert-success"><i class="bi bi-check-circle-fill"></i>{{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="auth-alert auth-alert-danger"><i class="bi bi-exclamation-circle-fill"></i>{{ session('error') }}</div>
  @endif
  @if($errors->any())
    <div class="auth-alert auth-alert-danger"><i class="bi bi-exclamation-circle-fill"></i>{{ $errors->first() }}</div>
  @endif

  <form method="POST" action="{{ route('admin.password.otp.verify') }}" id="otpForm" novalidate>
    @csrf
    <div class="otp-wrap">
      @for($i=0; $i<6; $i++)
        <input type="text" class="otp-digit" maxlength="1" pattern="[0-9]"
               inputmode="numeric" id="d{{$i}}"
               autocomplete="{{ $i===0 ? 'one-time-code' : 'off' }}">
      @endfor
    </div>
    <input type="hidden" name="otp" id="otpHidden">
    <button type="submit" id="btnVerify" class="auth-btn" disabled>
      <i class="bi bi-check-circle"></i>Verifikasi Kode
    </button>
  </form>

  <div class="auth-resend">
    Tidak menerima kode?
    <span id="resendWrap">
      <a href="{{ route('admin.password.otp.resend') }}" id="btnResend"
         style="display:none;" onclick="return confirm('Kirim ulang kode?')">
        <i class="bi bi-arrow-repeat"></i> Kirim Ulang
      </a>
      <span id="resendTimer">dalam <strong id="timerCount" style="color:#172554;">2:00</strong></span>
    </span>
  </div>

  <hr class="auth-divider">
  <a href="{{ route('admin.password.request') }}" class="auth-link">
    <i class="bi bi-arrow-left"></i> Ganti Email
  </a>
</div>

<script>
(function () {
  'use strict';
  var digits  = Array.from(document.querySelectorAll('.otp-digit'));
  var hidden  = document.getElementById('otpHidden');
  var btn     = document.getElementById('btnVerify');

  if (digits[0]) digits[0].focus();

  function updateState() {
    var val = digits.map(function(d){ return d.value; }).join('');
    hidden.value = val;
    digits.forEach(function(d){ d.classList.toggle('filled', d.value !== ''); });
    btn.disabled = (val.length < 6);
  }

  digits.forEach(function(d, i) {
    d.addEventListener('input', function() {
      this.value = this.value.replace(/\D/g, '').slice(-1);
      updateState();
      if (this.value && i < 5) digits[i + 1].focus();
    });
    d.addEventListener('keydown', function(e) {
      if (e.key === 'Backspace' && !this.value && i > 0) {
        digits[i - 1].value = '';
        digits[i - 1].focus();
        updateState();
      }
    });
    d.addEventListener('paste', function(e) {
      e.preventDefault();
      var text = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '');
      text.split('').slice(0, 6).forEach(function(c, idx) {
        if (digits[idx]) digits[idx].value = c;
      });
      digits[Math.min(text.length, 5)].focus();
      updateState();
    });
  });

  document.getElementById('otpForm').addEventListener('submit', function() {
    hidden.value = digits.map(function(d){ return d.value; }).join('');
  });

  // Countdown 2 menit
  var sisa      = 120;
  var timerEl   = document.getElementById('timerCount');
  var timerWrap = document.getElementById('resendTimer');
  var btnResend = document.getElementById('btnResend');
  var tick = setInterval(function() {
    sisa--;
    if (sisa <= 0) {
      clearInterval(tick);
      timerWrap.style.display = 'none';
      btnResend.style.display = 'inline';
      return;
    }
    timerEl.textContent = Math.floor(sisa/60) + ':' + String(sisa%60).padStart(2,'0');
  }, 1000);
})();
</script>
</body>
</html>

