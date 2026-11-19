@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')

{{-- Welcome --}}
<div class="welcome-banner">
  <h4>Selamat Datang, {{ session('admin_nama', 'Admin') }}!</h4>
  <p>Panel Administrasi Sistem Pakar Diagnosis Kerusakan MacBook &mdash; anaMac Komputer</p>
  <div class="welcome-date">
    <i class="bi bi-calendar3 me-1"></i>{{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
  </div>
</div>

{{-- Stat Cards --}}
<div class="row g-3 mb-4">
  <div class="col-6 col-xl-3 anim-fade-up anim-delay-1">
    <div class="stat-card sc-orange">
      <div class="s-icon"><i class="bi bi-exclamation-triangle-fill"></i></div>
      <div class="s-num">{{ $stats['kerusakan'] }}</div>
      <div class="s-label">Jenis Kerusakan</div>
    </div>
  </div>
  <div class="col-6 col-xl-3 anim-fade-up anim-delay-2">
    <div class="stat-card sc-blue">
      <div class="s-icon"><i class="bi bi-clipboard2-pulse-fill"></i></div>
      <div class="s-num">{{ $stats['gejala'] }}</div>
      <div class="s-label">Data Gejala</div>
    </div>
  </div>
  <div class="col-6 col-xl-3 anim-fade-up anim-delay-3">
    <div class="stat-card sc-green">
      <div class="s-icon"><i class="bi bi-diagram-3-fill"></i></div>
      <div class="s-num">{{ $stats['aturan'] }}</div>
      <div class="s-label">Aturan Diagnosis</div>
    </div>
  </div>
  <div class="col-6 col-xl-3 anim-fade-up anim-delay-4">
    <div class="stat-card sc-navy">
      <div class="s-icon"><i class="bi bi-clock-history"></i></div>
      <div class="s-num">{{ $stats['konsultasi'] }}</div>
      <div class="s-label">Total Konsultasi</div>
    </div>
  </div>
</div>

<div class="row g-3 mb-4">
  {{-- Statistik Diagnosis --}}
  <div class="col-md-6">
    <div class="admin-card h-100">
      <div class="admin-card-header">
        <h6><i class="bi bi-bar-chart-fill text-orange me-2"></i>Statistik Diagnosis</h6>
      </div>
      <div class="admin-card-body">
        <div class="row g-3">
          <div class="col-6">
            <div class="text-center p-3 rounded" style="background:var(--orange-bg);border:1px solid var(--orange-light);">
              <div class="fw-800" style="font-size:1.75rem;color:var(--orange);line-height:1;">{{ $stats['terdiagnosis'] }}</div>
              <div class="text-muted mt-1" style="font-size:.78rem;">Terdiagnosis</div>
            </div>
          </div>
          <div class="col-6">
            <div class="text-center p-3 rounded" style="background:var(--page-bg);border:1px solid var(--border);">
              <div class="fw-800" style="font-size:1.75rem;color:var(--text-muted);line-height:1;">{{ $stats['tidak_terdiagnosis'] }}</div>
              <div class="text-muted mt-1" style="font-size:.78rem;">Tidak Terdiagnosis</div>
            </div>
          </div>
        </div>
        @php $total = $stats['terdiagnosis'] + $stats['tidak_terdiagnosis']; $pct = $total > 0 ? round($stats['terdiagnosis'] / $total * 100) : 0; @endphp
        <div class="mt-3">
          <div class="d-flex justify-content-between mb-1">
            <small class="text-muted">Tingkat keberhasilan diagnosis</small>
            <small class="fw-700 text-orange">{{ $pct }}%</small>
          </div>
          <div class="progress" style="height:6px;border-radius:3px;background:var(--border);">
            <div class="progress-bar" role="progressbar" style="width:{{ $pct }}%;background:var(--orange);border-radius:3px;" aria-valuenow="{{ $pct }}" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Akses Cepat --}}
  <div class="col-md-6">
    <div class="admin-card h-100">
      <div class="admin-card-header">
        <h6><i class="bi bi-lightning-charge-fill text-orange me-2"></i>Akses Cepat</h6>
      </div>
      <div class="admin-card-body">
        <div class="row g-2">
          <div class="col-6">
            <a href="{{ route('admin.kerusakan.create') }}" class="d-flex align-items-center gap-2 p-2 rounded text-decoration-none" style="background:var(--orange-bg);border:1px solid var(--orange-light);transition:var(--transition);" onmouseover="this.style.background='var(--orange)';this.style.color='#fff'" onmouseout="this.style.background='var(--orange-bg)';this.style.color=''">
              <i class="bi bi-plus-circle-fill text-orange" style="font-size:1.1rem;"></i>
              <span style="font-size:.8rem;font-weight:600;">Tambah Kerusakan</span>
            </a>
          </div>
          <div class="col-6">
            <a href="{{ route('admin.gejala.create') }}" class="d-flex align-items-center gap-2 p-2 rounded text-decoration-none" style="background:var(--lblue-bg);border:1px solid var(--lblue-light);transition:var(--transition);" onmouseover="this.style.background='var(--lblue-dark)';this.style.color='#fff'" onmouseout="this.style.background='var(--lblue-bg)';this.style.color=''">
              <i class="bi bi-plus-circle-fill" style="font-size:1.1rem;color:var(--lblue-dark);"></i>
              <span style="font-size:.8rem;font-weight:600;">Tambah Gejala</span>
            </a>
          </div>
          <div class="col-6">
            <a href="{{ route('admin.aturan.create') }}" class="d-flex align-items-center gap-2 p-2 rounded text-decoration-none" style="background:var(--navy-bg);border:1px solid var(--navy-light);transition:var(--transition);" onmouseover="this.style.background='var(--navy)';this.style.color='#fff'" onmouseout="this.style.background='var(--navy-bg)';this.style.color=''">
              <i class="bi bi-plus-circle-fill" style="font-size:1.1rem;color:var(--navy);"></i>
              <span style="font-size:.8rem;font-weight:600;">Tambah Aturan</span>
            </a>
          </div>
          <div class="col-6">
            <a href="{{ route('admin.riwayat.index') }}" class="d-flex align-items-center gap-2 p-2 rounded text-decoration-none" style="background:var(--page-bg);border:1px solid var(--border);transition:var(--transition);" onmouseover="this.style.background='var(--text-dark)';this.style.color='#fff'" onmouseout="this.style.background='var(--page-bg)';this.style.color=''">
              <i class="bi bi-clock-history text-muted" style="font-size:1.1rem;"></i>
              <span style="font-size:.8rem;font-weight:600;">Lihat Riwayat</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Top 3 Kerusakan Terbanyak --}}
<div class="admin-card mb-4">
  <div class="admin-card-header">
    <h6><i class="bi bi-bar-chart-fill text-orange me-2"></i>Kerusakan Paling Sering Terdiagnosis</h6>
    <span class="text-muted" style="font-size:.78rem;">Berdasarkan hasil diagnosis</span>
  </div>
  @if($topKerusakan->isEmpty())
    <div class="empty-state py-4">
      <i class="bi bi-bar-chart"></i>
      <p>Belum ada data diagnosis.</p>
    </div>
  @else
  <div class="admin-card-body">
    @php
      $maxTotal = $topKerusakan->first()->total;
      $medals   = ['🥇','🥈','🥉'];
      $barColors = ['var(--orange)', 'var(--lblue-dark)', '#16a34a'];
    @endphp
    <div class="d-flex flex-column gap-3">
      @foreach($topKerusakan as $i => $item)
      <div>
        <div class="d-flex align-items-center justify-content-between mb-1">
          <div class="d-flex align-items-center gap-2">
            <span style="font-size:1.1rem;">{{ $medals[$i] }}</span>
            <div>
              <span class="fw-600" style="font-size:.875rem;color:var(--navy);">
                {{ $item->kerusakan?->nama ?? '—' }}
              </span>
              <span class="kode-badge ms-2" style="font-size:.68rem;">
                {{ $item->kerusakan?->kode }}
              </span>
            </div>
          </div>
          <span class="fw-700" style="font-size:.875rem;color:{{ $barColors[$i] }};">
            {{ $item->total }}x
          </span>
        </div>
        <div style="background:var(--border-light);border-radius:4px;height:8px;overflow:hidden;">
          <div style="height:100%;border-radius:4px;background:{{ $barColors[$i] }};width:{{ $maxTotal > 0 ? round($item->total / $maxTotal * 100) : 0 }}%;transition:width .6s ease;"></div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
  @endif
</div>

{{-- Konsultasi Terbaru --}}
<div class="admin-card">
  <div class="admin-card-header">
    <h6><i class="bi bi-clock-history text-orange me-2"></i>Konsultasi Terbaru</h6>
    <a href="{{ route('admin.riwayat.index') }}" class="btn btn-sm btn-outline-secondary" style="border-radius:6px;font-size:.78rem;padding:.3rem .7rem;">Lihat Semua</a>
  </div>
  @if($riwayatTerbaru->isEmpty())
    <div class="empty-state"><i class="bi bi-inbox"></i><p>Belum ada data konsultasi</p></div>
  @else
  <div class="table-responsive">
    <table class="amk-table">
      <thead>
        <tr>
          <th style="width:40px;">#</th>
          <th>Tanggal</th>
          <th>Model MacBook</th>
          <th>Status</th>
          <th>Hasil Diagnosis</th>
          <th style="width:50px;"></th>
        </tr>
      </thead>
      <tbody>
        @foreach($riwayatTerbaru as $i => $r)
        <tr>
          <td class="text-muted fw-500">{{ $i + 1 }}</td>
          <td>
            <div style="font-size:.83rem;font-weight:500;">{{ $r->created_at->format('d/m/Y') }}</div>
            <div class="text-muted" style="font-size:.72rem;">{{ $r->created_at->format('H:i') }}</div>
          </td>
          <td>
            @if($r->model_macbook)
              <span style="font-size:.83rem;">{{ $r->model_macbook }}</span>
            @else
              <span class="text-muted" style="font-size:.83rem;">—</span>
            @endif
          </td>
          <td>
            @if($r->status_diagnosis === 'terdiagnosis')
              <span class="status-badge status-ok"><i class="bi bi-check-circle-fill"></i>Terdiagnosis</span>
            @else
              <span class="status-badge status-fail"><i class="bi bi-question-circle"></i>Tidak Terdiagnosis</span>
            @endif
          </td>
          <td style="font-size:.83rem;">{{ $r->kerusakan?->nama ?? '—' }}</td>
          <td>
            <a href="{{ route('admin.riwayat.show', $r->id) }}" class="btn-act view" data-bs-toggle="tooltip" title="Lihat Detail">
              <i class="bi bi-eye"></i>
            </a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  @endif
</div>

@endsection
