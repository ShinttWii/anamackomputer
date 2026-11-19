@extends('layouts.admin')
@section('title', 'Edit Solusi')
@section('content')
<div class="page-header">
  <h1><i class="bi bi-pencil-square text-orange me-2"></i>Edit Solusi</h1>
  <a href="{{ route('admin.solusi.index') }}" class="btn btn-outline-secondary" style="border-radius:8px;"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
</div>
<div class="row justify-content-center"><div class="col-lg-7">
<div class="admin-card"><div class="admin-card-body">
  <form method="POST" action="{{ route('admin.solusi.update', $solusi->id) }}" novalidate>
    @csrf @method('PUT')
    <div class="mb-3">
      <label class="form-label">Kode Solusi <span class="text-danger">*</span></label>
      <input type="text" name="kode" value="{{ old('kode', $solusi->kode) }}" class="form-control @error('kode') is-invalid @enderror" style="text-transform:uppercase;">
      @error('kode')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
      <label class="form-label">Jenis Kerusakan <span class="text-danger">*</span></label>
      <select name="kerusakan_id" class="form-select @error('kerusakan_id') is-invalid @enderror">
        <option value="">-- Pilih Kerusakan --</option>
        @foreach($kerusakans as $k)
          <option value="{{ $k->id }}" {{ old('kerusakan_id', $solusi->kerusakan_id) == $k->id ? 'selected' : '' }}>{{ $k->kode }} — {{ $k->nama }}</option>
        @endforeach
      </select>
      @error('kerusakan_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-4">
      <label class="form-label">Deskripsi Solusi <span class="text-danger">*</span></label>
      <textarea name="deskripsi" rows="3" class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi', $solusi->deskripsi) }}</textarea>
      @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="d-flex gap-2">
      <button type="submit" class="btn-amk"><i class="bi bi-check-lg"></i>Perbarui</button>
      <a href="{{ route('admin.solusi.index') }}" class="btn btn-outline-secondary" style="border-radius:8px;">Batal</a>
    </div>
  </form>
</div></div>
</div></div>
@endsection
