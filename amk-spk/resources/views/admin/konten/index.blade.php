@extends('layouts.admin')
@section('title', 'Kelola Konten')

@section('content')
<div class="page-header">
  <div>
    <h1><i class="bi bi-pencil-square text-orange me-2"></i>Kelola Konten</h1>
    <div class="page-header-meta">Ubah teks dan gambar yang tampil di halaman Customer</div>
  </div>
  <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-secondary" style="border-radius:6px;">
    <i class="bi bi-arrow-left me-1"></i>Kembali
  </a>
</div>

{{-- ── Form hapus gambar — di LUAR form utama ── --}}
<form method="POST" id="formHapusLogo"
      action="{{ route('admin.konten.hapus-gambar', 'logo') }}" style="display:none;">
  @csrf @method('DELETE')
</form>
<form method="POST" id="formHapusBanner"
      action="{{ route('admin.konten.hapus-gambar', 'banner_hero') }}" style="display:none;">
  @csrf @method('DELETE')
</form>

{{-- ── Form utama (teks + upload gambar) ── --}}
<form method="POST" action="{{ route('admin.konten.update') }}"
      enctype="multipart/form-data" id="formKonten" novalidate>
  @csrf
  <div class="row g-4">

    {{-- ── Kolom Gambar ── --}}
    <div class="col-lg-5">

      {{-- Logo --}}
      <div class="admin-card mb-4">
        <div class="admin-card-header">
          <h6><i class="bi bi-image text-orange me-2"></i>Logo Toko</h6>
        </div>
        <div class="admin-card-body">
          <div class="info-note mb-3" style="font-size:.82rem;">
            <i class="bi bi-info-circle me-1"></i>
            Logo tampil di navbar Customer. Format: PNG, JPG, SVG, WEBP. Maks 2MB.
          </div>

          @if($settings->get('logo')?->nilai)
            <div class="mb-3 text-center p-3 rounded" style="background:var(--page-bg);border:1px solid var(--border);">
              <img src="{{ asset('storage/' . $settings->get('logo')->nilai) }}"
                   alt="Logo saat ini"
                   style="max-height:80px;max-width:200px;object-fit:contain;">
              <div class="mt-2">
                {{-- Tombol hapus submit ke form terpisah via 'form' attribute --}}
                <button type="submit" form="formHapusLogo"
                        class="btn btn-sm btn-outline-danger" style="border-radius:6px;font-size:.75rem;"
                        onclick="return confirm('Yakin hapus logo?')">
                  <i class="bi bi-trash me-1"></i>Hapus Logo
                </button>
              </div>
            </div>
          @else
            <div class="mb-3 text-center p-3 rounded" style="background:var(--page-bg);border:1px dashed var(--border);">
              <i class="bi bi-image text-muted" style="font-size:2.5rem;opacity:.3;display:block;"></i>
              <p class="text-muted mb-0 mt-1" style="font-size:.78rem;">Belum ada logo</p>
            </div>
          @endif

          <label class="form-label">{{ $settings->get('logo')?->nilai ? 'Ganti Logo' : 'Upload Logo' }}</label>
          <input type="file" name="logo" id="logoInput"
                 class="form-control @error('logo') is-invalid @enderror"
                 accept="image/png,image/jpeg,image/svg+xml,image/webp">
          @error('logo')<div class="invalid-feedback">{{ $message }}</div>@enderror
          <div id="logoPreview" class="mt-2" style="display:none;">
            <img id="logoPreviewImg" src="" alt="Preview"
                 style="max-height:80px;max-width:200px;object-fit:contain;border-radius:8px;border:1px solid var(--border);">
          </div>
        </div>
      </div>

      {{-- Banner Hero --}}
      <div class="admin-card">
        <div class="admin-card-header">
          <h6><i class="bi bi-image-fill text-orange me-2"></i>Banner Hero</h6>
        </div>
        <div class="admin-card-body">
          <div class="info-note mb-3" style="font-size:.82rem;">
            <i class="bi bi-info-circle me-1"></i>
            Banner tampil di bagian kanan hero halaman Beranda. Ukuran ideal 600×400px. Maks 4MB.
          </div>

          @if($settings->get('banner_hero')?->nilai)
            <div class="mb-3 text-center p-3 rounded" style="background:var(--page-bg);border:1px solid var(--border);">
              <img src="{{ asset('storage/' . $settings->get('banner_hero')->nilai) }}"
                   alt="Banner saat ini"
                   style="max-height:140px;width:100%;object-fit:cover;border-radius:8px;">
              <div class="mt-2">
                <button type="submit" form="formHapusBanner"
                        class="btn btn-sm btn-outline-danger" style="border-radius:6px;font-size:.75rem;"
                        onclick="return confirm('Yakin hapus banner?')">
                  <i class="bi bi-trash me-1"></i>Hapus Banner
                </button>
              </div>
            </div>
          @else
            <div class="mb-3 text-center p-3 rounded" style="background:var(--page-bg);border:1px dashed var(--border);">
              <i class="bi bi-image-fill text-muted" style="font-size:2.5rem;opacity:.3;display:block;"></i>
              <p class="text-muted mb-0 mt-1" style="font-size:.78rem;">Belum ada banner</p>
            </div>
          @endif

          <label class="form-label">{{ $settings->get('banner_hero')?->nilai ? 'Ganti Banner' : 'Upload Banner' }}</label>
          <input type="file" name="banner_hero" id="bannerInput"
                 class="form-control @error('banner_hero') is-invalid @enderror"
                 accept="image/png,image/jpeg,image/webp">
          @error('banner_hero')<div class="invalid-feedback">{{ $message }}</div>@enderror
          <div id="bannerPreview" class="mt-2" style="display:none;">
            <img id="bannerPreviewImg" src="" alt="Preview"
                 style="width:100%;max-height:140px;object-fit:cover;border-radius:8px;border:1px solid var(--border);">
          </div>
        </div>
      </div>

    </div>

    {{-- ── Kolom Teks ── --}}
    <div class="col-lg-7">

      <div class="admin-card mb-4">
        <div class="admin-card-header">
          <h6><i class="bi bi-type text-orange me-2"></i>Konten Hero</h6>
        </div>
        <div class="admin-card-body">
          <div class="mb-3">
            <label class="form-label">Judul Hero</label>
            <input type="text" name="hero_judul"
                   value="{{ old('hero_judul', $settings->get('hero_judul')?->nilai) }}"
                   class="form-control @error('hero_judul') is-invalid @enderror"
                   placeholder="Contoh: Diagnosis Kerusakan MacBook dengan Cepat"
                   maxlength="200">
            @error('hero_judul')<div class="invalid-feedback">{{ $message }}</div>@enderror
            <div class="form-text">Tampil sebagai judul utama halaman Beranda.</div>
          </div>
          <div class="mb-0">
            <label class="form-label">Deskripsi Hero</label>
            <textarea name="hero_deskripsi" rows="3"
                      class="form-control @error('hero_deskripsi') is-invalid @enderror"
                      placeholder="Deskripsi singkat di bawah judul..."
                      maxlength="500">{{ old('hero_deskripsi', $settings->get('hero_deskripsi')?->nilai) }}</textarea>
            @error('hero_deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
        </div>
      </div>

      <div class="admin-card mb-4">
        <div class="admin-card-header">
          <h6><i class="bi bi-shop text-orange me-2"></i>Konten Tentang Toko</h6>
        </div>
        <div class="admin-card-body">
          <div class="mb-0">
            <label class="form-label">Deskripsi Tentang</label>
            <textarea name="tentang_deskripsi" rows="4"
                      class="form-control @error('tentang_deskripsi') is-invalid @enderror"
                      placeholder="Deskripsi tentang toko anaMac Komputer..."
                      maxlength="600">{{ old('tentang_deskripsi', $settings->get('tentang_deskripsi')?->nilai) }}</textarea>
            @error('tentang_deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
            <div class="form-text">Tampil di section "Tentang" halaman Beranda.</div>
          </div>
        </div>
      </div>

      <div class="admin-card mb-4">
        <div class="admin-card-header">
          <h6><i class="bi bi-eye text-orange me-2"></i>Pratinjau</h6>
        </div>
        <div class="admin-card-body">
          <p class="text-muted mb-2" style="font-size:.83rem;">Lihat tampilan halaman Customer setelah perubahan disimpan.</p>
          <a href="{{ route('beranda') }}" target="_blank"
             class="btn btn-sm btn-outline-secondary" style="border-radius:6px;">
            <i class="bi bi-box-arrow-up-right me-1"></i>Buka Halaman Beranda
          </a>
        </div>
      </div>

      <div class="d-flex gap-2">
        <button type="submit" form="formKonten" class="btn-amk">
          <i class="bi bi-check-lg me-1"></i>Simpan Perubahan
        </button>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary" style="border-radius:6px;">Batal</a>
      </div>

    </div>
  </div>
</form>

@endsection

@push('scripts')
<script>
(function () {
  function previewGambar(inputId, wrapId, imgId) {
    var inp = document.getElementById(inputId);
    if (!inp) return;
    inp.addEventListener('change', function () {
      var file = this.files[0];
      if (!file) return;
      var reader = new FileReader();
      reader.onload = function (e) {
        document.getElementById(imgId).src = e.target.result;
        document.getElementById(wrapId).style.display = 'block';
      };
      reader.readAsDataURL(file);
    });
  }
  previewGambar('logoInput',   'logoPreview',   'logoPreviewImg');
  previewGambar('bannerInput', 'bannerPreview', 'bannerPreviewImg');
})();
</script>
@endpush
