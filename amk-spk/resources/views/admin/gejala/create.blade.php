@extends('layouts.admin')
@section('title', 'Tambah Gejala')
@section('content')
<div class="page-header">
  <h1><i class="bi bi-plus-circle text-orange me-2"></i>Tambah Gejala</h1>
  <a href="{{ route('admin.gejala.index') }}" class="btn btn-outline-secondary" style="border-radius:8px;"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
</div>
<div class="row justify-content-center"><div class="col-lg-7">
<div class="admin-card"><div class="admin-card-body">
  <form method="POST" action="{{ route('admin.gejala.store') }}" novalidate>
    @csrf
    <div class="mb-3">
      <label class="form-label">Kode Gejala <span class="text-danger">*</span></label>
      <input type="text" name="kode" value="{{ old('kode', $nextKode) }}" class="form-control @error('kode') is-invalid @enderror" placeholder="Contoh: G030" style="text-transform:uppercase;">
      @error('kode')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
      <label class="form-label">Nama Gejala <span class="text-danger">*</span></label>
      <input type="text" name="nama" value="{{ old('nama') }}" class="form-control @error('nama') is-invalid @enderror" placeholder="Deskripsikan gejala secara singkat">
      @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-4">
      <label class="form-label">Keterangan Tambahan</label>
      <textarea name="deskripsi" rows="3" class="form-control" placeholder="Penjelasan lebih detail tentang gejala ini...">{{ old('deskripsi') }}</textarea>
    </div>
    <div class="d-flex gap-2">
      <button type="submit" class="btn-amk"><i class="bi bi-check-lg"></i>Simpan</button>
      <a href="{{ route('admin.gejala.index') }}" class="btn btn-outline-secondary" style="border-radius:8px;">Batal</a>
    </div>
  </form>
</div></div>
</div></div>
@endsection
