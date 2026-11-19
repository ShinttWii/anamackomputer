@extends('layouts.customer')
@section('title', 'Beranda')

@push('styles')
<style>
/* ══════════════════════════════════════════
   HERO — Full-width CSS Grid, NO max-width container
══════════════════════════════════════════ */

/* Entrance animation */
.enter-left  { opacity:0; transform:translateX(-40px); transition:opacity .7s ease, transform .7s ease; }
.enter-right { opacity:0; transform:translateX(40px);  transition:opacity .7s ease, transform .7s ease; }
.enter-up    { opacity:0; transform:translateY(28px);  transition:opacity .65s ease, transform .65s ease; }
.enter-left.show,
.enter-right.show,
.enter-up.show { opacity:1; transform:translate(0,0); }
.d1{transition-delay:.1s;} .d2{transition-delay:.2s;} .d3{transition-delay:.3s;}
.d4{transition-delay:.4s;} .d5{transition-delay:.5s;} .d6{transition-delay:.6s;}

/* Hero wrapper — 100% lebar, tidak ada max-width */
.hero-amk {
  width: 100%;
  min-height: calc(100vh - 62px); /* 62px = tinggi navbar */
  display: flex;
  align-items: center;
  background: linear-gradient(135deg, #172554 0%, #1e3a8a 45%, #0c4a6e 100%);
  position: relative;
  overflow: hidden;
}

/* Dekorasi latar */
.hero-amk::before {
  content:''; position:absolute; top:-150px; right:-150px;
  width:520px; height:520px; border-radius:50%;
  background:radial-gradient(circle,rgba(242,140,40,.18) 0%,transparent 68%);
  pointer-events:none;
}
.hero-amk::after {
  content:''; position:absolute; bottom:-100px; left:-100px;
  width:400px; height:400px; border-radius:50%;
  background:radial-gradient(circle,rgba(142,202,230,.14) 0%,transparent 68%);
  pointer-events:none;
}

/* Inner grid — 2 kolom, full width, padding 5vw */
.hero-inner {
  width: 100%;
  position: relative;
  z-index: 1;
  padding: 4rem 5vw;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 4vw;
  align-items: center;
  box-sizing: border-box;
}

/* Kolom kiri */
.hero-col-left { display:flex; flex-direction:column; justify-content:center; }

/* Badge */
.hero-badge-pill {
  display:inline-flex; align-items:center; gap:.5rem;
  background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.18);
  color:#fff; padding:.45rem 1.1rem; border-radius:100px;
  font-size:.85rem; font-weight:600; margin-bottom:1.5rem;
  width:fit-content;
}
.live-dot { width:7px; height:7px; border-radius:50%; background:#4ade80; flex-shrink:0; }

/* Judul — ukuran relatif terhadap viewport */
.hero-h1 {
  font-size: clamp(2rem, 3.2vw, 3.2rem);
  font-weight: 900; line-height: 1.14; color:#fff;
  letter-spacing:-.03em; margin-bottom:1.25rem;
}
.hero-h1 .txt-orange { color:#F28C28; }
.hero-h1 .txt-lblue  { color:#8ECAE6; }

/* Deskripsi */
.hero-desc-txt {
  font-size:clamp(.9rem, 1.2vw, 1.05rem);
  color:rgba(255,255,255,.72); line-height:1.75; margin-bottom:2rem;
}

/* Tombol */
.hero-btns { display:flex; flex-wrap:wrap; gap:.75rem; margin-bottom:0; }
.btn-cta-main {
  display:inline-flex; align-items:center; gap:.45rem;
  background:#F28C28; color:#fff !important;
  padding:.8rem 1.9rem; border-radius:50px;
  font-weight:700; font-size:clamp(.875rem,1.1vw,1rem); border:none;
  box-shadow:0 4px 18px rgba(242,140,40,.4);
  transition:transform .2s ease, box-shadow .2s ease;
  text-decoration:none; cursor:pointer;
}
.btn-cta-main:hover { transform:translateY(-2px); box-shadow:0 8px 24px rgba(242,140,40,.5); }
.btn-cta-sec {
  display:inline-flex; align-items:center; gap:.45rem;
  background:rgba(255,255,255,.09); border:1.5px solid rgba(255,255,255,.28);
  color:#fff !important; padding:.78rem 1.65rem; border-radius:50px;
  font-weight:600; font-size:clamp(.875rem,1.1vw,1rem);
  transition:background .2s, border-color .2s; text-decoration:none;
}
.btn-cta-sec:hover { background:rgba(255,255,255,.16); border-color:rgba(255,255,255,.5); }

/* Stats bar */
.hero-statsbar {
  display:flex; flex-wrap:nowrap; gap:0;
  margin-top:2.25rem;
  background:rgba(255,255,255,.07);
  border:1px solid rgba(255,255,255,.12);
  border-radius:14px; overflow:hidden;
}
.hs-item {
  flex:1; padding:1rem .5rem; text-align:center;
  border-right:1px solid rgba(255,255,255,.1);
}
.hs-item:last-child { border-right:none; }
.hs-num { font-size:clamp(1.35rem,2vw,1.75rem); font-weight:900; color:#F28C28; line-height:1; }
.hs-lbl { font-size:.68rem; color:rgba(255,255,255,.5); margin-top:.2rem; font-weight:500; }

/* Kolom kanan */
.hero-col-right {
  display:flex; align-items:center; justify-content:center;
}

/* Banner image — proporsional 600×350 */
.hero-banner-wrap {
  position:relative; width:100%;
}
.hero-banner-img {
  width: 100%;
  aspect-ratio: 600 / 350;   /* rasio 600×350 */
  object-fit: cover;
  border-radius: 18px;
  box-shadow: 0 20px 56px rgba(0,0,0,.32);
  display: block;
}

/* Floating pills */
.fpill {
  position:absolute;
  background:rgba(255,255,255,.97);
  border-radius:12px; padding:.5rem .9rem;
  box-shadow:0 6px 20px rgba(0,0,0,.14);
  font-size:.78rem; font-weight:600; color:#172554;
  white-space:nowrap; z-index:2;
}
.fpill-top { top:-14px; right:20px; }
.fpill-bot { bottom:-14px; left:20px; }

/* Fallback saat tidak ada banner */
.fallback-hero-box {
  width:100%; aspect-ratio:600/350;
  background:rgba(255,255,255,.06);
  border:1.5px solid rgba(255,255,255,.14);
  border-radius:18px;
  display:flex; align-items:center; justify-content:center;
  position:relative;
}

/* ─── SECTION BADGE ─── */
.section-badge-pill {
  display:inline-block; padding:.28rem .9rem; border-radius:100px;
  font-size:.72rem; font-weight:700; letter-spacing:.07em; text-transform:uppercase;
  margin-bottom:.65rem;
}
.sbp-orange{background:#fff8ee;color:#D97706;border:1px solid #FDE68A;}
.sbp-blue  {background:#f0f9ff;color:#0284c7;border:1px solid #bae6fd;}
.sbp-green {background:#f0fdf4;color:#16a34a;border:1px solid #bbf7d0;}

/* ─── CARA KERJA ─── */
.sec-carakerja{background:#fff;padding:5.5rem 0;}
.step-card-amk{background:#fff;border-radius:18px;padding:2rem 1.5rem;text-align:center;border:1.5px solid #E5E7EB;height:100%;transition:transform .25s ease,box-shadow .25s ease,border-color .25s;position:relative;overflow:hidden;}
.step-card-amk::after{content:'';position:absolute;bottom:0;left:0;right:0;height:3px;border-radius:0 0 18px 18px;opacity:0;transition:opacity .25s;}
.sca-1::after{background:linear-gradient(90deg,#F28C28,#fbbf24);}
.sca-2::after{background:linear-gradient(90deg,#8ECAE6,#38bdf8);}
.sca-3::after{background:linear-gradient(90deg,#172554,#3b82f6);}
.step-card-amk:hover{transform:translateY(-5px);box-shadow:0 14px 36px rgba(0,0,0,.09);border-color:transparent;}
.step-card-amk:hover::after{opacity:1;}
.sc-icon{width:68px;height:68px;border-radius:18px;display:flex;align-items:center;justify-content:center;font-size:1.7rem;margin:0 auto 1.1rem;transition:transform .25s;}
.step-card-amk:hover .sc-icon{transform:scale(1.08);}
.sic-1{background:#fff8ee;color:#F28C28;}.sic-2{background:#f0f9ff;color:#0284c7;}.sic-3{background:#eff6ff;color:#172554;}
.sc-num{width:30px;height:30px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.8rem;font-weight:900;color:#fff;margin:0 auto .75rem;}
.scn-1{background:linear-gradient(135deg,#F28C28,#D97706);}
.scn-2{background:linear-gradient(135deg,#8ECAE6,#0284c7);}
.scn-3{background:linear-gradient(135deg,#172554,#1e3a8a);}

/* ─── KEUNGGULAN ─── */
.sec-keunggulan{background:linear-gradient(180deg,#f8faff 0%,#fff 100%);padding:5.5rem 0;}
.unggulan-card{border-radius:16px;padding:1.6rem;height:100%;transition:transform .25s,box-shadow .25s;border:1.5px solid transparent;}
.unggulan-card:hover{transform:translateY(-4px);box-shadow:0 10px 28px rgba(0,0,0,.08);}
.uc-1{background:#fff8ee;border-color:#FDE68A;}.uc-2{background:#f0f9ff;border-color:#bae6fd;}
.uc-3{background:#eff6ff;border-color:#c7d2fe;}.uc-4{background:#f0fdf4;border-color:#bbf7d0;}
.uc-icon{width:44px;height:44px;border-radius:11px;background:#fff;display:flex;align-items:center;justify-content:center;font-size:1.15rem;margin-bottom:.75rem;box-shadow:0 2px 8px rgba(0,0,0,.07);}

/* ─── TENTANG ─── */
.sec-tentang{background:linear-gradient(135deg,#eff6ff 0%,#f0f9ff 50%,#fff8ee 100%);padding:5.5rem 0;}
.tentang-card-mini{background:#fff;border-radius:13px;padding:1.1rem;display:flex;align-items:flex-start;gap:.75rem;box-shadow:0 2px 12px rgba(0,0,0,.06);transition:transform .2s;}
.tentang-card-mini:hover{transform:translateY(-2px);}
.tcm-icon{width:38px;height:38px;border-radius:9px;flex-shrink:0;display:flex;align-items:center;justify-content:center;font-size:1rem;}

/* ─── CTA ─── */
.sec-cta{background:linear-gradient(135deg,#172554 0%,#1e3a8a 50%,#0c4a6e 100%);padding:5rem 0;position:relative;overflow:hidden;}
.sec-cta::before{content:'';position:absolute;inset:0;background:radial-gradient(circle at 70% 50%,rgba(242,140,40,.12) 0%,transparent 60%);}

/* ─── SCROLL REVEAL ─── */
.sr{opacity:0;transform:translateY(22px);transition:opacity .55s ease,transform .55s ease;}
.sr.in{opacity:1;transform:translateY(0);}
.sr-d1{transition-delay:.06s;}.sr-d2{transition-delay:.13s;}
.sr-d3{transition-delay:.20s;}.sr-d4{transition-delay:.27s;}

/* ─── RESPONSIVE ─── */
@media (max-width:1024px) {
  .hero-inner { padding:4rem 4vw; gap:3vw; }
  .hero-h1 { font-size:2.4rem; }
}
@media (max-width:768px) {
  .hero-amk { min-height:auto; }
  .hero-inner {
    grid-template-columns:1fr;
    padding:3rem 5vw 2.5rem;
    gap:2.5rem;
  }
  .hero-col-right { display:none; }  /* sembunyikan banner di mobile */
  .hero-h1 { font-size:2rem; }
  .hero-desc-txt { font-size:.95rem; }
}
@media (max-width:479px) {
  .hero-inner { padding:2.5rem 5vw; }
  .hero-h1 { font-size:1.75rem; }
  .hero-statsbar { flex-wrap:wrap; }
  .hs-item { min-width:50%; border-bottom:1px solid rgba(255,255,255,.1); }

  /* Keunggulan: 2 kolom muat di layar kecil */
  .unggulan-card { padding: 1rem .85rem; }
  .uc-icon { width: 36px; height: 36px; font-size: .95rem; margin-bottom: .5rem; }
}

@media (max-width:767px) {
  /* Cara kerja: 2 box per baris, box ke-3 center otomatis */
  .step-card-amk { padding: 1.1rem .85rem; }
  .sc-icon { width: 48px; height: 48px; font-size: 1.25rem; margin-bottom: .65rem; }
  .sc-num  { width: 26px; height: 26px; font-size: .72rem; margin-bottom: .5rem; }
  .step-card-amk h5 { font-size: .82rem !important; margin-bottom: .4rem !important; }
  .step-card-amk p  { font-size: .75rem !important; line-height: 1.55 !important; }
}
</style>
@endpush

@section('content')

{{-- ═══ HERO — full-width grid, no Bootstrap container ═══ --}}
<section class="hero-amk">
  <div class="hero-inner">

    {{-- KIRI --}}
    <div class="hero-col-left">

      <div class="enter-left d1">
        <div class="hero-badge-pill">
          <span class="live-dot"></span>
          <i class="bi bi-cpu-fill" style="font-size:.8rem;"></i>
          Sistem Pakar Diagnosis MacBook
        </div>
      </div>

      @php
        $rawJudul  = $settings->get('hero_judul')?->nilai ?? 'Diagnosis Kerusakan MacBook dengan Cepat';
        $words     = explode(' ', $rawJudul);
        $total     = count($words);
        $mainPart  = implode(' ', array_slice($words, 0, max(1, $total - 2)));
        $colorPart = array_slice($words, max(1, $total - 2));
      @endphp

      <h1 class="hero-h1 enter-left d2">
        {{ $mainPart }}<br>
        <span class="txt-orange">{{ $colorPart[0] ?? '' }}</span>
        @isset($colorPart[1])<span class="txt-lblue"> {{ $colorPart[1] }}</span>@endisset
      </h1>

      <p class="hero-desc-txt enter-up d3">
        {{ $settings->get('hero_deskripsi')?->nilai ?? 'Temukan kemungkinan kerusakan MacBook Anda berdasarkan gejala yang dialami. Sistem memberikan analisis awal lengkap dengan penyebab dan solusi penanganan.' }}
      </p>

      <div class="hero-btns enter-up d4">
        <a href="{{ route('konsultasi') }}" class="btn-cta-main">
          <i class="bi bi-stethoscope"></i>Mulai Konsultasi
        </a>
        <a href="{{ route('panduan') }}" class="btn-cta-sec">
          <i class="bi bi-book"></i>Cara Penggunaan
        </a>
      </div>

      <div class="hero-statsbar enter-up d5">
        @foreach([
          ['n'=>$stats['kerusakan'], 'l'=>'Kerusakan', 'p'=>true],
          ['n'=>$stats['gejala'],    'l'=>'Gejala',    'p'=>true],
          ['n'=>$stats['aturan'],    'l'=>'Aturan',    'p'=>true],
          ['n'=>$stats['konsultasi'],'l'=>'Konsultasi','p'=>false],
        ] as $d)
        <div class="hs-item">
          <div class="hs-num stat-count" data-target="{{ $d['n'] }}" data-plus="{{ $d['p'] ? '1' : '0' }}">
            {{ $d['n'] }}{{ $d['p'] ? '+' : '' }}
          </div>
          <div class="hs-lbl">{{ $d['l'] }}</div>
        </div>
        @endforeach
      </div>

    </div>{{-- /hero-col-left --}}

    {{-- KANAN --}}
    <div class="hero-col-right">
      @php $bannerPath = $settings->get('banner_hero')?->nilai; @endphp
      <div class="hero-banner-wrap enter-right d2">
        @if($bannerPath)
          <img src="{{ asset('storage/' . $bannerPath) }}" alt="Banner aMK" class="hero-banner-img">
          <div class="fpill fpill-top enter-up d4">
            <span style="color:#4ade80;margin-right:.3rem;">●</span>Sistem Aktif
          </div>
          <div class="fpill fpill-bot enter-up d5">
            <span style="color:#F28C28;margin-right:.3rem;">⚡</span>{{ $stats['konsultasi'] }} Konsultasi Selesai
          </div>
        @else
          <div class="fallback-hero-box">
            <i class="bi bi-laptop-fill" style="font-size:6rem;color:rgba(255,255,255,.15);"></i>
            <div class="fpill" style="top:-14px;right:20px;">
              <span style="color:#4ade80;margin-right:.3rem;">●</span>Sistem Aktif
            </div>
            <div class="fpill" style="bottom:-14px;left:20px;">
              <span style="color:#F28C28;margin-right:.3rem;">⚡</span>Forward Chaining
            </div>
          </div>
        @endif
      </div>
    </div>{{-- /hero-col-right --}}

  </div>{{-- /hero-inner --}}
</section>

{{-- ═══ CARA KERJA ═══ --}}
<section class="sec-carakerja">
  <div class="container">
    <div class="text-center mb-5 sr">
      <div class="section-badge-pill sbp-orange">Cara Kerja</div>
      <h2 class="section-title mt-1">Diagnosis dalam <span>3 Langkah</span></h2>
      <p class="text-muted mt-2" style="max-width:460px;margin:0 auto;font-size:.9rem;">
        Proses konsultasi sederhana yang langsung memberikan hasil akurat.
      </p>
    </div>
    <div class="row g-4 justify-content-center">
      @foreach([
        ['sca'=>'sca-1','sic'=>'sic-1','scn'=>'scn-1','icon'=>'bi-list-check',             'num'=>1,'title'=>'Pilih Gejala',    'desc'=>'Centang semua gejala yang dialami MacBook Anda dari daftar yang tersedia.'],
        ['sca'=>'sca-2','sic'=>'sic-2','scn'=>'scn-2','icon'=>'bi-cpu-fill',                'num'=>2,'title'=>'Analisis Sistem', 'desc'=>'Sistem memproses gejala menggunakan metode Forward Chaining secara otomatis.'],
        ['sca'=>'sca-3','sic'=>'sic-3','scn'=>'scn-3','icon'=>'bi-file-earmark-check-fill', 'num'=>3,'title'=>'Terima Hasil',    'desc'=>'Dapatkan hasil diagnosis lengkap beserta penyebab dan solusi penanganan awal.'],
      ] as $s)
      <div class="col-6 col-md-4 sr sr-d{{ $loop->iteration }}">
        <div class="step-card-amk {{ $s['sca'] }}">
          <div class="sc-icon {{ $s['sic'] }}"><i class="bi {{ $s['icon'] }}"></i></div>
          <div class="sc-num {{ $s['scn'] }} mx-auto">{{ $s['num'] }}</div>
          <h5 class="fw-700 mb-2" style="font-size:1rem;color:#172554;">{{ $s['title'] }}</h5>
          <p class="text-muted mb-0" style="font-size:.875rem;line-height:1.7;">{{ $s['desc'] }}</p>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

{{-- ═══ KEUNGGULAN ═══ --}}
<section class="sec-keunggulan">
  <div class="container">
    <div class="text-center mb-5 sr">
      <div class="section-badge-pill sbp-blue">Keunggulan</div>
      <h2 class="section-title mt-1">Kenapa Pakai <span>Sistem Ini?</span></h2>
    </div>
    <div class="row g-4">
      @foreach([
        ['uc'=>'uc-1','ic'=>'#F28C28','icon'=>'bi-lightning-charge-fill','title'=>'Hasil Instan',          'desc'=>'Diagnosis selesai dalam hitungan detik, tanpa perlu menunggu antrian.'],
        ['uc'=>'uc-2','ic'=>'#0284c7','icon'=>'bi-shield-check-fill',    'title'=>'Basis Pengetahuan Valid','desc'=>'Data kerusakan dikurasi dari pengalaman nyata teknisi MacBook berpengalaman.'],
        ['uc'=>'uc-3','ic'=>'#172554','icon'=>'bi-printer-fill',         'title'=>'Cetak Hasil',            'desc'=>'Hasil diagnosis dapat dicetak sebagai referensi saat berkunjung ke teknisi.'],
        ['uc'=>'uc-4','ic'=>'#16a34a','icon'=>'bi-person-check-fill',    'title'=>'Tanpa Registrasi',       'desc'=>'Langsung gunakan sistem tanpa perlu mendaftar atau login terlebih dahulu.'],
      ] as $u)
      <div class="col-6 col-lg-3 sr sr-d{{ $loop->iteration }}">
        <div class="unggulan-card {{ $u['uc'] }}">
          <div class="uc-icon"><i class="bi {{ $u['icon'] }}" style="color:{{ $u['ic'] }};"></i></div>
          <h6 class="fw-700 mb-1" style="font-size:.93rem;color:#172554;">{{ $u['title'] }}</h6>
          <p class="text-muted mb-0" style="font-size:.82rem;line-height:1.65;">{{ $u['desc'] }}</p>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

{{-- ═══ TENTANG ═══ --}}
<section class="sec-tentang">
  <div class="container">
    <div class="row align-items-center g-5">
      <div class="col-lg-5 sr">
        <div class="section-badge-pill sbp-orange">Tentang Kami</div>
        <h2 class="section-title mt-1">anaMac <span>Komputer</span></h2>
        <p class="text-muted mb-4" style="font-size:.9rem;line-height:1.8;">
          {{ $settings->get('tentang_deskripsi')?->nilai ?? 'anaMac Komputer adalah toko layanan perbaikan MacBook terpercaya. Sistem pakar ini dikembangkan untuk membantu pengguna mengetahui kemungkinan kerusakan MacBook sebelum dibawa ke teknisi.' }}
        </p>
        <div style="background:#fffbeb;border-left:4px solid #F28C28;border-radius:8px;padding:.875rem 1.1rem;font-size:.85rem;color:#92400e;margin-bottom:1.5rem;">
          <i class="bi bi-info-circle me-2"></i>
          Hasil diagnosis bersifat <strong>perkiraan awal</strong>. Konsultasikan ke teknisi aMK untuk penanganan lebih lanjut.
        </div>
        <a href="{{ route('informasi') }}" class="btn-amk">
          <i class="bi bi-laptop me-1"></i>Lihat Info Kerusakan
        </a>
      </div>
      <div class="col-lg-7">
        <div class="row g-3">
          @foreach([
            ['ic'=>'#F28C28','bg'=>'#fff8ee','icon'=>'bi-lightning-charge-fill','title'=>'Cepat & Akurat',   'desc'=>'Hasil diagnosis dalam hitungan detik.'],
            ['ic'=>'#0284c7','bg'=>'#f0f9ff','icon'=>'bi-shield-check-fill',    'title'=>'Data Tervalidasi', 'desc'=>'Basis pengetahuan dari teknisi berpengalaman.'],
            ['ic'=>'#172554','bg'=>'#eff6ff','icon'=>'bi-printer-fill',         'title'=>'Cetak Hasil',      'desc'=>'Bawa hasil cetak saat datang ke teknisi.'],
            ['ic'=>'#16a34a','bg'=>'#f0fdf4','icon'=>'bi-person-check-fill',    'title'=>'Tanpa Registrasi', 'desc'=>'Langsung gunakan tanpa mendaftar.'],
          ] as $t)
          <div class="col-6 sr sr-d{{ $loop->iteration }}">
            <div class="tentang-card-mini">
              <div class="tcm-icon" style="background:{{ $t['bg'] }};color:{{ $t['ic'] }};">
                <i class="bi {{ $t['icon'] }}"></i>
              </div>
              <div>
                <div class="fw-700" style="font-size:.85rem;color:#172554;">{{ $t['title'] }}</div>
                <div class="text-muted" style="font-size:.78rem;line-height:1.55;margin-top:.1rem;">{{ $t['desc'] }}</div>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</section>

{{-- ═══ CTA ═══ --}}
<section class="sec-cta">
  <div class="container text-center sr" style="position:relative;z-index:1;">
    <div style="display:inline-block;background:rgba(242,140,40,.18);border:1px solid rgba(242,140,40,.35);border-radius:100px;padding:.3rem 1rem;font-size:.72rem;font-weight:700;color:#fbbf24;margin-bottom:1rem;letter-spacing:.07em;">
      GRATIS &nbsp;·&nbsp; TANPA REGISTRASI &nbsp;·&nbsp; INSTAN
    </div>
    <h2 style="font-size:clamp(1.7rem,3vw,2.4rem);font-weight:900;color:#fff;letter-spacing:-.025em;margin-bottom:.7rem;">
      MacBook Anda Bermasalah?
    </h2>
    <p style="color:rgba(255,255,255,.65);margin-bottom:2rem;font-size:.93rem;max-width:480px;margin-left:auto;margin-right:auto;line-height:1.7;">
      Gunakan sistem diagnosis kami untuk mengetahui kemungkinan kerusakan secara gratis.
    </p>
    <a href="{{ route('konsultasi') }}" class="btn-cta-main" style="font-size:.975rem;padding:.8rem 2rem;">
      <i class="bi bi-stethoscope"></i>Mulai Konsultasi Sekarang
    </a>
  </div>
</section>

@endsection

@push('scripts')
<script>
(function () {
  'use strict';

  /* ─── HERO ENTRANCE via window.onload ─── */
  window.addEventListener('load', function () {
    var heroEls = document.querySelectorAll(
      '.hero-amk .enter-left, .hero-amk .enter-right, .hero-amk .enter-up'
    );
    requestAnimationFrame(function () {
      requestAnimationFrame(function () {
        heroEls.forEach(function (el) { el.classList.add('show'); });
      });
    });
  });

  /* ─── SCROLL REVEAL ─── */
  document.addEventListener('DOMContentLoaded', function () {
    var srEls = document.querySelectorAll('.sr');
    if ('IntersectionObserver' in window) {
      var io = new IntersectionObserver(function (entries) {
        entries.forEach(function (e) {
          if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target); }
        });
      }, { threshold:0.1, rootMargin:'0px 0px -30px 0px' });
      srEls.forEach(function (el) { io.observe(el); });
    } else {
      srEls.forEach(function (el) { el.classList.add('in'); });
    }

    /* ─── COUNTER ─── */
    var counters = document.querySelectorAll('.stat-count');
    if ('IntersectionObserver' in window && counters.length) {
      var cio = new IntersectionObserver(function (entries) {
        entries.forEach(function (e) {
          if (!e.isIntersecting) return;
          var el = e.target;
          var target = parseInt(el.getAttribute('data-target'), 10);
          var plus   = el.getAttribute('data-plus') === '1';
          if (isNaN(target)) return;
          var cur = 0, inc = Math.ceil(target/40);
          var tmr = setInterval(function () {
            cur = Math.min(cur + inc, target);
            el.textContent = cur.toLocaleString('id-ID') + (plus ? '+' : '');
            if (cur >= target) clearInterval(tmr);
          }, 25);
          cio.unobserve(el);
        });
      }, { threshold:0.6 });
      counters.forEach(function (el) { cio.observe(el); });
    }
  });

})();
</script>
@endpush
