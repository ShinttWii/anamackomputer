@extends('layouts.admin')
@section('title', 'Riwayat Konsultasi')
@section('content')
<div class="page-header">
  <div>
    <h1><i class="bi bi-clock-history text-orange me-2"></i>Riwayat Konsultasi</h1>
    <div class="page-header-meta">Seluruh riwayat konsultasi yang telah dilakukan</div>
  </div>
</div>

<div class="admin-card">
  <div class="admin-card-header">
    <span class="text-muted" style="font-size:.8rem;">Total: <strong>{{ $konsultasis->total() }}</strong> konsultasi</span>
    <form method="GET" class="d-flex gap-2 flex-wrap">
      <select name="status" class="form-select form-select-sm" style="width:auto;" onchange="this.form.submit()">
        <option value="">Semua Status</option>
        <option value="terdiagnosis" {{ request('status') === 'terdiagnosis' ? 'selected' : '' }}>Terdiagnosis</option>
        <option value="tidak_terdiagnosis" {{ request('status') === 'tidak_terdiagnosis' ? 'selected' : '' }}>Tidak Terdiagnosis</option>
      </select>
      <div class="search-wrap">
        <i class="bi bi-search search-icon"></i>
        <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="Cari model / kerusakan..." style="min-width:190px;padding-left:2.2rem;">
      </div>
      <button type="submit" class="btn btn-sm" style="border-radius:6px;background:var(--navy);color:#fff;border:none;">Cari</button>
      @if(request()->hasAny(['status','search']))<a href="{{ route('admin.riwayat.index') }}" class="btn btn-sm btn-outline-secondary" style="border-radius:6px;">Reset</a>@endif
    </form>
  </div>

  @if($konsultasis->isEmpty())
    <div class="empty-state"><i class="bi bi-inbox"></i><p>Belum ada data riwayat konsultasi.</p></div>
  @else
  <div class="table-responsive">
    <table class="amk-table">
      <thead>
        <tr>
          <th style="width:40px;">No</th>
          <th>Tanggal</th>
          <th class="d-none d-md-table-cell">Model MacBook</th>
          <th>Status</th>
          <th class="d-none d-lg-table-cell">Hasil Diagnosis</th>
          <th class="text-center" style="width:50px;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($konsultasis as $i => $k)
        <tr>
          <td class="text-muted fw-500" style="font-size:.8rem;">{{ $konsultasis->firstItem() + $i }}</td>
          <td>
            <div class="fw-500" style="font-size:.83rem;">{{ $k->created_at->format('d/m/Y') }}</div>
            <div class="text-muted" style="font-size:.72rem;">{{ $k->created_at->format('H:i') }}</div>
          </td>
          <td class="d-none d-md-table-cell" style="font-size:.83rem;">
            @if($k->model_macbook)
              {{ $k->model_macbook }}
            @else
              <span class="text-muted fst-italic">Tidak diisi</span>
            @endif
          </td>
          <td>
            @if($k->status_diagnosis === 'terdiagnosis')
              <span class="status-badge status-ok"><i class="bi bi-check-circle-fill"></i>Terdiagnosis</span>
            @else
              <span class="status-badge status-fail"><i class="bi bi-question-circle"></i>Tidak Terdiagnosis</span>
            @endif
          </td>
          <td class="d-none d-lg-table-cell fw-500" style="font-size:.83rem;">{{ $k->kerusakan?->nama ?? '—' }}</td>
          <td class="text-center">
            <a href="{{ route('admin.riwayat.show', $k->id) }}" class="btn-act view">
              <i class="bi bi-eye-fill"></i>
            </a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  @if($konsultasis->hasPages())<div class="admin-card-footer">{{ $konsultasis->links() }}</div>@endif
  @endif
</div>
@endsection
