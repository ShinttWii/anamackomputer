@extends('layouts.customer')
@section('title', 'Informasi Kerusakan MacBook')

@section('content')
<div class="py-5">
  <div class="container">

    <div class="text-center mb-5">
      <div class="section-line centered"></div>
      <h1 class="section-title">Informasi <span>Kerusakan MacBook</span></h1>
      <p class="text-muted" style="max-width:480px;margin:.5rem auto 0;font-size:.9rem;">
        Daftar kerusakan umum MacBook beserta penyebab dan solusi penanganan awal.
      </p>
      <div class="info-note d-inline-block mt-3 text-start" style="max-width:520px;font-size:.82rem;">
        <i class="bi bi-info-circle me-1"></i>
        Untuk diagnosis berdasarkan gejala spesifik, gunakan fitur
        <a href="{{ route('konsultasi') }}" style="color:var(--orange);font-weight:600;">Konsultasi Diagnosis</a>.
      </div>
    </div>

    @if($kerusakans->isEmpty())
      <div class="empty-state">
        <i class="bi bi-exclamation-circle"></i>
        <p>Belum ada data kerusakan.</p>
      </div>
    @else
      <div class="row g-2 g-md-4">
        @foreach($kerusakans as $k)
        <div class="col-6 col-md-6 col-xl-4 anim-on-scroll" style="animation-delay:{{ ($loop->index % 3) * .08 }}s;">
          <div class="k-card h-100">
            <div class="k-card-head">
              <div class="d-flex align-items-center gap-2">
                <div class="k-number">{{ $loop->iteration }}</div>
                <div>
                  <span class="kode-badge">{{ $k->kode }}</span>
                  <h6 class="fw-700 mb-0 mt-1" style="font-size:.875rem;color:var(--navy);">{{ $k->nama }}</h6>
                </div>
              </div>
            </div>
            <div class="p-3">
              @if($k->deskripsi)
              <p class="text-muted mb-3" style="font-size:.82rem;line-height:1.6;">{{ $k->deskripsi }}</p>
              @endif

              @if($k->penyebabs->isNotEmpty())
              <div class="mb-3">
                <div class="d-flex align-items-center gap-1 mb-2">
                  <i class="bi bi-search text-orange" style="font-size:.8rem;"></i>
                  <span class="fw-600" style="font-size:.78rem;color:var(--text-mid);">Kemungkinan Penyebab</span>
                </div>
                <ul class="list-unstyled mb-0">
                  @foreach($k->penyebabs->take(3) as $p)
                  <li class="d-flex align-items-start gap-1 mb-1">
                    <i class="bi bi-dot text-orange flex-shrink-0 mt-1"></i>
                    <span class="text-muted" style="font-size:.78rem;">{{ $p->deskripsi }}</span>
                  </li>
                  @endforeach
                  @if($k->penyebabs->count() > 3)
                    <li class="text-muted ps-3" style="font-size:.75rem;">+{{ $k->penyebabs->count() - 3 }} lainnya</li>
                  @endif
                </ul>
              </div>
              @endif

              @if($k->solusIs->isNotEmpty())
              <div>
                <div class="d-flex align-items-center gap-1 mb-2">
                  <i class="bi bi-tools" style="font-size:.8rem;color:var(--lblue-dark);"></i>
                  <span class="fw-600" style="font-size:.78rem;color:var(--text-mid);">Solusi Penanganan</span>
                </div>
                <ul class="list-unstyled mb-0">
                  @foreach($k->solusIs->take(2) as $s)
                  <li class="d-flex align-items-start gap-1 mb-1">
                    <i class="bi bi-check2 text-success flex-shrink-0 mt-1"></i>
                    <span class="text-muted" style="font-size:.78rem;">{{ $s->deskripsi }}</span>
                  </li>
                  @endforeach
                  @if($k->solusIs->count() > 2)
                    <li class="text-muted ps-3" style="font-size:.75rem;">+{{ $k->solusIs->count() - 2 }} solusi lainnya</li>
                  @endif
                </ul>
              </div>
              @endif
            </div>
          </div>
        </div>
        @endforeach
      </div>
    @endif

    <div class="text-center mt-5">
      <a href="{{ route('konsultasi') }}" class="btn-amk" style="padding:.7rem 1.75rem;">
        <i class="bi bi-stethoscope me-1"></i>Mulai Konsultasi Diagnosis
      </a>
    </div>

  </div>
</div>
@endsection
