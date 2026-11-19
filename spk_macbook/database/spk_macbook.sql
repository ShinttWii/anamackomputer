-- ============================================================
-- DATABASE: spk_macbook
-- Sistem Pakar Diagnosis Kerusakan MacBook
-- anaMac Komputer (aMK)
-- ============================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+07:00";

CREATE DATABASE IF NOT EXISTS `spk_macbook` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `spk_macbook`;

-- ============================================================
-- TABEL: admin
-- ============================================================
CREATE TABLE `admin` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `nama_lengkap` VARCHAR(100) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- TABEL: kerusakan
-- ============================================================
CREATE TABLE `kerusakan` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `kode` VARCHAR(10) NOT NULL,
  `nama` VARCHAR(150) NOT NULL,
  `deskripsi` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode` (`kode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- TABEL: gejala
-- ============================================================
CREATE TABLE `gejala` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `kode` VARCHAR(10) NOT NULL,
  `nama` VARCHAR(200) NOT NULL,
  `deskripsi` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode` (`kode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- TABEL: penyebab
-- ============================================================
CREATE TABLE `penyebab` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `kode` VARCHAR(10) NOT NULL,
  `kerusakan_id` INT(11) NOT NULL,
  `deskripsi` TEXT NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode` (`kode`),
  KEY `kerusakan_id` (`kerusakan_id`),
  CONSTRAINT `fk_penyebab_kerusakan` FOREIGN KEY (`kerusakan_id`) REFERENCES `kerusakan` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- TABEL: solusi
-- ============================================================
CREATE TABLE `solusi` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `kode` VARCHAR(10) NOT NULL,
  `kerusakan_id` INT(11) NOT NULL,
  `deskripsi` TEXT NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode` (`kode`),
  KEY `kerusakan_id` (`kerusakan_id`),
  CONSTRAINT `fk_solusi_kerusakan` FOREIGN KEY (`kerusakan_id`) REFERENCES `kerusakan` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- TABEL: aturan
-- ============================================================
CREATE TABLE `aturan` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `kode` VARCHAR(10) NOT NULL,
  `kerusakan_id` INT(11) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode` (`kode`),
  KEY `kerusakan_id` (`kerusakan_id`),
  CONSTRAINT `fk_aturan_kerusakan` FOREIGN KEY (`kerusakan_id`) REFERENCES `kerusakan` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- TABEL: aturan_gejala (relasi M:N antara aturan dan gejala)
-- ============================================================
CREATE TABLE `aturan_gejala` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `aturan_id` INT(11) NOT NULL,
  `gejala_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_aturan_gejala` (`aturan_id`, `gejala_id`),
  KEY `aturan_id` (`aturan_id`),
  KEY `gejala_id` (`gejala_id`),
  CONSTRAINT `fk_ag_aturan` FOREIGN KEY (`aturan_id`) REFERENCES `aturan` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_ag_gejala` FOREIGN KEY (`gejala_id`) REFERENCES `gejala` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- TABEL: konsultasi
-- ============================================================
CREATE TABLE `konsultasi` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `model_macbook` VARCHAR(100) DEFAULT NULL,
  `hasil_kerusakan_id` INT(11) DEFAULT NULL,
  `status_diagnosis` ENUM('terdiagnosis','tidak_terdiagnosis') NOT NULL DEFAULT 'tidak_terdiagnosis',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `hasil_kerusakan_id` (`hasil_kerusakan_id`),
  CONSTRAINT `fk_konsultasi_kerusakan` FOREIGN KEY (`hasil_kerusakan_id`) REFERENCES `kerusakan` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- TABEL: konsultasi_gejala (gejala yang dipilih per konsultasi)
-- ============================================================
CREATE TABLE `konsultasi_gejala` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `konsultasi_id` INT(11) NOT NULL,
  `gejala_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `konsultasi_id` (`konsultasi_id`),
  KEY `gejala_id` (`gejala_id`),
  CONSTRAINT `fk_kg_konsultasi` FOREIGN KEY (`konsultasi_id`) REFERENCES `konsultasi` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_kg_gejala` FOREIGN KEY (`gejala_id`) REFERENCES `gejala` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- DATA AWAL: admin
-- Password: admin123 (bcrypt hash)
-- ============================================================
INSERT INTO `admin` (`username`, `password`, `nama_lengkap`) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator aMK');

-- ============================================================
-- DATA AWAL: kerusakan (data contoh - perlu diverifikasi teknisi)
-- ============================================================
INSERT INTO `kerusakan` (`kode`, `nama`, `deskripsi`) VALUES
('K001', 'Kerusakan Baterai', 'Baterai MacBook tidak dapat menyimpan daya dengan baik, mengalami penurunan kapasitas, atau tidak dapat terisi sama sekali. Kondisi ini umumnya terjadi akibat pemakaian jangka panjang atau kerusakan sel baterai.'),
('K002', 'Layar Tidak Menyala', 'Layar MacBook tidak menampilkan gambar meskipun perangkat dalam kondisi menyala. Dapat disebabkan oleh kerusakan backlight, kabel layar, atau komponen GPU.'),
('K003', 'MacBook Tidak Menyala', 'MacBook tidak merespons sama sekali saat tombol power ditekan. Tidak ada suara, indikator, maupun tanda-tanda kehidupan lainnya.'),
('K004', 'Keyboard Tidak Berfungsi', 'Sebagian atau seluruh tombol keyboard tidak merespons saat ditekan. Dapat terjadi akibat kerusakan mekanis, masuknya cairan, atau kerusakan konektor keyboard.'),
('K005', 'Overheating', 'MacBook mengalami panas berlebih yang menyebabkan kinerja menurun, kipas berputar kencang, atau perangkat mati mendadak untuk melindungi komponen internal.'),
('K006', 'WiFi Tidak Terdeteksi', 'MacBook tidak dapat mendeteksi jaringan WiFi atau kartu WiFi tidak dikenali oleh sistem operasi. Dapat disebabkan oleh kerusakan kartu WiFi atau antena.'),
('K007', 'Speaker Tidak Berfungsi', 'Tidak ada suara yang keluar dari speaker MacBook meskipun volume telah diatur. Dapat disebabkan oleh kerusakan speaker, konektor audio, atau komponen logika board.'),
('K008', 'Kamera Tidak Terdeteksi', 'FaceTime camera (webcam) tidak dikenali oleh sistem atau tidak berfungsi saat digunakan. Dapat disebabkan oleh kerusakan kamera atau kabel konektor.'),
('K009', 'MacBook Sering Hang/Freeze', 'MacBook tiba-tiba berhenti merespons, kursor tidak bergerak, atau aplikasi tidak dapat ditutup. Dapat disebabkan oleh masalah RAM, penyimpanan, atau sistem operasi.'),
('K010', 'Port USB/Thunderbolt Tidak Berfungsi', 'Port USB atau Thunderbolt pada MacBook tidak mengenali perangkat yang dihubungkan. Dapat disebabkan oleh kerusakan fisik port atau kerusakan controller.');

-- ============================================================
-- DATA AWAL: gejala
-- ============================================================
INSERT INTO `gejala` (`kode`, `nama`, `deskripsi`) VALUES
('G001', 'Baterai tidak bertambah persentasenya saat dicas', 'Ketika charger terhubung, indikator baterai tidak menunjukkan pengisian daya'),
('G002', 'MacBook hanya menyala saat terhubung charger', 'Perangkat tidak dapat beroperasi tanpa charger terhubung'),
('G003', 'Kapasitas baterai menurun drastis', 'Baterai cepat habis meski baru diisi penuh, kapasitas jauh di bawah normal'),
('G004', 'Baterai menggembung atau bengkak', 'Bagian bawah MacBook terlihat atau terasa tidak rata akibat baterai membengkak'),
('G005', 'Layar gelap total saat dinyalakan', 'Tidak ada tampilan pada layar meskipun perangkat menyala (terdengar suara boot)'),
('G006', 'Layar retak atau pecah', 'Terdapat keretakan fisik pada panel layar'),
('G007', 'Backlight layar mati (gelap tapi ada bayangan gambar)', 'Gambar masih ada namun sangat gelap, hanya terlihat jika diterangi cahaya'),
('G008', 'Layar berkedip-kedip', 'Tampilan layar tidak stabil, berkedip secara tidak teratur'),
('G009', 'MacBook tidak merespons saat tombol power ditekan', 'Tidak ada reaksi apapun saat menekan tombol power'),
('G010', 'Tidak ada lampu indikator atau suara saat dinyalakan', 'Tidak ada tanda kehidupan sama sekali pada perangkat'),
('G011', 'MacBook mati mendadak saat digunakan', 'Perangkat tiba-tiba mati tanpa peringatan saat sedang digunakan'),
('G012', 'Beberapa tombol keyboard tidak merespons', 'Satu atau beberapa tombol tidak berfungsi saat ditekan'),
('G013', 'Seluruh keyboard tidak berfungsi', 'Tidak ada tombol keyboard yang merespons sama sekali'),
('G014', 'Keyboard mengetik sendiri atau double karakter', 'Karakter muncul tanpa ditekan atau satu tekanan menghasilkan dua karakter'),
('G015', 'MacBook sangat panas saat digunakan', 'Suhu bodi MacBook sangat tinggi, terasa panas saat disentuh'),
('G016', 'Kipas berputar sangat kencang terus-menerus', 'Suara kipas sangat keras dan tidak berhenti meski aktivitas ringan'),
('G017', 'MacBook mati mendadak karena panas', 'Perangkat mati tiba-tiba dan menampilkan pesan thermal shutdown'),
('G018', 'WiFi tidak muncul di daftar jaringan', 'Tidak ada jaringan WiFi yang terdeteksi sama sekali'),
('G019', 'Ikon WiFi menampilkan tanda seru atau tidak tersedia', 'Sistem menunjukkan WiFi hardware tidak ditemukan'),
('G020', 'Tidak ada suara dari speaker', 'Volume normal namun tidak ada suara keluar dari speaker'),
('G021', 'Suara speaker pecah atau mendistorsi', 'Suara keluar namun kualitasnya buruk, pecah, atau bergetar tidak normal'),
('G022', 'Kamera tidak terdeteksi di aplikasi', 'FaceTime, Photo Booth, atau aplikasi lain tidak mendeteksi kamera'),
('G023', 'Kamera menampilkan layar hijau atau hitam', 'Kamera terdeteksi namun hanya menampilkan warna hijau atau hitam solid'),
('G024', 'MacBook sering freeze atau tidak merespons', 'Sistem tiba-tiba berhenti merespons, kursor tidak bisa digerakkan'),
('G025', 'Aplikasi sering crash sendiri', 'Aplikasi menutup sendiri secara tiba-tiba tanpa perintah'),
('G026', 'MacBook sangat lambat', 'Kinerja sistem sangat lambat, bahkan untuk tugas ringan sekalipun'),
('G027', 'Port USB tidak mengenali perangkat yang dihubungkan', 'Flash drive, mouse, atau perangkat USB lain tidak terdeteksi'),
('G028', 'Port Thunderbolt tidak berfungsi', 'Monitor eksternal, docking station, atau perangkat Thunderbolt tidak dikenali'),
('G029', 'Perangkat terkadang terdeteksi lalu hilang', 'Koneksi perangkat tidak stabil, terkadang muncul lalu hilang');

-- ============================================================
-- DATA AWAL: penyebab
-- ============================================================
INSERT INTO `penyebab` (`kode`, `kerusakan_id`, `deskripsi`) VALUES
('P001', 1, 'Sel baterai mengalami penuaan alami setelah banyak siklus pengisian'),
('P002', 1, 'Penggunaan charger tidak resmi atau daya tidak sesuai spesifikasi'),
('P003', 1, 'Kerusakan pada IC pengatur pengisian daya (charging IC) di logika board'),
('P004', 2, 'Kerusakan pada inverter atau backlight LED layar'),
('P005', 2, 'Kabel layar (LVDS/eDP) putus atau longgar dari konektor'),
('P006', 2, 'Kerusakan komponen GPU pada logika board'),
('P007', 3, 'Kerusakan pada IC power management (PMU/SMC)'),
('P008', 3, 'Konektor baterai longgar atau baterai sudah tidak berfungsi sama sekali'),
('P009', 3, 'Kerusakan pada logika board yang menyebabkan tidak ada aliran daya'),
('P010', 4, 'Masuknya cairan ke dalam keyboard yang merusak membran atau sirkuit'),
('P011', 4, 'Debu atau kotoran menumpuk di bawah tombol'),
('P012', 4, 'Kerusakan konektor keyboard pada logika board'),
('P013', 5, 'Ventilasi tersumbat debu sehingga aliran udara terhambat'),
('P014', 5, 'Pasta termal pada prosesor sudah kering dan tidak efektif'),
('P015', 5, 'Kipas pendingin rusak atau tidak berputar optimal'),
('P016', 6, 'Kartu WiFi (AirPort card) mengalami kerusakan fisik'),
('P017', 6, 'Konektor atau kabel antena WiFi lepas atau rusak'),
('P018', 7, 'Speaker mengalami kerusakan fisik akibat volume tinggi atau benturan'),
('P019', 7, 'Konektor speaker pada logika board longgar atau rusak'),
('P020', 8, 'Kabel konektor kamera putus atau longgar'),
('P021', 8, 'Modul kamera FaceTime mengalami kerusakan internal'),
('P022', 9, 'Kapasitas RAM tidak mencukupi untuk beban kerja yang diberikan'),
('P023', 9, 'Penyimpanan (SSD) hampir penuh atau mengalami masalah'),
('P024', 9, 'Adanya malware atau proses sistem yang berjalan berlebihan'),
('P025', 10, 'Kerusakan fisik pada port akibat benturan atau benda asing'),
('P026', 10, 'Kerusakan pada controller USB/Thunderbolt di logika board');

-- ============================================================
-- DATA AWAL: solusi
-- ============================================================
INSERT INTO `solusi` (`kode`, `kerusakan_id`, `deskripsi`) VALUES
('S001', 1, 'Lakukan penggantian baterai dengan baterai original atau berkualitas tinggi yang sesuai model MacBook Anda'),
('S002', 1, 'Selalu gunakan charger original Apple (MagSafe/USB-C) atau charger bersertikat MFi'),
('S003', 1, 'Bawa ke teknisi untuk pemeriksaan IC pengisian daya dan logika board'),
('S004', 2, 'Hubungkan MacBook ke monitor eksternal untuk memastikan masalah ada di layar, bukan GPU'),
('S005', 2, 'Bawa ke teknisi untuk penggantian kabel layar atau modul layar'),
('S006', 2, 'Jika penyebab GPU, pertimbangkan perbaikan atau penggantian logika board'),
('S007', 3, 'Coba reset SMC (System Management Controller) terlebih dahulu'),
('S008', 3, 'Pastikan baterai terhubung dengan baik, coba cas beberapa saat sebelum menyalakan'),
('S009', 3, 'Bawa ke teknisi untuk diagnosa dan perbaikan logika board'),
('S010', 4, 'Segera matikan MacBook jika terkena cairan, jangan nyalakan sebelum dipastikan kering'),
('S011', 4, 'Gunakan keyboard eksternal sebagai alternatif sementara'),
('S012', 4, 'Bawa ke teknisi untuk pembersihan atau penggantian keyboard'),
('S013', 5, 'Bersihkan ventilasi MacBook dari debu menggunakan udara bertekanan'),
('S014', 5, 'Hindari meletakkan MacBook di permukaan yang menghalangi ventilasi (kasur, sofa)'),
('S015', 5, 'Bawa ke teknisi untuk penggantian pasta termal dan servis kipas'),
('S016', 6, 'Coba reset NVRAM/PRAM dan SMC terlebih dahulu'),
('S017', 6, 'Bawa ke teknisi untuk pemeriksaan dan penggantian kartu WiFi atau antena'),
('S018', 7, 'Periksa pengaturan suara di System Preferences, pastikan tidak dalam mode mute'),
('S019', 7, 'Coba gunakan headphone untuk memastikan masalah ada di speaker, bukan software'),
('S020', 7, 'Bawa ke teknisi untuk penggantian speaker atau perbaikan konektor audio'),
('S021', 8, 'Restart MacBook dan periksa apakah kamera muncul di System Information'),
('S022', 8, 'Reset SMC dan NVRAM, kemudian periksa ulang'),
('S023', 8, 'Bawa ke teknisi untuk pemeriksaan kabel dan modul kamera'),
('S024', 9, 'Tutup aplikasi yang tidak digunakan dan periksa Activity Monitor untuk proses berat'),
('S025', 9, 'Kosongkan ruang penyimpanan minimal 10-15% dari total kapasitas SSD'),
('S026', 9, 'Jalankan pemindaian malware dan pertimbangkan instal ulang macOS jika diperlukan'),
('S027', 10, 'Periksa port secara fisik, bersihkan dari debu menggunakan sikat halus'),
('S028', 10, 'Coba restart MacBook dan reset SMC'),
('S029', 10, 'Bawa ke teknisi untuk perbaikan port atau controller USB/Thunderbolt');

-- ============================================================
-- DATA AWAL: aturan
-- ============================================================
INSERT INTO `aturan` (`kode`, `kerusakan_id`) VALUES
('R001', 1),  -- Kerusakan Baterai
('R002', 1),  -- Kerusakan Baterai (aturan ke-2)
('R003', 2),  -- Layar Tidak Menyala
('R004', 2),  -- Layar Tidak Menyala (aturan ke-2)
('R005', 3),  -- MacBook Tidak Menyala
('R006', 4),  -- Keyboard Tidak Berfungsi
('R007', 4),  -- Keyboard Tidak Berfungsi (aturan ke-2)
('R008', 5),  -- Overheating
('R009', 5),  -- Overheating (aturan ke-2)
('R010', 6),  -- WiFi Tidak Terdeteksi
('R011', 7),  -- Speaker Tidak Berfungsi
('R012', 8),  -- Kamera Tidak Terdeteksi
('R013', 9),  -- MacBook Sering Hang
('R014', 9),  -- MacBook Sering Hang (aturan ke-2)
('R015', 10); -- Port USB/Thunderbolt Tidak Berfungsi

-- ============================================================
-- DATA AWAL: aturan_gejala (kondisi setiap aturan)
-- ============================================================
-- R001: Baterai tidak cas + hanya menyala saat cas → Kerusakan Baterai
INSERT INTO `aturan_gejala` (`aturan_id`, `gejala_id`) VALUES (1, 1), (1, 2);

-- R002: Kapasitas turun + baterai bengkak → Kerusakan Baterai
INSERT INTO `aturan_gejala` (`aturan_id`, `gejala_id`) VALUES (2, 3), (2, 4);

-- R003: Layar gelap + backlight mati → Layar Tidak Menyala
INSERT INTO `aturan_gejala` (`aturan_id`, `gejala_id`) VALUES (3, 5), (3, 7);

-- R004: Layar retak + layar berkedip → Layar Tidak Menyala
INSERT INTO `aturan_gejala` (`aturan_id`, `gejala_id`) VALUES (4, 6), (4, 8);

-- R005: Tidak merespons tombol power + tidak ada indikator + mati mendadak → Tidak Menyala
INSERT INTO `aturan_gejala` (`aturan_id`, `gejala_id`) VALUES (5, 9), (5, 10), (5, 11);

-- R006: Beberapa tombol tidak merespons → Keyboard Tidak Berfungsi
INSERT INTO `aturan_gejala` (`aturan_id`, `gejala_id`) VALUES (6, 12);

-- R007: Seluruh keyboard mati + double karakter → Keyboard Tidak Berfungsi
INSERT INTO `aturan_gejala` (`aturan_id`, `gejala_id`) VALUES (7, 13), (7, 14);

-- R008: MacBook sangat panas + kipas kencang → Overheating
INSERT INTO `aturan_gejala` (`aturan_id`, `gejala_id`) VALUES (8, 15), (8, 16);

-- R009: Kipas kencang + mati karena panas → Overheating
INSERT INTO `aturan_gejala` (`aturan_id`, `gejala_id`) VALUES (9, 16), (9, 17);

-- R010: WiFi tidak muncul + ikon error → WiFi Tidak Terdeteksi
INSERT INTO `aturan_gejala` (`aturan_id`, `gejala_id`) VALUES (10, 18), (10, 19);

-- R011: Tidak ada suara + suara pecah → Speaker Tidak Berfungsi
INSERT INTO `aturan_gejala` (`aturan_id`, `gejala_id`) VALUES (11, 20), (11, 21);

-- R012: Kamera tidak terdeteksi + layar hijau/hitam → Kamera Tidak Terdeteksi
INSERT INTO `aturan_gejala` (`aturan_id`, `gejala_id`) VALUES (12, 22), (12, 23);

-- R013: Sering freeze + aplikasi crash → MacBook Hang
INSERT INTO `aturan_gejala` (`aturan_id`, `gejala_id`) VALUES (13, 24), (13, 25);

-- R014: Sangat lambat + freeze → MacBook Hang
INSERT INTO `aturan_gejala` (`aturan_id`, `gejala_id`) VALUES (14, 26), (14, 24);

-- R015: USB tidak mengenali + Thunderbolt tidak berfungsi → Port Tidak Berfungsi
INSERT INTO `aturan_gejala` (`aturan_id`, `gejala_id`) VALUES (15, 27), (15, 28);
