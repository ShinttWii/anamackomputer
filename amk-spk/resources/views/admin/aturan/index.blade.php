@extends('layouts.admin')
@section('title', 'Aturan Diagnosis')
@section('content')
<div class="page-header">
  <div>
    <h1><i class="bi bi-diagram-3-fill text-orange me-2"></i>Aturan Diagnosis</h1>
    <div class="page-header-meta">Basis aturan Forward Chaining untuk proses inferensi</div>
  </div>
  <a href="{{ route('admin.aturan.create') }}" class="btn-amk"><i class="bi bi-plus-lg me-1"></i>Tambah Aturan</a>
</div>

<div class="info-note mb-4" style="font-size:.83rem;">
  <i class="bi bi-info-circle me-2"></i>
  Setiap aturan bekerja sebagai: <strong>JIKA</strong> semua gejala kondisi terpenuhi, <strong>MAKA</strong> kerusakan tersebut terdiagnosis. Perubahan aturan langsung memengaruhi hasil diagnosis.
</div>

<div class="admin-card">
  <div class="admin-card-header">
    <span class="text-muted" style="font-size:.8rem;">Total: <strong>{{ $aturans->total() }}</strong> aturan</span>
    <form method="GET" class="d-flex gap-2">
      <div class="search-wrap">
        <i class="bi bi-search search-icon"></i>
        <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="Cari kode / kerusakan..." style="min-width:210px;padding-left:2.2rem;">
      </div>
      <button type="submit" class="btn btn-sm" style="border-radius:6px;background:var(--navy);color:#fff;border:none;">Cari</button>
      @if(request('search'))<a href="{{ route('admin.aturan.index') }}" class="btn btn-sm btn-outline-secondary" style="border-radius:6px;">Reset</a>@endif
    </form>
  </div>

  @if($aturans->isEmpty())
    <div class="empty-state"><i class="bi bi-diagram-3"></i><p>Belum ada aturan diagnosis.</p></div>
  @else
  <div class="table-responsive">
    <table class="amk-table">
      <thead>
        <tr>
          <th style="width:40px;">No</th>
          <th style="width:80px;">Kode</th>
          <th>Kondisi (IF)</th>
          <th>Kesimpulan (THEN)</th>
          <th class="text-center" style="width:80px;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($aturans as $i => $a)
        <tr>
          <td class="text-muted fw-500" style="font-size:.8rem;">{{ $aturans->firstItem() + $i }}</td>
          <td><span class="kode-badge">{{ $a->kode }}</span></td>
          <td>
            @if($a->gejalas->isEmpty())
              <span class="text-muted fst-italic" style="font-size:.82rem;">Belum ada kondisi</span>
            @else
              <div class="d-flex flex-wrap gap-1">
                @foreach($a->gejalas as $g)
                  <span class="status-badge" style="background:var(--lblue-bg);color:var(--lblue-dark);border:1px solid var(--lblue-light);font-size:.7rem;">{{ $g->kode }}</span>
                @endforeach
              </div>
              <div class="text-muted mt-1" style="font-size:.73rem;">{{ $a->gejalas->count() }} gejala</div>
            @endif
          </td>
          <td>
            <div class="fw-600" style="font-size:.875rem;">{{ $a->kerusakan?->nama }}</div>
            <span class="kode-badge" style="font-size:.68rem;margin-top:.2rem;display:inline-block;">{{ $a->kerusakan?->kode }}</span>
          </td>
          <td class="text-center">
            <div class="d-flex gap-1 justify-content-center">
              <a href="{{ route('admin.aturan.edit', $a->id) }}" class="btn-act edit"><i class="bi bi-pencil-fill"></i></a>
              <form method="POST" action="{{ route('admin.aturan.destroy', $a->id) }}" class="d-inline">
                @csrf @method('DELETE')
                <button type="submit" class="btn-act delete btn-confirm-delete"><i class="bi bi-trash-fill"></i></button>
              </form>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  @if($aturans->hasPages())<div class="admin-card-footer">{{ $aturans->links() }}</div>@endif
  @endif
</div>
@endsection
