@extends('layouts.admin')
@section('title', 'Data Gejala')

@section('content')
<div class="page-header">
  <div>
    <h1><i class="bi bi-clipboard2-pulse-fill text-orange me-2"></i>Data Gejala</h1>
    <div class="page-header-meta">Daftar gejala yang digunakan dalam proses diagnosis</div>
  </div>
  <a href="{{ route('admin.gejala.create') }}" class="btn-amk"><i class="bi bi-plus-lg me-1"></i>Tambah Gejala</a>
</div>
<div class="admin-card">
  <div class="admin-card-header">
    <span class="text-muted" style="font-size:.8rem;">Total: <strong>{{ $gejalas->total() }}</strong> data</span>
    <form method="GET" class="d-flex gap-2">
      <div class="search-wrap">
        <i class="bi bi-search search-icon"></i>
        <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="Cari kode / nama..." style="min-width:210px;padding-left:2.2rem;">
      </div>
      <button type="submit" class="btn btn-sm" style="border-radius:6px;background:var(--navy);color:#fff;border:none;">Cari</button>
      @if(request('search'))<a href="{{ route('admin.gejala.index') }}" class="btn btn-sm btn-outline-secondary" style="border-radius:6px;">Reset</a>@endif
    </form>
  </div>
  @if($gejalas->isEmpty())
    <div class="empty-state"><i class="bi bi-clipboard2-x"></i><p>Belum ada data gejala.</p></div>
  @else
  <div class="table-responsive">
    <table class="amk-table">
      <thead><tr><th style="width:40px;">No</th><th style="width:80px;">Kode</th><th>Nama Gejala</th><th class="d-none d-lg-table-cell">Keterangan</th><th class="text-center" style="width:80px;">Aksi</th></tr></thead>
      <tbody>
        @foreach($gejalas as $i => $g)
        <tr>
          <td class="text-muted fw-500" style="font-size:.8rem;">{{ $gejalas->firstItem() + $i }}</td>
          <td><span class="kode-badge">{{ $g->kode }}</span></td>
          <td class="fw-500" style="font-size:.875rem;">{{ $g->nama }}</td>
          <td class="text-muted d-none d-lg-table-cell" style="font-size:.83rem;">{{ Str::limit($g->deskripsi, 70) }}</td>
          <td class="text-center">
            <div class="d-flex gap-1 justify-content-center">
              <a href="{{ route('admin.gejala.edit', $g->id) }}" class="btn-act edit"><i class="bi bi-pencil-fill"></i></a>
              <form method="POST" action="{{ route('admin.gejala.destroy', $g->id) }}" class="d-inline">
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
  @if($gejalas->hasPages())<div class="admin-card-footer">{{ $gejalas->links() }}</div>@endif
  @endif
</div>
@endsection
