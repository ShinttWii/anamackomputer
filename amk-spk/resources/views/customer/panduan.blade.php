@extends('layouts.customer')
@section('title', 'Panduan Penggunaan')

@push('styles')
<style>
@media (max-width: 767px) {
  /* Wrapper list langkah */
  .panduan-list { gap: .5rem !important; }

  /* Card lebih ramping */
  .panduan-card .konten-area { padding: .65rem .85rem !important; }

  /* Sidebar nomor lebih sempit */
  .panduan-card .nomor-col {
    width: 48px !important;
    min-width: 48px !important;
  }
  .panduan-card .nomor-circle {
    width: 26px !important;
    height: 26px !important;
    font-size: .75rem !important;
  }

  /* Judul */
  .panduan-card h5 { font-size: .82rem !important; }

  /* Deskripsi */
  .panduan-card .desc-txt { font-size: .78rem !important; line-height: 1.5 !important; margin-bottom: .4rem !important; }

  /* Box tips lebih compact */
  .panduan-card .tips-box { padding: .35rem .6rem !important; font-size: .72rem !important; }

  /* Catatan penting */
  .warning-note ul { font-size: .78rem !important; }
  .warning-note    { margin-top: 1.25rem !important; }

  /* Tombol bawah */
  .panduan-btns { margin-top: 1.25rem !important; }
  .panduan-btns a { font-size: .82rem !important; padding: .5rem 1rem !important; }
}
</style>
@endpush

@section('content')
<div class="py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12">

        <div class="text-center mb-4">
          <div class="section-line centered"></div>
          <h1 class="section-title">Panduan <span>Penggunaan Sistem</span></h1>
          <p class="text-muted" style="font-size:.9rem;">Langkah-langkah menggunakan sistem diagnosis dengan benar.</p>
        </div>

        @php
          $langkah = [
            ['num'=>1,'icon'=>'bi-house-fill','judul'=>'Buka Beranda',
             'desc'=>'Akses sistem melalui browser. Halaman beranda menampilkan informasi singkat dan tombol untuk memulai konsultasi.',
             'tips'=>'Pastikan koneksi internet stabil sebelum memulai.'],
            ['num'=>2,'icon'=>'bi-laptop','judul'=>'Isi Model MacBook (Opsional)',
             'desc'=>'Pada halaman konsultasi, Anda dapat mengisi model MacBook yang digunakan. Langkah ini bersifat opsional.',
             'tips'=>'Jika tidak tahu model MacBook, kosongkan saja kolom ini.'],
            ['num'=>3,'icon'=>'bi-list-check','judul'=>'Pilih Gejala',
             'desc'=>'Baca setiap gejala dan centang semua yang sesuai dengan kondisi MacBook Anda. Pilih minimal satu gejala.',
             'tips'=>'Pilih gejala yang benar-benar dialami. Gejala yang tidak relevan dapat memengaruhi akurasi.'],
            ['num'=>4,'icon'=>'bi-cpu-fill','judul'=>'Proses Diagnosis',
             'desc'=>'Klik "Diagnosa Sekarang". Sistem akan memproses gejala menggunakan metode Forward Chaining secara otomatis.',
             'tips'=>'Proses berlangsung sangat cepat, biasanya kurang dari satu detik.'],
            ['num'=>5,'icon'=>'bi-file-earmark-check-fill','judul'=>'Lihat Hasil Diagnosis',
             'desc'=>'Sistem menampilkan nama kerusakan, kemungkinan penyebab, dan solusi penanganan awal.',
             'tips'=>'Jika tidak ada aturan yang cocok, sistem akan menyarankan pemeriksaan langsung ke teknisi.'],
            ['num'=>6,'icon'=>'bi-printer-fill','judul'=>'Cetak atau Simpan Hasil',
             'desc'=>'Gunakan tombol "Cetak Hasil" untuk mencetak diagnosis sebagai referensi saat berkunjung ke toko aMK.',
             'tips'=>'Bawa hasil cetak saat datang ke toko agar teknisi lebih mudah memahami keluhan Anda.'],
          ];
        @endphp

        <div class="row g-3 panduan-list">
          @foreach($langkah as $l)
          <div class="col-12 col-lg-6">
          <div class="amk-card overflow-hidden panduan-card h-100" style="animation-delay:{{ $loop->index * .07 }}s;">
            <div class="d-flex align-items-stretch h-100">
              {{-- Nomor --}}
              <div class="nomor-col d-flex align-items-center justify-content-center flex-shrink-0"
                   style="width:62px;background:var(--navy);border-right:1px solid rgba(255,255,255,.07);">
                <div class="nomor-circle" style="width:30px;height:30px;border-radius:50%;background:var(--orange);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:.85rem;">
                  {{ $l['num'] }}
                </div>
              </div>
              {{-- Konten --}}
              <div class="konten-area flex-grow-1" style="padding:.85rem 1.1rem;">
                <div class="d-flex align-items-center gap-2 mb-1">
                  <i class="bi {{ $l['icon'] }} text-orange" style="font-size:.95rem;"></i>
                  <h5 class="fw-700 mb-0" style="font-size:.92rem;color:var(--navy);">{{ $l['judul'] }}</h5>
                </div>
                <p class="desc-txt text-muted mb-2" style="font-size:.83rem;line-height:1.6;">{{ $l['desc'] }}</p>
                <div class="tips-box d-flex align-items-start gap-2 rounded" style="background:var(--lblue-bg);border:1px solid var(--lblue-light);padding:.45rem .7rem;">
                  <i class="bi bi-lightbulb-fill flex-shrink-0 mt-1" style="font-size:.7rem;color:var(--lblue-dark);"></i>
                  <small class="text-muted" style="font-size:.78rem;"><strong>Tips:</strong> {{ $l['tips'] }}</small>
                </div>
              </div>
            </div>
          </div>
          </div>
          @endforeach
        </div>

        <div class="warning-note mt-4">
          <div class="d-flex gap-2">
            <i class="bi bi-exclamation-triangle-fill flex-shrink-0 mt-1"></i>
            <div>
              <strong>Catatan Penting</strong>
              <ul class="mb-0 mt-1 ps-3" style="font-size:.875rem;">
                <li>Hasil diagnosis bersifat <strong>perkiraan awal</strong> berdasarkan gejala yang dipilih.</li>
                <li>Sistem tidak menggantikan pemeriksaan langsung oleh teknisi MacBook.</li>
                <li>Untuk penanganan lebih lanjut, bawa MacBook ke <strong>anaMac Komputer (aMK)</strong>.</li>
              </ul>
            </div>
          </div>
        </div>

        <div class="text-center panduan-btns mt-4 d-flex flex-wrap justify-content-center gap-2">
          <a href="{{ route('konsultasi') }}" class="btn-amk" style="padding:.65rem 1.6rem;font-size:.9rem;">
            <i class="bi bi-stethoscope me-1"></i>Mulai Konsultasi
          </a>
          <a href="{{ route('informasi') }}" class="btn-amk-outline" style="padding:.65rem 1.6rem;font-size:.9rem;">
            <i class="bi bi-info-circle me-1"></i>Info Kerusakan
          </a>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection
