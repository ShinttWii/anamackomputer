@extends('layouts.admin')
@section('title', 'Data Penyebab')
@section('content')
<div class="page-header">
  <div>
    <h1><i class="bi bi-search-heart-fill text-orange me-2"></i>Data Penyebab</h1>
    <div class="page-header-meta">Kemungkinan penyebab untuk setiap jenis kerusakan</div>
  </div>
  <a href="{{ route('admin.penyebab.create') }}" class="btn-amk"><i class="bi bi-plus-lg me-1"></i>Tambah Penyebab</a>
</div>
<div class="admin-card">
  <div class="admin-card-header">
    <span class="text-muted" style="font-size:.8rem;">Total: <strong>{{ $penyebabs->total() }}</strong> data</span>
    <form method="GET" class="d-flex gap-2 flex-wrap">
      <select name="kerusakan_id" class="form-select form-select-sm" style="width:auto;min-width:160px;" onchange="this.form.submit()">
        <option value="">Semua Kerusakan</option>
        @foreach($kerusakans as $k)<option value="{{ $k->id }}" {{ request('kerusakan_id') == $k->id ? 'selected' : '' }}>{{ $k->kode }} – {{ $k->nama }}</option>@endforeach
      </select>
      <div class="search-wrap">
        <i class="bi bi-search search-icon"></i>
        <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="Cari penyebab..." style="min-width:180px;padding-left:2.2rem;">
      </div>
      <button type="submit" class="btn btn-sm" style="border-radius:6px;background:var(--navy);color:#fff;border:none;">Cari</button>
    </form>
  </div>
  @if($penyebabs->isEmpty())
    <div class="empty-state"><i class="bi bi-search"></i><p>Belum ada data penyebab.</p></div>
  @else
  <div class="table-responsive">
    <table class="amk-table">
      <thead><tr><th style="width:40px;">No</th><th style="width:80px;">Kode</th><th style="width:100px;">Kerusakan</th><th>Deskripsi Penyebab</th><th class="text-center" style="width:80px;">Aksi</th></tr></thead>
      <tbody>
        @foreach($penyebabs as $i => $p)
        <tr>
          <td class="text-muted fw-500" style="font-size:.8rem;">{{ $penyebabs->firstItem() + $i }}</td>
          <td><span class="kode-badge">{{ $p->kode }}</span></td>
          <td><span class="status-badge status-warn" style="font-size:.72rem;">{{ $p->kerusakan?->kode }}</span></td>
          <td style="font-size:.875rem;">{{ Str::limit($p->deskripsi, 80) }}</td>
          <td class="text-center">
            <div class="d-flex gap-1 justify-content-center">
              <a href="{{ route('admin.penyebab.edit', $p->id) }}" class="btn-act edit"><i class="bi bi-pencil-fill"></i></a>
              <form method="POST" action="{{ route('admin.penyebab.destroy', $p->id) }}" class="d-inline">
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
  @if($penyebabs->hasPages())<div class="admin-card-footer">{{ $penyebabs->links() }}</div>@endif
  @endif
</div>
@endsection
