@extends('layouts.customer')
@section('title', 'Hasil Diagnosis')

@push('styles')
<style>
@media print {
  .no-print { display: none !important; }
  .print-header { display: block !important; }
  body { background: #fff !important; }
  .amk-card { box-shadow: none !important; border: 1px solid #ddd !important; }
}
.print-header { display: none; }
</style>
@endpush

@section('content')
<div class="py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8 col-xl-7">

        {{-- Print Header --}}
        <div class="print-header text-center mb-4 pb-3" style="border-bottom:2px solid #000;">
          <h4 class="fw-800 mb-0">anaMac Komputer (aMK)</h4>
          <p class="mb-0 text-muted">Sistem Pakar Diagnosis Kerusakan MacBook</p>
          <small class="text-muted">Dicetak: {{ now()->locale('id')->isoFormat('D MMMM Y, HH:mm') }} WIB</small>
        </div>

        {{-- Page Header --}}
        <div class="text-center mb-4 no-print">
          <div class="section-line centered"></div>
          <h1 class="section-title">Hasil <span>Diagnosis</span></h1>
        </div>

        @if($konsultasi->status_diagnosis === 'terdiagnosis' && $konsultasi->kerusakan)
          @php $k = $konsultasi->kerusakan; @endphp

          {{-- TERDIAGNOSIS --}}
          <div class="amk-card mb-4 anim-scale-in" style="border-top:3px solid var(--orange);">
            {{-- Header hasil --}}
            <div class="hasil-header" style="background:var(--navy);padding:1.25rem 1.5rem;">
              <div class="d-flex align-items-center gap-3">
                <div style="width:44px;height:44px;background:rgba(255,255,255,.12);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;color:#fff;flex-shrink:0;">
                  <i class="bi bi-check-circle-fill" style="color:var(--orange);"></i>
                </div>
                <div>
                  <div style="font-size:.72rem;opacity:.6;color:#fff;margin-bottom:.2rem;">Diagnosis ditemukan</div>
                  <h4 class="fw-800 mb-0" style="color:#fff;font-size:1.05rem;letter-spacing:-.01em;">{{ $k->nama }}</h4>
                  <span class="kode-badge mt-1 d-inline-block" style="background:rgba(255,255,255,.12);color:rgba(255,255,255,.8);border-color:rgba(255,255,255,.2);">{{ $k->kode }}</span>
                </div>
              </div>
            </div>

            <div class="p-4">

              {{-- Info konsultasi --}}
              <div class="row g-3 mb-4 pb-3" style="border-bottom:1px solid var(--border-light);">
                <div class="col-sm-4">
                  <div class="text-muted" style="font-size:.72rem;font-weight:600;text-transform:uppercase;letter-spacing:.05em;">Tanggal</div>
                  <div class="fw-600 mt-1" style="font-size:.875rem;">{{ $konsultasi->created_at->locale('id')->isoFormat('D MMM Y') }}</div>
                </div>
                <div class="col-sm-4">
                  <div class="text-muted" style="font-size:.72rem;font-weight:600;text-transform:uppercase;letter-spacing:.05em;">Waktu</div>
                  <div class="fw-600 mt-1" style="font-size:.875rem;">{{ $konsultasi->created_at->format('H:i') }} WIB</div>
                </div>
                @if($konsultasi->model_macbook)
                <div class="col-sm-4">
                  <div class="text-muted" style="font-size:.72rem;font-weight:600;text-transform:uppercase;letter-spacing:.05em;">Model</div>
                  <div class="fw-600 mt-1" style="font-size:.875rem;">{{ $konsultasi->model_macbook }}</div>
                </div>
                @endif
              </div>

              {{-- Gejala --}}
              <div class="mb-4">
                <h6 class="fw-700 mb-2" style="font-size:.83rem;color:var(--navy);text-transform:uppercase;letter-spacing:.05em;">
                  <i class="bi bi-list-check me-1 text-orange"></i>Gejala yang Dipilih
                </h6>
                <div>
                  @foreach($konsultasi->gejalas as $g)
                    <span class="gejala-badge"><i class="bi bi-check2"></i>{{ $g->nama }}</span>
                  @endforeach
                </div>
              </div>

              @if($k->deskripsi)
              <div class="mb-4">
                <h6 class="fw-700 mb-2" style="font-size:.83rem;color:var(--navy);text-transform:uppercase;letter-spacing:.05em;">
                  <i class="bi bi-info-circle me-1 text-orange"></i>Tentang Kerusakan
                </h6>
                <p class="text-muted mb-0" style="font-size:.875rem;line-height:1.7;">{{ $k->deskripsi }}</p>
              </div>
              @endif

              @if($k->penyebabs->isNotEmpty())
              <div class="mb-4">
                <h6 class="fw-700 mb-2" style="font-size:.83rem;color:var(--navy);text-transform:uppercase;letter-spacing:.05em;">
                  <i class="bi bi-search me-1 text-orange"></i>Kemungkinan Penyebab
                </h6>
                <div class="d-flex flex-column gap-2">
                  @foreach($k->penyebabs as $p)
                  <div class="d-flex align-items-start gap-2 p-2 rounded" style="background:var(--page-bg);border:1px solid var(--border-light);">
                    <span class="kode-badge flex-shrink-0" style="font-size:.68rem;margin-top:1px;">{{ $p->kode }}</span>
                    <span style="font-size:.85rem;line-height:1.6;">{{ $p->deskripsi }}</span>
                  </div>
                  @endforeach
                </div>
              </div>
              @endif

              @if($k->solusIs->isNotEmpty())
              <div class="mb-4">
                <h6 class="fw-700 mb-2" style="font-size:.83rem;color:var(--navy);text-transform:uppercase;letter-spacing:.05em;">
                  <i class="bi bi-tools me-1 text-orange"></i>Solusi Penanganan Awal
                </h6>
                <div class="d-flex flex-column gap-2">
                  @foreach($k->solusIs as $i => $s)
                  <div class="d-flex align-items-start gap-2 p-2 rounded" style="background:var(--lblue-bg);border:1px solid var(--lblue-light);">
                    <span style="width:22px;height:22px;border-radius:50%;background:var(--lblue-dark);color:#fff;display:flex;align-items:center;justify-content:center;font-size:.68rem;font-weight:800;flex-shrink:0;margin-top:1px;">{{ $i+1 }}</span>
                    <span style="font-size:.85rem;line-height:1.6;">{{ $s->deskripsi }}</span>
                  </div>
                  @endforeach
                </div>
              </div>
              @endif

              <div class="warning-note">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                Hasil ini merupakan <strong>diagnosis awal</strong>. Segera bawa MacBook Anda ke <strong>anaMac Komputer (aMK)</strong> untuk pemeriksaan langsung oleh teknisi.
              </div>

            </div>
          </div>

        @else
          {{-- TIDAK TERDIAGNOSIS --}}
          <div class="amk-card p-5 text-center mb-4 anim-scale-in">
            <div style="width:72px;height:72px;background:var(--page-bg);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1.25rem;font-size:2rem;color:var(--text-light);border:2px solid var(--border);">
              <i class="bi bi-question-circle"></i>
            </div>
            <h4 class="fw-700 mb-2" style="color:var(--navy);">Diagnosis Tidak Ditemukan</h4>
            <p class="text-muted mb-3" style="font-size:.875rem;">Kombinasi gejala yang dipilih tidak cocok dengan aturan diagnosis yang ada.</p>

            @if($konsultasi->gejalas->isNotEmpty())
            <div class="mb-3">
              <div class="text-muted mb-2" style="font-size:.78rem;">Gejala yang Anda pilih:</div>
              @foreach($konsultasi->gejalas as $g)
                <span class="gejala-badge">{{ $g->nama }}</span>
              @endforeach
            </div>
            @endif

            <div class="info-note text-start">
              <i class="bi bi-info-circle me-2"></i>
              Untuk diagnosis yang lebih akurat, kunjungi langsung toko <strong>anaMac Komputer (aMK)</strong>.
            </div>
          </div>
        @endif

        {{-- Action Buttons --}}
        <div class="d-flex flex-wrap justify-content-center gap-3 no-print">
          @if($konsultasi->status_diagnosis === 'terdiagnosis')
          <button id="btnCetak" class="btn-amk" style="padding:.65rem 1.4rem;">
            <i class="bi bi-printer me-1"></i>Cetak Hasil
          </button>
          @endif
          <a href="{{ route('konsultasi') }}" class="btn-amk-outline" style="padding:.63rem 1.35rem;">
            <i class="bi bi-arrow-repeat me-1"></i>Konsultasi Ulang
          </a>
          <a href="{{ route('beranda') }}" class="btn-navy" style="padding:.65rem 1.4rem;">
            <i class="bi bi-house me-1"></i>Beranda
          </a>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection
