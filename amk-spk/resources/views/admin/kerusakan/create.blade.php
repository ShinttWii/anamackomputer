@extends('layouts.admin')
@section('title', 'Tambah Kerusakan')

@section('content')
<div class="page-header">
  <h1><i class="bi bi-plus-circle text-orange me-2"></i>Tambah Kerusakan</h1>
  <a href="{{ route('admin.kerusakan.index') }}" class="btn btn-outline-secondary" style="border-radius:8px;">
    <i class="bi bi-arrow-left me-1"></i>Kembali
  </a>
</div>

<div class="row justify-content-center">
  <div class="col-lg-7">
    <div class="admin-card">
      <div class="admin-card-body">
        <form method="POST" action="{{ route('admin.kerusakan.store') }}" novalidate>
          @csrf
          <div class="mb-3">
            <label class="form-label">Kode Kerusakan <span class="text-danger">*</span></label>
            <input type="text" name="kode" value="{{ old('kode', $nextKode) }}"
                   class="form-control @error('kode') is-invalid @enderror"
                   placeholder="Contoh: K011" style="text-transform:uppercase;">
            @error('kode')<div class="invalid-feedback">{{ $message }}</div>@enderror
            <div class="form-text">Kode unik, maksimal 10 karakter.</div>
          </div>
          <div class="mb-3">
            <label class="form-label">Nama Kerusakan <span class="text-danger">*</span></label>
            <input type="text" name="nama" value="{{ old('nama') }}"
                   class="form-control @error('nama') is-invalid @enderror"
                   placeholder="Contoh: Kerusakan Baterai">
            @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="mb-4">
            <label class="form-label">Deskripsi</label>
            <textarea name="deskripsi" rows="4" class="form-control @error('deskripsi') is-invalid @enderror"
                      placeholder="Jelaskan kerusakan ini secara singkat...">{{ old('deskripsi') }}</textarea>
            @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="d-flex gap-2">
            <button type="submit" class="btn-amk"><i class="bi bi-check-lg"></i>Simpan</button>
            <a href="{{ route('admin.kerusakan.index') }}" class="btn btn-outline-secondary" style="border-radius:8px;">Batal</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
