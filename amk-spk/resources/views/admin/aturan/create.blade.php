@extends('layouts.admin')
@section('title', 'Tambah Aturan Diagnosis')
@section('content')
<div class="page-header">
  <h1><i class="bi bi-plus-circle text-orange me-2"></i>Tambah Aturan Diagnosis</h1>
  <a href="{{ route('admin.aturan.index') }}" class="btn btn-outline-secondary" style="border-radius:8px;"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
</div>
<div class="row justify-content-center"><div class="col-lg-8">
<div class="admin-card"><div class="admin-card-body">
  <form method="POST" action="{{ route('admin.aturan.store') }}" novalidate>
    @csrf

    <div class="row g-3 mb-4">
      <div class="col-md-4">
        <label class="form-label">Kode Aturan <span class="text-danger">*</span></label>
        <input type="text" name="kode" value="{{ old('kode', $nextKode) }}" class="form-control @error('kode') is-invalid @enderror" style="text-transform:uppercase;">
        @error('kode')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="col-md-8">
        <label class="form-label">Kesimpulan (Kerusakan) <span class="text-danger">*</span></label>
        <select name="kerusakan_id" class="form-select @error('kerusakan_id') is-invalid @enderror">
          <option value="">-- Pilih Jenis Kerusakan --</option>
          @foreach($kerusakans as $k)
            <option value="{{ $k->id }}" {{ old('kerusakan_id') == $k->id ? 'selected' : '' }}>{{ $k->kode }} — {{ $k->nama }}</option>
          @endforeach
        </select>
        @error('kerusakan_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
    </div>

    {{-- Kondisi Gejala --}}
    <div class="mb-4">
      <label class="form-label fw-semibold">
        Kondisi Gejala (IF) <span class="text-danger">*</span>
        <span class="text-muted fw-normal small ms-1">— Centang semua gejala yang harus terpenuhi</span>
      </label>
      @error('gejala_ids')<div class="alert alert-danger py-2 mb-2 small">{{ $message }}</div>@enderror

      <div style="border:1.5px solid var(--gray-200);border-radius:10px;overflow:hidden;max-height:400px;overflow-y:auto;">
        @foreach($gejalas as $g)
        <label class="d-flex align-items-start gap-3 p-3 border-bottom" style="cursor:pointer;transition:background .15s;" onmouseover="this.style.background='var(--orange-bg)'" onmouseout="this.style.background=''">
          <input type="checkbox" name="gejala_ids[]" value="{{ $g->id }}"
                 class="flex-shrink-0 mt-1" style="width:16px;height:16px;accent-color:var(--orange);"
                 {{ in_array($g->id, old('gejala_ids', [])) ? 'checked' : '' }}>
          <div>
            <span class="kode-badge" style="font-size:.7rem;">{{ $g->kode }}</span>
            <span class="fw-medium small ms-1">{{ $g->nama }}</span>
            @if($g->deskripsi)<div class="text-muted mt-1" style="font-size:.75rem;">{{ $g->deskripsi }}</div>@endif
          </div>
        </label>
        @endforeach
      </div>
    </div>

    <div class="p-3 rounded mb-4" style="background:var(--purple-bg);border:1px solid var(--purple-light);">
      <div class="small text-muted"><i class="bi bi-info-circle me-1" style="color:var(--purple);"></i><strong>Cara kerja aturan:</strong> Jika <em>semua</em> gejala yang dicentang di atas dipilih oleh pengguna, maka sistem akan menyimpulkan kerusakan yang dipilih di atas.</div>
    </div>

    <div class="d-flex gap-2">
      <button type="submit" class="btn-amk"><i class="bi bi-check-lg"></i>Simpan Aturan</button>
      <a href="{{ route('admin.aturan.index') }}" class="btn btn-outline-secondary" style="border-radius:8px;">Batal</a>
    </div>
  </form>
</div></div>
</div></div>
@endsection
