@extends('layouts.admin')
@section('title', 'Profil Admin')

@section('content')
<div class="page-header">
  <div>
    <h1><i class="bi bi-person-circle text-orange me-2"></i>Profil Admin</h1>
    <div class="page-header-meta">Informasi akun dan pengaturan email</div>
  </div>
  <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-secondary" style="border-radius:6px;">
    <i class="bi bi-arrow-left me-1"></i>Kembali
  </a>
</div>

<div class="row g-4">

  {{-- ── Profil ── --}}
  <div class="col-lg-4">
    <div class="admin-card">
      <div class="admin-card-header">
        <h6><i class="bi bi-person-fill text-orange me-2"></i>Informasi Akun</h6>
      </div>
      <div class="admin-card-body text-center py-4">
        <div style="width:72px;height:72px;background:var(--navy);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;font-size:1.75rem;color:#fff;">
          <i class="bi bi-person-fill"></i>
        </div>
        <h6 class="fw-700 mb-1" style="color:var(--navy);">{{ $admin->nama_lengkap }}</h6>
        <div class="text-muted mb-3" style="font-size:.8rem;">
          <i class="bi bi-at me-1"></i>{{ $admin->username }}
        </div>

        @if($admin->email)
          <div class="mb-1" style="font-size:.75rem;color:var(--text-muted);">Email Aktif</div>
          <span class="status-badge status-ok" style="font-size:.75rem;word-break:break-all;">
            <i class="bi bi-envelope-check-fill"></i>{{ $admin->email }}
          </span>
        @else
          <span class="status-badge status-fail" style="font-size:.75rem;">
            <i class="bi bi-exclamation-triangle"></i>Email belum diatur
          </span>
        @endif

        @if($admin->email_pending && !session('email_changed'))
          <div class="mt-3 p-2 rounded text-start" style="background:var(--orange-bg);border:1px solid var(--orange-light);">
            <div class="fw-600 mb-1" style="font-size:.75rem;color:var(--orange);">
              <i class="bi bi-clock me-1"></i>Menunggu Verifikasi OTP
            </div>
            <div class="text-muted" style="font-size:.75rem;">Email baru: <strong>{{ $admin->email_pending }}</strong></div>
          </div>
        @endif
      </div>
    </div>
  </div>

  {{-- ── Form Ubah Email ── --}}
  <div class="col-lg-8">

    @php
      // Tampilkan step OTP jika sudah kirim OTP dan belum selesai
      $showOtp = (session('otp_sent') || ($admin->email_pending && $admin->email_change_otp))
                 && !session('email_changed');
    @endphp

    {{-- Flash success / error --}}
    @if(session('success'))
      <div class="alert alert-success alert-dismissible alert-auto-dismiss fade show mb-4">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif
    @if(session('error'))
      <div class="alert alert-danger alert-dismissible fade show mb-4">
        <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    {{-- ─────────────────────────────────────────
         STEP 1 — Form email baru + password
         (tampil jika belum kirim OTP)
    ───────────────────────────────────────── --}}
    @if(!$showOtp)
    <div class="admin-card">
      <div class="admin-card-header">
        <h6><i class="bi bi-envelope-gear text-orange me-2"></i>Ubah Email</h6>
        {{-- Indikator step --}}
        <div class="d-flex align-items-center gap-2">
          <span style="width:24px;height:24px;border-radius:50%;background:var(--orange);color:#fff;display:flex;align-items:center;justify-content:center;font-size:.72rem;font-weight:800;">1</span>
          <span class="text-muted" style="font-size:.78rem;">Data Email</span>
          <span class="text-muted mx-1">→</span>
          <span style="width:24px;height:24px;border-radius:50%;background:var(--border);color:var(--text-muted);display:flex;align-items:center;justify-content:center;font-size:.72rem;font-weight:800;">2</span>
          <span class="text-muted" style="font-size:.78rem;">Verifikasi OTP</span>
        </div>
      </div>
      <div class="admin-card-body">
        <div class="info-note mb-4" style="font-size:.83rem;">
          <i class="bi bi-info-circle me-2"></i>
          Setelah mengisi data di bawah, kode OTP akan dikirim ke <strong>email lama</strong> untuk memverifikasi perubahan.
        </div>

        <form method="POST" action="{{ route('admin.account.request-otp') }}" novalidate>
          @csrf

          {{-- Email Saat Ini --}}
          <div class="mb-3">
            <label class="form-label">Email Saat Ini</label>
            <input type="text" class="form-control" value="{{ $admin->email ?? 'Belum diatur' }}"
                   disabled style="background:var(--page-bg);color:var(--text-muted);">
          </div>

          {{-- Email Baru --}}
          <div class="mb-3">
            <label class="form-label">Email Baru <span class="text-danger">*</span></label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-envelope"></i></span>
              <input type="email" name="email_baru" value="{{ old('email_baru') }}"
                     class="form-control border-start-0 @error('email_baru') is-invalid @enderror"
                     placeholder="email-baru@contoh.com" autofocus>
              @error('email_baru')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          {{-- Konfirmasi Email Baru --}}
          <div class="mb-3">
            <label class="form-label">Konfirmasi Email Baru <span class="text-danger">*</span></label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-envelope-check"></i></span>
              <input type="email" name="email_konfirmasi" value="{{ old('email_konfirmasi') }}"
                     class="form-control border-start-0 @error('email_konfirmasi') is-invalid @enderror"
                     placeholder="Ulangi email baru">
              @error('email_konfirmasi')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          {{-- Password --}}
          <div class="mb-4">
            <label class="form-label">Password Saat Ini <span class="text-danger">*</span></label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-lock"></i></span>
              <input type="password" name="password_sekarang" id="currentPwd"
                     class="form-control border-start-0 border-end-0 @error('password_sekarang') is-invalid @enderror"
                     placeholder="Masukkan password saat ini">
              <button type="button" class="input-group-text" id="togglePwd"
                      style="cursor:pointer;background:var(--page-bg);border:1.5px solid var(--border);border-left:0;">
                <i class="bi bi-eye text-muted" id="eyePwd"></i>
              </button>
              @error('password_sekarang')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="form-text">Diperlukan untuk memverifikasi identitas Anda.</div>
          </div>

          <button type="submit" class="btn-amk">
            <i class="bi bi-send me-1"></i>Kirim Kode OTP ke Email Lama
          </button>
        </form>
      </div>
    </div>
    @endif

    {{-- ─────────────────────────────────────────
         STEP 2 — Input OTP
         (tampil setelah OTP terkirim)
    ───────────────────────────────────────── --}}
    @if($showOtp)
    <div class="admin-card">
      <div class="admin-card-header">
        <h6><i class="bi bi-shield-lock text-orange me-2"></i>Verifikasi Kode OTP</h6>
        {{-- Indikator step --}}
        <div class="d-flex align-items-center gap-2">
          <span style="width:24px;height:24px;border-radius:50%;background:var(--border);color:var(--text-muted);display:flex;align-items:center;justify-content:center;font-size:.72rem;font-weight:800;">1</span>
          <span class="text-muted" style="font-size:.78rem;">Data Email</span>
          <span class="text-muted mx-1">→</span>
          <span style="width:24px;height:24px;border-radius:50%;background:var(--orange);color:#fff;display:flex;align-items:center;justify-content:center;font-size:.72rem;font-weight:800;">2</span>
          <span class="text-muted" style="font-size:.78rem;">Verifikasi OTP</span>
        </div>
      </div>
      <div class="admin-card-body">

        <div class="info-note mb-4" style="font-size:.83rem;">
          <i class="bi bi-envelope me-2"></i>
          Kode OTP telah dikirim ke email lama Anda: <strong>{{ $admin->email }}</strong><br>
          <span style="font-size:.78rem;">Akan diubah ke: <strong>{{ $admin->email_pending }}</strong> — Berlaku <strong>2 menit</strong>.</span>
        </div>

        {{-- Form input OTP --}}
        <form method="POST" action="{{ route('admin.account.verify-otp') }}" id="otpForm" novalidate>
          @csrf
          <div class="mb-1">
            <label class="form-label">Kode Verifikasi OTP</label>
            <p class="text-muted mb-3" style="font-size:.82rem;">Masukkan 6 digit kode yang dikirim ke email lama Anda.</p>
          </div>

          {{-- 6 kotak OTP --}}
          <div class="d-flex gap-2 mb-4" id="otpBoxes" style="justify-content:flex-start;">
            @for($i=0; $i<6; $i++)
              <input type="text" class="otp-box form-control text-center fw-800"
                     maxlength="1" pattern="[0-9]" inputmode="numeric"
                     id="ob{{$i}}"
                     style="width:50px;height:56px;font-size:1.4rem;border-radius:8px;border:1.5px solid var(--border);transition:border-color .2s,box-shadow .2s;"
                     autocomplete="{{ $i===0 ? 'one-time-code' : 'off' }}">
            @endfor
          </div>
          <input type="hidden" name="otp_kode" id="otpHidden">
        </form>

        {{-- Tombol aksi — di luar form OTP agar tidak nested --}}
        <div class="d-flex gap-2 flex-wrap align-items-center mt-3">

          <button type="submit" form="otpForm" id="btnVerify" class="btn-amk" disabled>
            <i class="bi bi-check-circle me-1"></i>Verifikasi &amp; Ubah Email
          </button>

          {{-- Countdown, setelah habis muncul tombol kirim ulang --}}
          <span id="resendTimer" style="font-size:.83rem;color:var(--text-muted);">
            Kirim ulang dalam <strong id="timerCount" style="color:var(--navy);">2:00</strong>
          </span>
          <form method="POST" action="{{ route('admin.account.resend-otp') }}"
                id="resendForm" style="display:none;">
            @csrf
            <button type="submit" class="btn btn-outline-secondary" style="border-radius:6px;font-size:.83rem;">
              <i class="bi bi-arrow-repeat me-1"></i>Kirim Ulang Kode
            </button>
          </form>

          {{-- Batalkan --}}
          <form method="POST" action="{{ route('admin.account.cancel') }}">
            @csrf
            <button type="submit" class="btn btn-outline-danger" style="border-radius:6px;font-size:.83rem;"
                    onclick="return confirm('Batalkan perubahan email?')">
              <i class="bi bi-x-circle me-1"></i>Batalkan
            </button>
          </form>

        </div>

      </div>
    </div>
    @endif

  </div>
</div>

@endsection

@push('scripts')
<script>
(function () {
  // Toggle password visibility
  var btn = document.getElementById('togglePwd');
  var pwd = document.getElementById('currentPwd');
  var eye = document.getElementById('eyePwd');
  if (btn) {
    btn.addEventListener('click', function () {
      var show = pwd.type === 'password';
      pwd.type = show ? 'text' : 'password';
      eye.className = show ? 'bi bi-eye-slash text-muted' : 'bi bi-eye text-muted';
    });
  }

  // OTP boxes
  var boxes   = Array.from(document.querySelectorAll('.otp-box'));
  var hidden  = document.getElementById('otpHidden');
  var btnVer  = document.getElementById('btnVerify');

  if (!boxes.length) return;

  boxes[0].focus();

  function syncState() {
    var val = boxes.map(function(b){ return b.value; }).join('');
    if (hidden) hidden.value = val;
    boxes.forEach(function(b) {
      b.style.borderColor = b.value ? 'var(--navy)' : 'var(--border)';
      b.style.background  = b.value ? 'var(--navy-bg)' : '#fff';
    });
    if (btnVer) btnVer.disabled = val.length < 6;
  }

  boxes.forEach(function(b, i) {
    b.addEventListener('input', function() {
      this.value = this.value.replace(/\D/g, '').slice(-1);
      syncState();
      if (this.value && i < 5) boxes[i+1].focus();
    });
    b.addEventListener('keydown', function(e) {
      if (e.key === 'Backspace' && !this.value && i > 0) {
        boxes[i-1].value = '';
        boxes[i-1].focus();
        syncState();
      }
    });
    b.addEventListener('paste', function(e) {
      e.preventDefault();
      var txt = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g,'');
      txt.split('').slice(0,6).forEach(function(c,j){ if(boxes[j]) boxes[j].value=c; });
      boxes[Math.min(txt.length,5)].focus();
      syncState();
    });
  });

  document.getElementById('otpForm') && document.getElementById('otpForm').addEventListener('submit', function(){
    if (hidden) hidden.value = boxes.map(function(b){ return b.value; }).join('');
  });

  // Countdown kirim ulang — sama persis dengan halaman verify-otp lupa password
  var timerEl    = document.getElementById('timerCount');
  var timerWrap  = document.getElementById('resendTimer');
  var resendForm = document.getElementById('resendForm');
  if (timerEl) {
    var sisa = 120;
    var tick = setInterval(function () {
      sisa--;
      if (sisa <= 0) {
        clearInterval(tick);
        if (timerWrap)  timerWrap.style.display = 'none';
        if (resendForm) resendForm.style.display = 'inline';
        return;
      }
      timerEl.textContent = Math.floor(sisa / 60) + ':' + String(sisa % 60).padStart(2, '0');
    }, 1000);
  }
})();
</script>
@endpush
