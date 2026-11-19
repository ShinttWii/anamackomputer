<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'Admin') — aMK Panel</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="{{ asset('css/bootstrap-icons.min.css') }}">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@stack('styles')
</head>
<body class="admin-body">

{{-- ── SIDEBAR ── --}}
<aside class="admin-sidebar" id="adminSidebar">

  {{-- Header --}}
  <div class="sidebar-header">
    <div class="brand-icon"><i class="bi bi-laptop"></i></div>
    <div>
      <div class="brand-name">aMK</div>
      <div class="brand-sub">Panel Admin</div>
    </div>
  </div>

  {{-- Navigation --}}
  <nav class="sidebar-nav">

    <div class="nav-section-lbl">Utama</div>
    <a href="{{ route('admin.dashboard') }}"
       class="s-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
      <i class="bi bi-grid-1x2-fill"></i><span>Dashboard</span>
    </a>

    <div class="nav-section-lbl">Data Master</div>
    <a href="{{ route('admin.kerusakan.index') }}"
       class="s-item {{ request()->routeIs('admin.kerusakan.*') ? 'active' : '' }}">
      <i class="bi bi-exclamation-triangle-fill"></i><span>Kerusakan</span>
    </a>
    <a href="{{ route('admin.gejala.index') }}"
       class="s-item {{ request()->routeIs('admin.gejala.*') ? 'active' : '' }}">
      <i class="bi bi-clipboard2-pulse-fill"></i><span>Gejala</span>
    </a>
    <a href="{{ route('admin.penyebab.index') }}"
       class="s-item {{ request()->routeIs('admin.penyebab.*') ? 'active' : '' }}">
      <i class="bi bi-search-heart-fill"></i><span>Penyebab</span>
    </a>
    <a href="{{ route('admin.solusi.index') }}"
       class="s-item {{ request()->routeIs('admin.solusi.*') ? 'active' : '' }}">
      <i class="bi bi-tools"></i><span>Solusi</span>
    </a>

    <div class="nav-section-lbl">Sistem Pakar</div>
    <a href="{{ route('admin.aturan.index') }}"
       class="s-item {{ request()->routeIs('admin.aturan.*') ? 'active' : '' }}">
      <i class="bi bi-diagram-3-fill"></i><span>Aturan Diagnosis</span>
    </a>
    <a href="{{ route('admin.riwayat.index') }}"
       class="s-item {{ request()->routeIs('admin.riwayat.*') ? 'active' : '' }}">
      <i class="bi bi-clock-history"></i><span>Riwayat Konsultasi</span>
    </a>

  </nav>

  {{-- Sidebar Footer --}}
  <div class="sidebar-footer">
    <form method="POST" action="{{ route('admin.logout') }}">
      @csrf
      <button type="submit" class="s-item"
              style="color:rgba(255,100,100,.7);"
              onclick="return confirm('Yakin ingin keluar?')">
        <i class="bi bi-box-arrow-left"></i><span>Keluar</span>
      </button>
    </form>
  </div>

</aside>

{{-- ── MAIN AREA ── --}}
<div class="admin-main" id="adminMain">

  {{-- Topbar --}}
  <header class="admin-topbar no-print">
    <button class="sidebar-toggle-btn" id="sidebarToggle" aria-label="Toggle sidebar">
      <i class="bi bi-list fs-5"></i>
    </button>

    <nav aria-label="breadcrumb" class="d-none d-md-block flex-grow-1">
      <span class="topbar-title">@yield('title', 'Dashboard')</span>
    </nav>
    <span class="topbar-title d-md-none">@yield('title', 'Dashboard')</span>

    <div class="topbar-user">
      {{-- Dropdown Profil --}}
      <div class="dropdown">
        <button class="admin-profile-btn border-0"
                type="button"
                data-bs-toggle="dropdown"
                aria-expanded="false">
          <div class="profile-avatar">
            <i class="bi bi-person-fill"></i>
          </div>
          <span class="fw-600 d-none d-md-inline"
                style="font-size:.83rem;color:var(--text-mid);max-width:130px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
            {{ session('admin_nama', 'Admin') }}
          </span>
          <i class="bi bi-chevron-down" style="font-size:.6rem;color:var(--text-light);"></i>
        </button>

        <ul class="dropdown-menu dropdown-menu-end admin-dropdown">
          <li>
            <div class="dropdown-header-inner">
              <div class="fw-700 small" style="color:var(--navy);">{{ session('admin_nama', 'Admin') }}</div>
              <div class="text-muted" style="font-size:.72rem;">Administrator aMK</div>
            </div>
          </li>
          <li>
            <a class="dropdown-item" href="{{ route('admin.account.index') }}">
              <i class="bi bi-person-circle text-orange"></i>Profil Admin
            </a>
          </li>
          <li>
            <a class="dropdown-item" href="{{ route('admin.konten.index') }}">
              <i class="bi bi-pencil-square text-orange"></i>Kelola Konten
            </a>
          </li>
          <li><hr class="dropdown-divider"></li>
          <li>
            <form method="POST" action="{{ route('admin.logout') }}">
              @csrf
              <button type="submit" class="dropdown-item text-danger w-100"
                      onclick="return confirm('Yakin ingin keluar?')">
                <i class="bi bi-box-arrow-left"></i>Keluar
              </button>
            </form>
          </li>
        </ul>
      </div>
    </div>
  </header>

  {{-- Content --}}
  <main class="admin-content page-fade">

    {{-- Flash Messages --}}
    @if(session('success'))
      <div class="alert alert-success alert-dismissible alert-auto-dismiss fade show mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif
    @if(session('error'))
      <div class="alert alert-danger alert-dismissible alert-auto-dismiss fade show mb-4" role="alert">
        <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    @yield('content')

  </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/main.js') }}"></script>
@stack('scripts')

{{-- ── AUTO-LOGOUT: keluar otomatis setelah 1 menit tidak ada aktivitas ── --}}

{{-- Modal Peringatan --}}
<div class="modal fade" id="idleModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="idleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content border-0 shadow-lg" style="border-radius:16px;overflow:hidden;">
      <div class="modal-header border-0 pb-0" style="background:#fff;">
        <div class="d-flex align-items-center gap-2 w-100">
          <div style="width:38px;height:38px;border-radius:10px;background:#fef2f2;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <i class="bi bi-clock-history" style="color:#ef4444;font-size:1.1rem;"></i>
          </div>
          <div>
            <h6 class="fw-700 mb-0" style="font-size:.9rem;color:#172554;" id="idleModalLabel">Sesi Hampir Berakhir</h6>
            <p class="mb-0" style="font-size:.72rem;color:#6B7280;">Tidak ada aktivitas terdeteksi</p>
          </div>
        </div>
      </div>
      <div class="modal-body pt-2 pb-3 text-center">
        <p style="font-size:.82rem;color:#374151;margin-bottom:.75rem;">
          Anda akan otomatis keluar dalam:
        </p>
        <div id="idleCountdown" style="font-size:2.2rem;font-weight:900;color:#ef4444;line-height:1;margin-bottom:.75rem;">15</div>
        <p style="font-size:.75rem;color:#9CA3AF;">detik</p>
        <button type="button" id="idleStayBtn"
                style="display:inline-flex;align-items:center;gap:.4rem;background:#172554;color:#fff;border:none;border-radius:8px;padding:.55rem 1.4rem;font-size:.82rem;font-weight:600;cursor:pointer;width:100%;justify-content:center;margin-top:.25rem;">
          <i class="bi bi-check-circle"></i> Tetap Masuk
        </button>
      </div>
    </div>
  </div>
</div>

{{-- Form logout (di-submit via JS) --}}
<form id="idleLogoutForm" method="POST" action="{{ route('admin.logout') }}" style="display:none;">
  @csrf
</form>

<script>
(function () {
  'use strict';

  var IDLE_TIMEOUT  = 60;   /* detik total tidak aktif sebelum logout */
  var WARN_BEFORE   = 15;   /* detik sebelum logout tampilkan modal    */

  var idleTimer     = null;
  var countTimer    = null;
  var countdown     = WARN_BEFORE;
  var modal         = new bootstrap.Modal(document.getElementById('idleModal'), { backdrop: 'static', keyboard: false });
  var countEl       = document.getElementById('idleCountdown');
  var stayBtn       = document.getElementById('idleStayBtn');

  /* ─── Mulai timer idle ─── */
  function startIdle() {
    clearTimeout(idleTimer);
    idleTimer = setTimeout(showWarning, (IDLE_TIMEOUT - WARN_BEFORE) * 1000);
  }

  /* ─── Tampilkan modal peringatan + countdown ─── */
  function showWarning() {
    countdown = WARN_BEFORE;
    countEl.textContent = countdown;
    modal.show();

    clearInterval(countTimer);
    countTimer = setInterval(function () {
      countdown--;
      countEl.textContent = countdown;
      if (countdown <= 0) {
        clearInterval(countTimer);
        doLogout();
      }
    }, 1000);
  }

  /* ─── Logout paksa via fetch (hindari 419 Page Expired di mobile) ─── */
  function doLogout() {
    modal.hide();

    /* Ambil CSRF token fresh dari meta tag */
    var token = document.querySelector('meta[name="csrf-token"]');
    var csrfToken = token ? token.getAttribute('content') : '';

    fetch('{{ route("admin.logout") }}', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
        'X-CSRF-TOKEN': csrfToken,
        'X-Requested-With': 'XMLHttpRequest'
      },
      body: '_token=' + encodeURIComponent(csrfToken)
    })
    .then(function () {
      /* Redirect ke halaman login setelah logout berhasil */
      window.location.href = '{{ route("admin.login") }}';
    })
    .catch(function () {
      /* Jika fetch gagal, paksa redirect ke login */
      window.location.href = '{{ route("admin.login") }}';
    });
  }

  /* ─── Reset timer saat ada aktivitas ─── */
  function resetIdle() {
    /* Hanya reset jika modal belum muncul */
    if (!document.getElementById('idleModal').classList.contains('show')) {
      startIdle();
    }
  }

  /* ─── Tombol "Tetap Masuk" ─── */
  stayBtn.addEventListener('click', function () {
    clearInterval(countTimer);
    modal.hide();
    startIdle();
  });

  /* ─── Pantau aktivitas pengguna ─── */
  ['mousemove', 'mousedown', 'keydown', 'touchstart', 'scroll', 'click'].forEach(function (evt) {
    document.addEventListener(evt, resetIdle, true);
  });

  /* ─── Mulai saat halaman dimuat ─── */
  startIdle();

})();
</script>

</body>
</html>
