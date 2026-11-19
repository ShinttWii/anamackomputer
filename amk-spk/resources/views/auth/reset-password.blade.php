<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reset Password — SP MacBook aMK</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
<div class="login-page">
  <div class="login-card">
    <div class="login-logo"><i class="bi bi-shield-lock"></i></div>
    <h4 class="text-center fw-bold mb-1">Buat Password Baru</h4>
    <p class="text-center text-muted small mb-4">Masukkan password baru untuk akun Admin Anda.</p>

    @if(session('error'))
      <div class="alert alert-danger alert-dismissible fade show py-2 mb-3" style="font-size:.86rem;">
        <i class="bi bi-exclamation-circle me-1"></i>{{ session('error') }}
        <button type="button" class="btn-close py-2" data-bs-dismiss="alert"></button>
      </div>
    @endif

    <form method="POST" action="{{ route('admin.password.update') }}" novalidate>
      @csrf
      <input type="hidden" name="token" value="{{ $token }}">

      {{-- Email --}}
      <div class="mb-3">
        <label class="form-label">Email</label>
        <div class="input-group">
          <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope text-muted"></i></span>
          <input type="email" name="email" value="{{ old('email', $email) }}"
                 class="form-control border-start-0 @error('email') is-invalid @enderror"
                 placeholder="email@contoh.com" autocomplete="email">
          @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>

      {{-- Password Baru --}}
      <div class="mb-3">
        <label class="form-label">Password Baru</label>
        <div class="input-group">
          <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock text-muted"></i></span>
          <input type="password" name="password" id="newPassword"
                 class="form-control border-start-0 border-end-0 @error('password') is-invalid @enderror"
                 placeholder="Minimal 8 karakter" autocomplete="new-password">
          <button type="button" class="input-group-text bg-light border-start-0" id="toggleNew" style="cursor:pointer;">
            <i class="bi bi-eye text-muted" id="eyeNew"></i>
          </button>
          @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="form-text">Minimal 8 karakter.</div>
      </div>

      {{-- Konfirmasi Password --}}
      <div class="mb-4">
        <label class="form-label">Konfirmasi Password Baru</label>
        <div class="input-group">
          <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock-fill text-muted"></i></span>
          <input type="password" name="password_confirmation" id="confirmPassword"
                 class="form-control border-start-0 border-end-0 @error('password_confirmation') is-invalid @enderror"
                 placeholder="Ulangi password baru" autocomplete="new-password">
          <button type="button" class="input-group-text bg-light border-start-0" id="toggleConfirm" style="cursor:pointer;">
            <i class="bi bi-eye text-muted" id="eyeConfirm"></i>
          </button>
          @error('password_confirmation')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>

      <button type="submit" class="btn-amk w-100 justify-content-center" style="padding:.7rem;">
        <i class="bi bi-check-circle"></i>Simpan Password Baru
      </button>
    </form>

    <div class="text-center mt-4">
      <a href="{{ route('admin.login') }}" class="text-muted small">
        <i class="bi bi-arrow-left me-1"></i>Kembali ke Login
      </a>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function togglePwd(btnId, inputId, iconId) {
    document.getElementById(btnId).addEventListener('click', function () {
      const inp  = document.getElementById(inputId);
      const icon = document.getElementById(iconId);
      const isText = inp.type === 'text';
      inp.type = isText ? 'password' : 'text';
      icon.className = isText ? 'bi bi-eye text-muted' : 'bi bi-eye-slash text-muted';
    });
  }
  togglePwd('toggleNew',     'newPassword',     'eyeNew');
  togglePwd('toggleConfirm', 'confirmPassword', 'eyeConfirm');
</script>
</body>
</html>
