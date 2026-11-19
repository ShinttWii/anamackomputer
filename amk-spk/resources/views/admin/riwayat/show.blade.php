@extends('layouts.admin')
@section('title', 'Detail Konsultasi #' . $konsultasi->id)
@section('content')

<div class="page-header">
  <div>
    <h1><i class="bi bi-file-earmark-text text-orange me-2"></i>Detail Konsultasi</h1>
    <div class="page-header-meta">ID #{{ $konsultasi->id }} &mdash; {{ $konsultasi->created_at->locale('id')->isoFormat('D MMMM Y, HH:mm') }}</div>
  </div>
  <a href="{{ route('admin.riwayat.index') }}" class="btn btn-sm btn-outline-secondary" style="border-radius:6px;">
    <i class="bi bi-arrow-left me-1"></i>Kembali
  </a>
</div>

<div class="row g-4">

  {{-- Info --}}
  <div class="col-lg-5">
    <div class="admin-card h-100">
      <div class="admin-card-header"><h6><i class="bi bi-info-circle text-orange me-2"></i>Informasi Konsultasi</h6></div>
      <div class="admin-card-body">
        <dl class="mb-0" style="display:grid;grid-template-columns:auto 1fr;gap:.5rem 1rem;">
          <dt class="text-muted fw-500" style="font-size:.78rem;white-space:nowrap;">ID</dt>
          <dd class="mb-0 fw-600" style="font-size:.875rem;">#{{ $konsultasi->id }}</dd>

          <dt class="text-muted fw-500" style="font-size:.78rem;">Tanggal</dt>
          <dd class="mb-0" style="font-size:.875rem;">{{ $konsultasi->created_at->locale('id')->isoFormat('D MMMM Y') }}</dd>

          <dt class="text-muted fw-500" style="font-size:.78rem;">Waktu</dt>
          <dd class="mb-0" style="font-size:.875rem;">{{ $konsultasi->created_at->format('H:i') }} WIB</dd>

          <dt class="text-muted fw-500" style="font-size:.78rem;">Model</dt>
          <dd class="mb-0" style="font-size:.875rem;">
            @if($konsultasi->model_macbook)
              {{ $konsultasi->model_macbook }}
            @else
              <span class="text-muted fst-italic">Tidak diisi</span>
            @endif
          </dd>

          <dt class="text-muted fw-500" style="font-size:.78rem;">Status</dt>
          <dd class="mb-0">
            @if($konsultasi->status_diagnosis === 'terdiagnosis')
              <span class="status-badge status-ok"><i class="bi bi-check-circle-fill"></i>Terdiagnosis</span>
            @else
              <span class="status-badge status-fail"><i class="bi bi-question-circle"></i>Tidak Terdiagnosis</span>
            @endif
          </dd>
        </dl>
      </div>
    </div>
  </div>

  {{-- Gejala --}}
  <div class="col-lg-7">
    <div class="admin-card h-100">
      <div class="admin-card-header">
        <h6><i class="bi bi-list-check text-orange me-2"></i>Gejala yang Dipilih</h6>
        <span class="status-badge status-warn">{{ $konsultasi->gejalas->count() }} gejala</span>
      </div>
      <div class="admin-card-body">
        @if($konsultasi->gejalas->isEmpty())
          <p class="text-muted fst-italic mb-0" style="font-size:.875rem;">Tidak ada data gejala.</p>
        @else
          <div class="d-flex flex-wrap gap-2">
            @foreach($konsultasi->gejalas as $g)
              <span class="gejala-badge"><i class="bi bi-check2 me-1"></i>{{ $g->kode }} — {{ $g->nama }}</span>
            @endforeach
          </div>
        @endif
      </div>
    </div>
  </div>

  {{-- Hasil --}}
  <div class="col-12">
    @if($konsultasi->status_diagnosis === 'terdiagnosis' && $konsultasi->kerusakan)
      @php $k = $konsultasi->kerusakan; @endphp
      <div class="admin-card" style="border-top:3px solid var(--orange);">
        <div class="admin-card-header" style="background:var(--orange-bg);">
          <div>
            <h6 class="fw-700 text-orange mb-1"><i class="bi bi-check-circle-fill me-2"></i>Hasil Diagnosis Ditemukan</h6>
            <div class="text-muted" style="font-size:.82rem;">{{ $k->kode }} — {{ $k->nama }}</div>
          </div>
        </div>
        <div class="admin-card-body">
          @if($k->deskripsi)
            <p class="text-muted mb-4" style="font-size:.875rem;line-height:1.7;">{{ $k->deskripsi }}</p>
          @endif
          <div class="row g-4">
            <div class="col-md-6">
              <h6 class="fw-700 mb-3" style="font-size:.78rem;color:var(--navy);text-transform:uppercase;letter-spacing:.07em;">
                <i class="bi bi-search me-1 text-orange"></i>Kemungkinan Penyebab
              </h6>
              @if($k->penyebabs->isEmpty())
                <p class="text-muted mb-0" style="font-size:.83rem;">—</p>
              @else
                <div class="d-flex flex-column gap-2">
                  @foreach($k->penyebabs as $p)
                    <div class="d-flex gap-2 p-2 rounded" style="background:var(--page-bg);border:1px solid var(--border-light);">
                      <span class="kode-badge flex-shrink-0" style="font-size:.68rem;">{{ $p->kode }}</span>
                      <span style="font-size:.83rem;line-height:1.55;">{{ $p->deskripsi }}</span>
                    </div>
                  @endforeach
                </div>
              @endif
            </div>
            <div class="col-md-6">
              <h6 class="fw-700 mb-3" style="font-size:.78rem;color:var(--navy);text-transform:uppercase;letter-spacing:.07em;">
                <i class="bi bi-tools me-1 text-orange"></i>Solusi Penanganan
              </h6>
              @if($k->solusIs->isEmpty())
                <p class="text-muted mb-0" style="font-size:.83rem;">—</p>
              @else
                <div class="d-flex flex-column gap-2">
                  @foreach($k->solusIs as $idx => $s)
                    <div class="d-flex gap-2 p-2 rounded" style="background:var(--lblue-bg);border:1px solid var(--lblue-light);">
                      <span style="width:20px;height:20px;border-radius:50%;background:var(--lblue-dark);color:#fff;display:flex;align-items:center;justify-content:center;font-size:.68rem;font-weight:800;flex-shrink:0;">{{ $idx+1 }}</span>
                      <span style="font-size:.83rem;line-height:1.55;">{{ $s->deskripsi }}</span>
                    </div>
                  @endforeach
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    @else
      <div class="admin-card">
        <div class="admin-card-body text-center py-5">
          <div style="font-size:2.5rem;color:var(--text-light);margin-bottom:1rem;"><i class="bi bi-question-circle"></i></div>
          <p class="fw-600 mb-1" style="color:var(--navy);">Diagnosis Tidak Ditemukan</p>
          <p class="text-muted mb-0" style="font-size:.875rem;">Kombinasi gejala tidak cocok dengan aturan yang tersimpan.</p>
        </div>
      </div>
    @endif
  </div>

</div>
@endsection
