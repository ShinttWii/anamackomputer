@extends('layouts.admin')
@section('title', 'Edit Gejala')
@section('content')
<div class="page-header">
  <h1><i class="bi bi-pencil-square text-orange me-2"></i>Edit Gejala</h1>
  <a href="{{ route('admin.gejala.index') }}" class="btn btn-outline-secondary" style="border-radius:8px;"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
</div>
<div class="row justify-content-center"><div class="col-lg-7">
<div class="admin-card"><div class="admin-card-body">
  <form method="POST" action="{{ route('admin.gejala.update', $gejala->id) }}" novalidate>
    @csrf @method('PUT')
    <div class="mb-3">
      <label class="form-label">Kode Gejala <span class="text-danger">*</span></label>
      <input type="text" name="kode" value="{{ old('kode', $gejala->kode) }}" class="form-control @error('kode') is-invalid @enderror" style="text-transform:uppercase;">
      @error('kode')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
      <label class="form-label">Nama Gejala <span class="text-danger">*</span></label>
      <input type="text" name="nama" value="{{ old('nama', $gejala->nama) }}" class="form-control @error('nama') is-invalid @enderror">
      @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-4">
      <label class="form-label">Keterangan Tambahan</label>
      <textarea name="deskripsi" rows="3" class="form-control">{{ old('deskripsi', $gejala->deskripsi) }}</textarea>
    </div>
    <div class="d-flex gap-2">
      <button type="submit" class="btn-amk"><i class="bi bi-check-lg"></i>Perbarui</button>
      <a href="{{ route('admin.gejala.index') }}" class="btn btn-outline-secondary" style="border-radius:8px;">Batal</a>
    </div>
  </form>
</div></div>
</div></div>
@endsection
