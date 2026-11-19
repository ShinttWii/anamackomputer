@extends('layouts.customer')
@section('title', 'Konsultasi Kerusakan')

@section('content')
<div class="py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8 col-xl-7">

        {{-- Header --}}
        <div class="text-center mb-4">
          <div class="section-line centered"></div>
          <h1 class="section-title">Konsultasi <span>Kerusakan MacBook</span></h1>
          <p class="text-muted" style="font-size:.9rem;">Pilih semua gejala yang dialami MacBook Anda, lalu klik Diagnosa.</p>
        </div>

        @if($errors->any())
          <div class="alert alert-danger alert-dismissible fade show mb-4">
            <i class="bi bi-exclamation-circle-fill me-2"></i>{{ $errors->first() }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        @endif

        <form method="POST" action="{{ route('konsultasi.proses') }}" id="formKonsultasi" novalidate>
          @csrf

          {{-- Model MacBook --}}
          <div class="amk-card p-4 mb-4">
            <div class="d-flex align-items-start gap-3">
              <div style="width:38px;height:38px;background:var(--orange-bg);border-radius:8px;display:flex;align-items:center;justify-content:center;color:var(--orange);flex-shrink:0;font-size:1rem;">
                <i class="bi bi-laptop-fill"></i>
              </div>
              <div class="flex-grow-1">
                <label class="form-label mb-1">Model MacBook <span class="text-muted fw-400" style="font-size:.75rem;">(opsional)</span></label>
                <input type="text" name="model_macbook" value="{{ old('model_macbook') }}"
                       class="form-control"
                       placeholder="Contoh: MacBook Air M1 2020, MacBook Pro 13&quot; 2019">
              </div>
            </div>
          </div>

          {{-- Pilih Gejala --}}
          <div class="amk-card mb-4">
            <div class="p-3 border-bottom d-flex align-items-center justify-content-between gap-3">
              <div>
                <h6 class="fw-700 mb-0" style="font-size:.9rem;color:var(--navy);">
                  <i class="bi bi-list-check text-orange me-2"></i>Pilih Gejala yang Dialami
                </h6>
                <p class="text-muted mb-0" style="font-size:.78rem;margin-top:.2rem;">Centang semua gejala yang sesuai.</p>
              </div>
              <div class="flex-shrink-0">
                <span class="status-badge status-warn">
                  <span id="gejalaCounter" class="counter-el fw-700">0</span>&nbsp;dipilih
                </span>
              </div>
            </div>

            <div style="max-height:420px;overflow-y:auto;">
              @foreach($gejalas as $g)
              <div class="gejala-item">
                <input type="checkbox" name="gejala_ids[]" value="{{ $g->id }}"
                       class="gejala-checkbox" id="g{{ $g->id }}"
                       {{ in_array($g->id, old('gejala_ids', [])) ? 'checked' : '' }}>
                <label for="g{{ $g->id }}" class="flex-grow-1" style="cursor:pointer;">
                  <div class="d-flex align-items-center gap-2 flex-wrap">
                    <span class="kode-badge">{{ $g->kode }}</span>
                    <span class="fw-500" style="font-size:.875rem;">{{ $g->nama }}</span>
                  </div>
                  @if($g->deskripsi)
                    <div class="text-muted mt-1" style="font-size:.75rem;">{{ $g->deskripsi }}</div>
                  @endif
                </label>
              </div>
              @endforeach
            </div>
          </div>

          {{-- Info --}}
          <div class="info-note mb-4" style="font-size:.83rem;">
            <i class="bi bi-lightbulb me-2"></i>
            Pilih gejala yang benar-benar dialami MacBook Anda. Memilih gejala yang tidak relevan dapat memengaruhi akurasi hasil.
          </div>

          {{-- Submit --}}
          <div class="d-flex gap-3 justify-content-center">
            <button type="submit" id="btnDiagnosa" class="btn-amk" style="padding:.7rem 2rem;font-size:.925rem;" disabled>
              <i class="bi bi-cpu-fill me-1"></i>Diagnosa Sekarang
            </button>
            <a href="{{ route('beranda') }}" class="btn-amk-outline" style="padding:.68rem 1.4rem;">
              <i class="bi bi-arrow-left me-1"></i>Kembali
            </a>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>
@endsection
