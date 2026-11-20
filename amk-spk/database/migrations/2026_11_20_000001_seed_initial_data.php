<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Migration ini sekaligus mengisi data awal jika tabel masih kosong.
 * Aman dijalankan berulang (idempotent via updateOrInsert / skip if exists).
 */
return new class extends Migration
{
    public function up(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // ── ADMIN ──────────────────────────────────────────────
        if (DB::table('admins')->count() === 0) {
            DB::table('admins')->insert([
                'username'     => 'admin',
                'password'     => Hash::make('admin123'),
                'nama_lengkap' => 'Administrator aMK',
                'email'        => 'dewishinta0128@gmail.com',
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        }

        // ── KERUSAKAN ──────────────────────────────────────────
        if (DB::table('kerusakans')->count() === 0) {
            $kerusakans = [
                ['kode'=>'K001','nama'=>'Kerusakan Baterai','deskripsi'=>'Baterai MacBook tidak dapat menyimpan daya dengan baik, mengalami penurunan kapasitas, atau tidak dapat terisi sama sekali.'],
                ['kode'=>'K002','nama'=>'Layar Tidak Menyala','deskripsi'=>'Layar MacBook tidak menampilkan gambar meskipun perangkat dalam kondisi menyala.'],
                ['kode'=>'K003','nama'=>'MacBook Tidak Menyala','deskripsi'=>'MacBook tidak merespons sama sekali saat tombol power ditekan.'],
                ['kode'=>'K004','nama'=>'Keyboard Tidak Berfungsi','deskripsi'=>'Sebagian atau seluruh tombol keyboard tidak merespons saat ditekan.'],
                ['kode'=>'K005','nama'=>'Overheating','deskripsi'=>'MacBook mengalami panas berlebih yang menyebabkan kinerja menurun atau perangkat mati mendadak.'],
                ['kode'=>'K006','nama'=>'WiFi Tidak Terdeteksi','deskripsi'=>'MacBook tidak dapat mendeteksi jaringan WiFi atau kartu WiFi tidak dikenali oleh sistem.'],
                ['kode'=>'K007','nama'=>'Speaker Tidak Berfungsi','deskripsi'=>'Tidak ada suara yang keluar dari speaker MacBook meskipun volume telah diatur.'],
                ['kode'=>'K008','nama'=>'Kamera Tidak Terdeteksi','deskripsi'=>'FaceTime camera tidak dikenali oleh sistem atau tidak berfungsi saat digunakan.'],
                ['kode'=>'K009','nama'=>'MacBook Sering Hang/Freeze','deskripsi'=>'MacBook tiba-tiba berhenti merespons, kursor tidak bergerak, atau aplikasi tidak dapat ditutup.'],
                ['kode'=>'K010','nama'=>'Port USB/Thunderbolt Tidak Berfungsi','deskripsi'=>'Port USB atau Thunderbolt pada MacBook tidak mengenali perangkat yang dihubungkan.'],
            ];
            foreach ($kerusakans as $item) {
                DB::table('kerusakans')->insert(array_merge($item, ['created_at'=>now(),'updated_at'=>now()]));
            }
        }

        // ── GEJALA ─────────────────────────────────────────────
        if (DB::table('gejalas')->count() === 0) {
            $gejalas = [
                ['kode'=>'G001','nama'=>'Baterai tidak bertambah persentasenya saat dicas','deskripsi'=>'Ketika charger terhubung, indikator baterai tidak menunjukkan pengisian daya'],
                ['kode'=>'G002','nama'=>'MacBook hanya menyala saat terhubung charger','deskripsi'=>'Perangkat tidak dapat beroperasi tanpa charger terhubung'],
                ['kode'=>'G003','nama'=>'Kapasitas baterai menurun drastis','deskripsi'=>'Baterai cepat habis meski baru diisi penuh'],
                ['kode'=>'G004','nama'=>'Baterai menggembung atau bengkak','deskripsi'=>'Bagian bawah MacBook terlihat atau terasa tidak rata akibat baterai membengkak'],
                ['kode'=>'G005','nama'=>'Layar gelap total saat dinyalakan','deskripsi'=>'Tidak ada tampilan pada layar meskipun perangkat menyala'],
                ['kode'=>'G006','nama'=>'Layar retak atau pecah','deskripsi'=>'Terdapat keretakan fisik pada panel layar'],
                ['kode'=>'G007','nama'=>'Backlight layar mati (gelap tapi ada bayangan gambar)','deskripsi'=>'Gambar masih ada namun sangat gelap, hanya terlihat jika diterangi cahaya'],
                ['kode'=>'G008','nama'=>'Layar berkedip-kedip','deskripsi'=>'Tampilan layar tidak stabil, berkedip secara tidak teratur'],
                ['kode'=>'G009','nama'=>'MacBook tidak merespons saat tombol power ditekan','deskripsi'=>'Tidak ada reaksi apapun saat menekan tombol power'],
                ['kode'=>'G010','nama'=>'Tidak ada lampu indikator atau suara saat dinyalakan','deskripsi'=>'Tidak ada tanda kehidupan sama sekali pada perangkat'],
                ['kode'=>'G011','nama'=>'MacBook mati mendadak saat digunakan','deskripsi'=>'Perangkat tiba-tiba mati tanpa peringatan saat sedang digunakan'],
                ['kode'=>'G012','nama'=>'Beberapa tombol keyboard tidak merespons','deskripsi'=>'Satu atau beberapa tombol tidak berfungsi saat ditekan'],
                ['kode'=>'G013','nama'=>'Seluruh keyboard tidak berfungsi','deskripsi'=>'Tidak ada tombol keyboard yang merespons sama sekali'],
                ['kode'=>'G014','nama'=>'Keyboard mengetik sendiri atau double karakter','deskripsi'=>'Karakter muncul tanpa ditekan atau satu tekanan menghasilkan dua karakter'],
                ['kode'=>'G015','nama'=>'MacBook sangat panas saat digunakan','deskripsi'=>'Suhu bodi MacBook sangat tinggi, terasa panas saat disentuh'],
                ['kode'=>'G016','nama'=>'Kipas berputar sangat kencang terus-menerus','deskripsi'=>'Suara kipas sangat keras dan tidak berhenti meski aktivitas ringan'],
                ['kode'=>'G017','nama'=>'MacBook mati mendadak karena panas','deskripsi'=>'Perangkat mati tiba-tiba dan menampilkan pesan thermal shutdown'],
                ['kode'=>'G018','nama'=>'WiFi tidak muncul di daftar jaringan','deskripsi'=>'Tidak ada jaringan WiFi yang terdeteksi sama sekali'],
                ['kode'=>'G019','nama'=>'Ikon WiFi menampilkan tanda seru atau tidak tersedia','deskripsi'=>'Sistem menunjukkan WiFi hardware tidak ditemukan'],
                ['kode'=>'G020','nama'=>'Tidak ada suara dari speaker','deskripsi'=>'Volume normal namun tidak ada suara keluar dari speaker'],
                ['kode'=>'G021','nama'=>'Suara speaker pecah atau mendistorsi','deskripsi'=>'Suara keluar namun kualitasnya buruk, pecah, atau bergetar tidak normal'],
                ['kode'=>'G022','nama'=>'Kamera tidak terdeteksi di aplikasi','deskripsi'=>'FaceTime, Photo Booth, atau aplikasi lain tidak mendeteksi kamera'],
                ['kode'=>'G023','nama'=>'Kamera menampilkan layar hijau atau hitam','deskripsi'=>'Kamera terdeteksi namun hanya menampilkan warna hijau atau hitam solid'],
                ['kode'=>'G024','nama'=>'MacBook sering freeze atau tidak merespons','deskripsi'=>'Sistem tiba-tiba berhenti merespons, kursor tidak bisa digerakkan'],
                ['kode'=>'G025','nama'=>'Aplikasi sering crash sendiri','deskripsi'=>'Aplikasi menutup sendiri secara tiba-tiba tanpa perintah'],
                ['kode'=>'G026','nama'=>'MacBook sangat lambat','deskripsi'=>'Kinerja sistem sangat lambat, bahkan untuk tugas ringan sekalipun'],
                ['kode'=>'G027','nama'=>'Port USB tidak mengenali perangkat yang dihubungkan','deskripsi'=>'Flash drive, mouse, atau perangkat USB lain tidak terdeteksi'],
                ['kode'=>'G028','nama'=>'Port Thunderbolt tidak berfungsi','deskripsi'=>'Monitor eksternal, docking station, atau perangkat Thunderbolt tidak dikenali'],
                ['kode'=>'G029','nama'=>'Perangkat terkadang terdeteksi lalu hilang','deskripsi'=>'Koneksi perangkat tidak stabil, terkadang muncul lalu hilang'],
            ];
            foreach ($gejalas as $item) {
                DB::table('gejalas')->insert(array_merge($item, ['created_at'=>now(),'updated_at'=>now()]));
            }
        }

        // ── PENYEBAB ───────────────────────────────────────────
        if (DB::table('penyebabs')->count() === 0) {
            $penyebabs = [
                ['kode'=>'P001','kerusakan_id'=>1,'deskripsi'=>'Sel baterai mengalami penuaan alami setelah banyak siklus pengisian'],
                ['kode'=>'P002','kerusakan_id'=>1,'deskripsi'=>'Penggunaan charger tidak resmi atau daya tidak sesuai spesifikasi'],
                ['kode'=>'P003','kerusakan_id'=>1,'deskripsi'=>'Kerusakan pada IC pengatur pengisian daya (charging IC) di logika board'],
                ['kode'=>'P004','kerusakan_id'=>2,'deskripsi'=>'Kerusakan pada inverter atau backlight LED layar'],
                ['kode'=>'P005','kerusakan_id'=>2,'deskripsi'=>'Kabel layar (LVDS/eDP) putus atau longgar dari konektor'],
                ['kode'=>'P006','kerusakan_id'=>2,'deskripsi'=>'Kerusakan komponen GPU pada logika board'],
                ['kode'=>'P007','kerusakan_id'=>3,'deskripsi'=>'Kerusakan pada IC power management (PMU/SMC)'],
                ['kode'=>'P008','kerusakan_id'=>3,'deskripsi'=>'Konektor baterai longgar atau baterai sudah tidak berfungsi sama sekali'],
                ['kode'=>'P009','kerusakan_id'=>3,'deskripsi'=>'Kerusakan pada logika board yang menyebabkan tidak ada aliran daya'],
                ['kode'=>'P010','kerusakan_id'=>4,'deskripsi'=>'Masuknya cairan ke dalam keyboard yang merusak membran atau sirkuit'],
                ['kode'=>'P011','kerusakan_id'=>4,'deskripsi'=>'Debu atau kotoran menumpuk di bawah tombol keyboard'],
                ['kode'=>'P012','kerusakan_id'=>4,'deskripsi'=>'Kerusakan konektor keyboard pada logika board'],
                ['kode'=>'P013','kerusakan_id'=>5,'deskripsi'=>'Ventilasi tersumbat debu sehingga aliran udara terhambat'],
                ['kode'=>'P014','kerusakan_id'=>5,'deskripsi'=>'Pasta termal pada prosesor sudah kering dan tidak efektif'],
                ['kode'=>'P015','kerusakan_id'=>5,'deskripsi'=>'Kipas pendingin rusak atau tidak berputar optimal'],
                ['kode'=>'P016','kerusakan_id'=>6,'deskripsi'=>'Kartu WiFi (AirPort card) mengalami kerusakan fisik'],
                ['kode'=>'P017','kerusakan_id'=>6,'deskripsi'=>'Konektor atau kabel antena WiFi lepas atau rusak'],
                ['kode'=>'P018','kerusakan_id'=>7,'deskripsi'=>'Speaker mengalami kerusakan fisik akibat volume tinggi atau benturan'],
                ['kode'=>'P019','kerusakan_id'=>7,'deskripsi'=>'Konektor speaker pada logika board longgar atau rusak'],
                ['kode'=>'P020','kerusakan_id'=>8,'deskripsi'=>'Kabel konektor kamera putus atau longgar'],
                ['kode'=>'P021','kerusakan_id'=>8,'deskripsi'=>'Modul kamera FaceTime mengalami kerusakan internal'],
                ['kode'=>'P022','kerusakan_id'=>9,'deskripsi'=>'Kapasitas RAM tidak mencukupi untuk beban kerja yang diberikan'],
                ['kode'=>'P023','kerusakan_id'=>9,'deskripsi'=>'Penyimpanan (SSD) hampir penuh atau mengalami masalah'],
                ['kode'=>'P024','kerusakan_id'=>9,'deskripsi'=>'Adanya malware atau proses sistem yang berjalan berlebihan'],
                ['kode'=>'P025','kerusakan_id'=>10,'deskripsi'=>'Kerusakan fisik pada port akibat benturan atau benda asing'],
                ['kode'=>'P026','kerusakan_id'=>10,'deskripsi'=>'Kerusakan pada controller USB/Thunderbolt di logika board'],
            ];
            foreach ($penyebabs as $item) {
                DB::table('penyebabs')->insert(array_merge($item, ['created_at'=>now(),'updated_at'=>now()]));
            }
        }

        // ── SOLUSI ─────────────────────────────────────────────
        if (DB::table('solusis')->count() === 0) {
            $solusis = [
                ['kode'=>'S001','kerusakan_id'=>1,'deskripsi'=>'Lakukan penggantian baterai dengan baterai original atau berkualitas tinggi yang sesuai model MacBook Anda'],
                ['kode'=>'S002','kerusakan_id'=>1,'deskripsi'=>'Selalu gunakan charger original Apple (MagSafe/USB-C) atau charger bersertifikat MFi'],
                ['kode'=>'S003','kerusakan_id'=>1,'deskripsi'=>'Bawa ke teknisi untuk pemeriksaan IC pengisian daya dan logika board'],
                ['kode'=>'S004','kerusakan_id'=>2,'deskripsi'=>'Hubungkan MacBook ke monitor eksternal untuk memastikan masalah ada di layar, bukan GPU'],
                ['kode'=>'S005','kerusakan_id'=>2,'deskripsi'=>'Bawa ke teknisi untuk penggantian kabel layar atau modul layar'],
                ['kode'=>'S006','kerusakan_id'=>2,'deskripsi'=>'Jika penyebab GPU, pertimbangkan perbaikan atau penggantian logika board'],
                ['kode'=>'S007','kerusakan_id'=>3,'deskripsi'=>'Coba reset SMC (System Management Controller) terlebih dahulu'],
                ['kode'=>'S008','kerusakan_id'=>3,'deskripsi'=>'Pastikan baterai terhubung dengan baik, coba cas beberapa saat sebelum menyalakan'],
                ['kode'=>'S009','kerusakan_id'=>3,'deskripsi'=>'Bawa ke teknisi untuk diagnosa dan perbaikan logika board'],
                ['kode'=>'S010','kerusakan_id'=>4,'deskripsi'=>'Segera matikan MacBook jika terkena cairan, jangan nyalakan sebelum dipastikan kering'],
                ['kode'=>'S011','kerusakan_id'=>4,'deskripsi'=>'Gunakan keyboard eksternal sebagai alternatif sementara'],
                ['kode'=>'S012','kerusakan_id'=>4,'deskripsi'=>'Bawa ke teknisi untuk pembersihan atau penggantian keyboard'],
                ['kode'=>'S013','kerusakan_id'=>5,'deskripsi'=>'Bersihkan ventilasi MacBook dari debu menggunakan udara bertekanan'],
                ['kode'=>'S014','kerusakan_id'=>5,'deskripsi'=>'Hindari meletakkan MacBook di permukaan yang menghalangi ventilasi (kasur, sofa)'],
                ['kode'=>'S015','kerusakan_id'=>5,'deskripsi'=>'Bawa ke teknisi untuk penggantian pasta termal dan servis kipas'],
                ['kode'=>'S016','kerusakan_id'=>6,'deskripsi'=>'Coba reset NVRAM/PRAM dan SMC terlebih dahulu'],
                ['kode'=>'S017','kerusakan_id'=>6,'deskripsi'=>'Bawa ke teknisi untuk pemeriksaan dan penggantian kartu WiFi atau antena'],
                ['kode'=>'S018','kerusakan_id'=>7,'deskripsi'=>'Periksa pengaturan suara di System Preferences, pastikan tidak dalam mode mute'],
                ['kode'=>'S019','kerusakan_id'=>7,'deskripsi'=>'Coba gunakan headphone untuk memastikan masalah ada di speaker, bukan software'],
                ['kode'=>'S020','kerusakan_id'=>7,'deskripsi'=>'Bawa ke teknisi untuk penggantian speaker atau perbaikan konektor audio'],
                ['kode'=>'S021','kerusakan_id'=>8,'deskripsi'=>'Restart MacBook dan periksa apakah kamera muncul di System Information'],
                ['kode'=>'S022','kerusakan_id'=>8,'deskripsi'=>'Reset SMC dan NVRAM, kemudian periksa ulang'],
                ['kode'=>'S023','kerusakan_id'=>8,'deskripsi'=>'Bawa ke teknisi untuk pemeriksaan kabel dan modul kamera'],
                ['kode'=>'S024','kerusakan_id'=>9,'deskripsi'=>'Tutup aplikasi yang tidak digunakan dan periksa Activity Monitor untuk proses berat'],
                ['kode'=>'S025','kerusakan_id'=>9,'deskripsi'=>'Kosongkan ruang penyimpanan minimal 10-15% dari total kapasitas SSD'],
                ['kode'=>'S026','kerusakan_id'=>9,'deskripsi'=>'Jalankan pemindaian malware dan pertimbangkan instal ulang macOS jika diperlukan'],
                ['kode'=>'S027','kerusakan_id'=>10,'deskripsi'=>'Periksa port secara fisik, bersihkan dari debu menggunakan sikat halus'],
                ['kode'=>'S028','kerusakan_id'=>10,'deskripsi'=>'Coba restart MacBook dan reset SMC'],
                ['kode'=>'S029','kerusakan_id'=>10,'deskripsi'=>'Bawa ke teknisi untuk perbaikan port atau controller USB/Thunderbolt'],
            ];
            foreach ($solusis as $item) {
                DB::table('solusis')->insert(array_merge($item, ['created_at'=>now(),'updated_at'=>now()]));
            }
        }

        // ── ATURAN + ATURAN_GEJALA ────────────────────────────
        if (DB::table('aturans')->count() === 0) {
            $aturans = [
                ['kode'=>'R001','kerusakan_id'=>1],
                ['kode'=>'R002','kerusakan_id'=>1],
                ['kode'=>'R003','kerusakan_id'=>2],
                ['kode'=>'R004','kerusakan_id'=>2],
                ['kode'=>'R005','kerusakan_id'=>3],
                ['kode'=>'R006','kerusakan_id'=>4],
                ['kode'=>'R007','kerusakan_id'=>4],
                ['kode'=>'R008','kerusakan_id'=>5],
                ['kode'=>'R009','kerusakan_id'=>5],
                ['kode'=>'R010','kerusakan_id'=>6],
                ['kode'=>'R011','kerusakan_id'=>7],
                ['kode'=>'R012','kerusakan_id'=>8],
                ['kode'=>'R013','kerusakan_id'=>9],
                ['kode'=>'R014','kerusakan_id'=>9],
                ['kode'=>'R015','kerusakan_id'=>10],
            ];
            foreach ($aturans as $a) {
                DB::table('aturans')->insert(array_merge($a, ['created_at'=>now(),'updated_at'=>now()]));
            }

            // Ambil id aturan yang baru saja diinsert berdasarkan kode
            $aturanIds = DB::table('aturans')->orderBy('id')->pluck('id', 'kode');

            $aturanGejala = [
                'R001' => [1, 2],
                'R002' => [3, 4],
                'R003' => [5, 7],
                'R004' => [6, 8],
                'R005' => [9, 10, 11],
                'R006' => [12],
                'R007' => [13, 14],
                'R008' => [15, 16],
                'R009' => [16, 17],
                'R010' => [18, 19],
                'R011' => [20, 21],
                'R012' => [22, 23],
                'R013' => [24, 25],
                'R014' => [26, 24],
                'R015' => [27, 28],
            ];

            foreach ($aturanGejala as $kode => $gejalaIds) {
                $aturanId = $aturanIds[$kode] ?? null;
                if (!$aturanId) continue;
                foreach ($gejalaIds as $gejalaId) {
                    DB::table('aturan_gejalas')->insert([
                        'aturan_id' => $aturanId,
                        'gejala_id' => $gejalaId,
                    ]);
                }
            }
        }

        // ── SITE SETTINGS ─────────────────────────────────────
        if (DB::table('site_settings')->count() === 0) {
            $settings = [
                ['kunci'=>'hero_judul',        'nilai'=>'Diagnosis Kerusakan MacBook Dengan Cepat','tipe'=>'text',    'label'=>'Judul Hero'],
                ['kunci'=>'hero_deskripsi',    'nilai'=>'Temukan kemungkinan kerusakan MacBook Anda berdasarkan gejala yang dialami. Sistem akan memberikan analisis awal lengkap dengan penyebab dan solusi penanganan.','tipe'=>'textarea','label'=>'Deskripsi Hero'],
                ['kunci'=>'tentang_deskripsi', 'nilai'=>'anaMac Komputer adalah toko layanan perbaikan MacBook terpercaya.','tipe'=>'textarea','label'=>'Deskripsi Tentang'],
                ['kunci'=>'logo',              'nilai'=>null, 'tipe'=>'image','label'=>'Logo'],
                ['kunci'=>'banner_hero',       'nilai'=>null, 'tipe'=>'image','label'=>'Banner Hero'],
            ];
            foreach ($settings as $s) {
                DB::table('site_settings')->insert(array_merge($s, ['created_at'=>now(),'updated_at'=>now()]));
            }
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    public function down(): void
    {
        // Tidak di-rollback karena ini data awal
    }
};
