<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Sistem Pakar Diagnosis Kerusakan MacBook — anaMac Komputer (aMK)">
<title>@yield('title', 'Sistem Pakar') — anaMac Komputer</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="{{ asset('css/bootstrap-icons.min.css') }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
@stack('styles')
</head>
<body>

{{-- NAVBAR --}}
<nav class="navbar navbar-expand-lg navbar-amk sticky-top">
  <div style="width:100%;display:flex;align-items:center;padding:0 clamp(1rem,4vw,2.5rem);gap:1rem;">

    {{-- Brand / Logo --}}
    <a class="navbar-brand me-auto" href="{{ route('beranda') }}" style="flex-shrink:0;">
      @php $logoPath = \App\Models\SiteSetting::get('logo'); @endphp
      @if($logoPath)
        <img src="{{ asset('storage/' . $logoPath) }}" alt="aMK Logo"
             style="height:100px;width:auto;object-fit:contain;">
      @else
        <div style="display:flex;align-items:center;gap:.75rem;">
          <div class="brand-icon"><i class="bi bi-laptop"></i></div>
          <div>
            <div class="brand-name">aMK</div>
            <div class="brand-sub d-none d-sm-block">anaMac Komputer</div>
          </div>
        </div>
      @endif
    </a>

    {{-- Toggle mobile --}}
    <button class="navbar-toggler border-0 ms-auto" type="button"
            data-bs-toggle="collapse" data-bs-target="#navCustomer"
            aria-controls="navCustomer" aria-expanded="false" aria-label="Toggle navigation">
      <i class="bi bi-list" style="color:var(--navy);font-size:1.5rem;"></i>
    </button>

    {{-- Menu items --}}
    <div class="collapse navbar-collapse flex-grow-0" id="navCustomer">
      <ul class="navbar-nav align-items-lg-center gap-lg-1 py-2 py-lg-0 mobile-menu">
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('beranda') ? 'active' : '' }}" href="{{ route('beranda') }}">
            <i class="bi bi-house-door d-lg-none me-2"></i>Beranda
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('panduan') ? 'active' : '' }}" href="{{ route('panduan') }}">
            <i class="bi bi-book d-lg-none me-2"></i>Panduan
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('informasi') ? 'active' : '' }}" href="{{ route('informasi') }}">
            <i class="bi bi-info-circle d-lg-none me-2"></i>Info Kerusakan
          </a>
        </li>
        <li class="nav-item ms-lg-2">
          <a class="btn-amk" href="{{ route('konsultasi') }}">
            <i class="bi bi-stethoscope me-1"></i>Mulai Konsultasi
          </a>
        </li>
        <li class="nav-item ms-lg-2">
          <a class="btn-admin-login" href="{{ route('admin.login') }}">
            <i class="bi bi-person-lock me-1"></i>Admin
          </a>
        </li>
      </ul>
    </div>


  </div>
</nav>

{{-- FLASH MESSAGES --}}
@if(session('success') || session('error'))
<div class="container mt-3">
  @if(session('success'))
    <div class="alert alert-success alert-dismissible alert-auto-dismiss fade show" role="alert">
      <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif
  @if(session('error'))
    <div class="alert alert-danger alert-dismissible alert-auto-dismiss fade show" role="alert">
      <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif
</div>
@endif

{{-- MAIN CONTENT --}}
<main>
  @yield('content')
</main>

{{-- FOOTER --}}
<footer class="footer-amk no-print mt-auto">
  <div class="container py-3">
    <div class="row g-4 align-items-center">
      <div class="col-md-5">
        <div class="d-flex align-items-center gap-2 mb-2">
          <div style="width:30px;height:30px;background:var(--orange);border-radius:7px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:.85rem;">
            <i class="bi bi-laptop"></i>
          </div>
          <div>
            <span class="fw-800 text-orange" style="font-weight:800;">aMK</span>
            <span style="color:rgba(255,255,255,.5);font-size:.82rem;margin-left:.3rem;">anaMac Komputer</span>
          </div>
        </div>
        <p style="color:rgba(255,255,255,.4);font-size:.8rem;margin:0;line-height:1.6;">
          Toko layanan perbaikan MacBook terpercaya.<br>
          Sistem Pakar Diagnosis Kerusakan MacBook.
        </p>
      </div>
      <div class="col-md-7 text-md-end">
        <p style="color:rgba(255,255,255,.35);font-size:.78rem;margin-bottom:.3rem;">
          <i class="bi bi-shield-check me-1" style="color:var(--orange);"></i>
          Hasil diagnosis bersifat perkiraan awal, bukan pengganti pemeriksaan teknisi.
        </p>
        <p style="color:rgba(255,255,255,.25);font-size:.75rem;margin:0;">
          &copy; {{ date('Y') }} Sistem Pakar Diagnosis MacBook &mdash; Proyek Akhir
        </p>
      </div>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/main.js') }}"></script>
@stack('scripts')
</body>
</html>
