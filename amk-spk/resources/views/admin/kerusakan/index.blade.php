@extends('layouts.admin')
@section('title', 'Data Kerusakan')

@section('content')
<div class="page-header">
  <div>
    <h1><i class="bi bi-exclamation-triangle-fill text-orange me-2"></i>Data Kerusakan</h1>
    <div class="page-header-meta">Daftar jenis kerusakan MacBook dalam basis pengetahuan</div>
  </div>
  <a href="{{ route('admin.kerusakan.create') }}" class="btn-amk">
    <i class="bi bi-plus-lg me-1"></i>Tambah Kerusakan
  </a>
</div>

<div class="admin-card">
  <div class="admin-card-header">
    <span class="text-muted" style="font-size:.8rem;">Total: <strong>{{ $kerusakans->total() }}</strong> data</span>
    <form method="GET" action="{{ route('admin.kerusakan.index') }}" class="d-flex gap-2">
      <div class="search-wrap">
        <i class="bi bi-search search-icon"></i>
        <input type="text" name="search" value="{{ request('search') }}"
               class="form-control form-control-sm" placeholder="Cari kode / nama..."
               style="min-width:210px;padding-left:2.2rem;">
      </div>
      <button type="submit" class="btn btn-sm btn-navy" style="border-radius:6px;background:var(--navy);color:#fff;border:none;">Cari</button>
      @if(request('search'))
        <a href="{{ route('admin.kerusakan.index') }}" class="btn btn-sm btn-outline-secondary" style="border-radius:6px;">Reset</a>
      @endif
    </form>
  </div>

  @if($kerusakans->isEmpty())
    <div class="empty-state"><i class="bi bi-exclamation-triangle"></i><p>Belum ada data kerusakan.</p></div>
  @else
    <div class="table-responsive">
      <table class="amk-table">
        <thead>
          <tr>
            <th style="width:40px;">No</th>
            <th style="width:80px;">Kode</th>
            <th>Nama Kerusakan</th>
            <th class="d-none d-md-table-cell">Deskripsi</th>
            <th class="text-center" style="width:80px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($kerusakans as $i => $k)
          <tr>
            <td class="text-muted fw-500" style="font-size:.8rem;">{{ $kerusakans->firstItem() + $i }}</td>
            <td><span class="kode-badge">{{ $k->kode }}</span></td>
            <td class="fw-600" style="font-size:.875rem;">{{ $k->nama }}</td>
            <td class="text-muted d-none d-md-table-cell" style="font-size:.83rem;">{{ Str::limit($k->deskripsi, 75) }}</td>
            <td class="text-center">
              <div class="d-flex gap-1 justify-content-center">
                <a href="{{ route('admin.kerusakan.edit', $k->id) }}" class="btn-act edit" data-bs-toggle="tooltip" title="Edit">
                  <i class="bi bi-pencil-fill"></i>
                </a>
                <form method="POST" action="{{ route('admin.kerusakan.destroy', $k->id) }}" class="d-inline">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn-act delete btn-confirm-delete" data-bs-toggle="tooltip" title="Hapus">
                    <i class="bi bi-trash-fill"></i>
                  </button>
                </form>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    @if($kerusakans->hasPages())
      <div class="admin-card-footer">{{ $kerusakans->links() }}</div>
    @endif
  @endif
</div>
@endsection
