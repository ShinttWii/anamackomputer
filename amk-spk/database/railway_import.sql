-- ============================================================
-- Railway MySQL Import — anaMac Komputer (aMK)
-- Jalankan di: Railway → MySQL → Database → kotak query
-- ============================================================

SET FOREIGN_KEY_CHECKS=0;

TRUNCATE TABLE aturan_gejalas;
TRUNCATE TABLE konsultasi_gejalas;
TRUNCATE TABLE konsultasis;
TRUNCATE TABLE aturans;
TRUNCATE TABLE solusis;
TRUNCATE TABLE penyebabs;
TRUNCATE TABLE gejalas;
TRUNCATE TABLE kerusakans;
TRUNCATE TABLE admins;
TRUNCATE TABLE site_settings;

SET FOREIGN_KEY_CHECKS=1;

-- ── ADMINS ────────────────────────────────────────────────────
-- Password: (sesuai password lokal kamu)
INSERT INTO `admins` (`id`, `username`, `password`, `nama_lengkap`, `email`, `email_pending`, `email_verify_token`, `email_verify_expires_at`, `email_change_otp`, `email_change_otp_expires_at`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$12$xCNLq4lQqzArxG6ZAFkIPOst2w8toF5G78MH9E8R50P/22tww6YSi', 'Administrator aMK', '28.dewi.28.shinta@gmail.com', NULL, NULL, NULL, NULL, NULL, '2026-11-04 09:23:23', '2026-11-19 14:53:33');

-- ── KERUSAKANS ────────────────────────────────────────────────
INSERT INTO `kerusakans` (`id`, `kode`, `nama`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1,  'K001', 'MacBook Tidak Bisa Menyala',                               'Kondisi ketika MacBook tidak dapat dinyalakan atau mengalami masalah saat menerima daya dari charger.',                                                   '2026-11-07 07:59:21', '2026-11-07 07:59:46'),
(2,  'K002', 'MacBook Menyala tetapi Layar Hitam',                       'Kondisi ketika MacBook sudah menyala, tetapi layar tidak menampilkan gambar atau tampilan apa pun.',                                                           '2026-11-07 08:00:46', '2026-11-07 08:00:46'),
(3,  'K003', 'Baterai MacBook Tidak Mengisi',                            'Kondisi ketika baterai MacBook tidak menerima pengisian daya meskipun telah dihubungkan ke charger.',                                                           '2026-11-07 08:02:16', '2026-11-07 08:02:16'),
(4,  'K004', 'Baterai MacBook Cepat Habis',                              'Kondisi ketika daya baterai berkurang dengan cepat atau mengalami penurunan kapasitas sehingga tidak dapat bertahan lama.',                                      '2026-11-07 08:02:46', '2026-11-07 08:02:46'),
(5,  'K005', 'MacBook Cepat Panas',                                      'Kondisi ketika suhu MacBook meningkat secara berlebihan dan kipas mengeluarkan suara yang lebih kencang dari biasanya.',                                          '2026-11-07 08:03:26', '2026-11-07 08:03:26'),
(6,  'K006', 'MacBook Berjalan Lambat',                                  'Kondisi ketika performa MacBook menurun sehingga membutuhkan waktu lebih lama untuk menjalankan aplikasi atau aktivitas lainnya.',                               '2026-11-07 08:04:03', '2026-11-07 08:04:03'),
(7,  'K007', 'MacBook Sering Macet (Freeze)',                            'Kondisi ketika MacBook mengalami hang atau berhenti merespons sehingga aktivitas pengguna terganggu.',                                                            '2026-11-07 08:04:53', '2026-11-07 08:04:53'),
(8,  'K008', 'MacBook Gagal Masuk macOS',                                'Kondisi ketika MacBook tidak dapat melanjutkan proses masuk ke sistem operasi macOS dan berhenti pada tampilan tertentu.',                                        '2026-11-07 08:05:52', '2026-11-07 08:05:52'),
(9,  'K009', 'Layar MacBook Berkedip atau Bergaris',                     'Kondisi ketika layar menampilkan garis atau mengalami kedipan (flicker) yang mengganggu tampilan.',                                                               '2026-11-07 08:06:20', '2026-11-07 08:06:20'),
(10, 'K010', 'Keyboard MacBook Tidak Berfungsi',                         'Kondisi ketika keyboard tidak dapat digunakan untuk mengetik atau terdapat tombol yang macet.',                                                                    '2026-11-07 08:06:54', '2026-11-07 08:06:54'),
(11, 'K011', 'Trackpad MacBook Tidak Berfungsi',                         'Kondisi ketika trackpad tidak dapat digunakan untuk menggerakkan kursor atau menjalankan fungsi sentuh.',                                                          '2026-11-07 08:07:32', '2026-11-07 08:07:32'),
(12, 'K012', 'MacBook Tidak Dapat Mengaktifkan Wi-Fi atau Terhubung ke Jaringan', 'Kondisi ketika MacBook mengalami kegagalan mengaktifkan Wi-Fi atau tidak dapat terhubung ke jaringan nirkabel.',                                       '2026-11-07 08:08:04', '2026-11-07 08:08:04'),
(13, 'K013', 'MacBook Tidak Mengeluarkan Suara',                         'Kondisi ketika MacBook tidak mengeluarkan suara meskipun perangkat sedang digunakan untuk memutar audio.',                                                        '2026-11-07 08:08:29', '2026-11-07 08:08:29'),
(14, 'K014', 'MacBook Mati atau Restart Sendiri',                        'Kondisi ketika MacBook tiba-tiba mati atau melakukan restart secara otomatis tanpa perintah pengguna.',                                                            '2026-11-07 08:08:58', '2026-11-07 08:08:58'),
(15, 'K015', 'SSD atau Penyimpanan MacBook Bermasalah',                  'Kondisi ketika SSD mengalami gangguan sehingga perangkat penyimpanan tidak dapat terbaca oleh MacBook.',                                                           '2026-11-07 08:09:28', '2026-11-07 08:09:28');

-- ── GEJALAS ───────────────────────────────────────────────────
INSERT INTO `gejalas` (`id`, `kode`, `nama`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1,  'G001', 'MacBook Tidak Bisa Mengisi Daya',    'MacBook tidak dapat mengisi daya ketika dihubungkan dengan charger.',                                              '2026-11-07 08:14:14', '2026-11-07 08:14:40'),
(3,  'G002', 'Layar Tidak Menampilkan Gambar',     'MacBook menyala, tetapi layar tidak menampilkan gambar atau tampilan apa pun (no display).',                       '2026-11-07 08:15:33', '2026-11-07 08:15:33'),
(4,  'G003', 'MacBook Mati',                       'MacBook berada dalam kondisi mati dan tidak dapat digunakan.',                                                     '2026-11-07 08:16:11', '2026-11-07 08:16:11'),
(5,  'G004', 'Baterai Cepat Habis',               'Daya baterai cepat berkurang atau mengalami penurunan daya (drop).',                                               '2026-11-07 08:16:53', '2026-11-07 08:16:53'),
(6,  'G005', 'MacBook Cepat Panas',               'Suhu MacBook meningkat dan terasa panas saat digunakan.',                                                          '2026-11-07 08:17:17', '2026-11-07 08:17:34'),
(7,  'G006', 'Kipas Berbunyi Kencang',            'Kipas MacBook mengeluarkan suara yang lebih kencang dari biasanya.',                                               '2026-11-07 08:18:11', '2026-11-07 08:18:11'),
(8,  'G007', 'MacBook Berjalan Lambat',           'Performa MacBook menurun dan proses menjalankan aplikasi terasa lambat.',                                           '2026-11-07 08:18:54', '2026-11-07 08:18:54'),
(9,  'G008', 'MacBook Mengalami Hang',            'MacBook berhenti merespons atau mengalami macet (freeze).',                                                        '2026-11-07 08:19:27', '2026-11-07 08:19:27'),
(10, 'G009', 'Gagal Masuk Sistem macOS',          'MacBook berhenti pada proses masuk sistem dan tidak berhasil membuka macOS.',                                      '2026-11-07 08:20:19', '2026-11-07 08:20:19'),
(11, 'G010', 'Layar Berkedip atau Bergaris',      'Layar MacBook menampilkan garis atau mengalami kedipan (flicker).',                                                '2026-11-07 08:20:59', '2026-11-07 08:20:59'),
(12, 'G011', 'Keyboard Tidak Berfungsi',          'Keyboard MacBook tidak dapat digunakan atau mengalami masalah pada tombolnya.',                                    '2026-11-07 08:21:46', '2026-11-07 08:21:46'),
(13, 'G012', 'Trackpad Tidak Dapat Digerakkan',  'Trackpad MacBook tidak merespons ketika digunakan untuk menggerakkan kursor.',                                     '2026-11-07 08:22:16', '2026-11-07 08:22:16'),
(14, 'G013', 'Wi-Fi Tidak Dapat Terhubung',      'MacBook gagal mengaktifkan Wi-Fi atau tidak dapat terhubung ke jaringan nirkabel.',                                '2026-11-07 08:22:49', '2026-11-07 08:22:49'),
(15, 'G014', 'Tidak Ada Suara',                  'MacBook tidak mengeluarkan suara ketika digunakan untuk memutar audio.',                                            '2026-11-07 08:23:22', '2026-11-07 08:23:22'),
(16, 'G015', 'Restart Otomatis',                 'MacBook melakukan restart secara otomatis tanpa perintah dari pengguna.',                                           '2026-11-07 08:24:00', '2026-11-07 08:24:00'),
(17, 'G016', 'SSD Tidak Terbaca',               'SSD atau media penyimpanan MacBook tidak dapat terdeteksi oleh sistem.',                                            '2026-11-07 08:24:29', '2026-11-07 08:24:29');

-- ── PENYEBABS ─────────────────────────────────────────────────
INSERT INTO `penyebabs` (`id`, `kode`, `kerusakan_id`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1,  'P001', 1,  'Kondisi ini dapat disebabkan oleh baterai yang kosong, charger yang rusak, atau adanya masalah pada mesin MacBook.',                                                            '2026-11-07 08:29:57', '2026-11-07 08:29:57'),
(2,  'P002', 2,  'Penyebabnya dapat berupa LCD yang pecah, kabel LCD yang robek, atau adanya masalah pada logic board.',                                                                          '2026-11-07 08:30:29', '2026-11-07 08:30:29'),
(3,  'P003', 3,  'Masalah ini dapat disebabkan oleh charger yang rusak atau mati, serta kondisi baterai yang sudah mengalami kerusakan dan perlu diganti.',                                       '2026-11-07 08:30:53', '2026-11-07 08:30:53'),
(4,  'P004', 4,  'Kondisi ini disebabkan oleh baterai yang sudah mengalami penurunan kualitas atau usia pemakaian sehingga perlu segera diganti.',                                                '2026-11-07 08:31:22', '2026-11-07 08:31:22'),
(5,  'P005', 5,  'Panas berlebih dapat disebabkan oleh debu atau kotoran yang menyumbat bagian dalam MacBook, serta kipas pendingin yang mati.',                                                  '2026-11-07 08:31:51', '2026-11-07 08:31:51'),
(6,  'P006', 6,  'Performa MacBook dapat menurun akibat kapasitas penyimpanan yang penuh atau media penyimpanan yang mengalami kerusakan.',                                                       '2026-11-07 08:32:12', '2026-11-07 08:32:12'),
(7,  'P007', 7,  'Kondisi MacBook yang sering mengalami hang dapat disebabkan oleh media penyimpanan yang rusak.',                                                                               '2026-11-07 08:32:39', '2026-11-07 08:32:39'),
(8,  'P008', 8,  'Kegagalan masuk ke sistem operasi dapat disebabkan oleh macOS yang mengalami crash atau gangguan sistem.',                                                                      '2026-11-07 08:33:01', '2026-11-07 08:33:01'),
(9,  'P009', 9,  'Gangguan tampilan berupa garis atau kedipan pada layar dapat disebabkan oleh LCD yang mengalami kerusakan.',                                                                    '2026-11-07 08:33:27', '2026-11-07 08:33:27'),
(10, 'P010', 10, 'Keyboard tidak berfungsi dapat disebabkan oleh tombol keyboard yang macet (stuck key).',                                                                                       '2026-11-07 08:33:47', '2026-11-07 08:33:47'),
(11, 'P011', 11, 'Masalah ini dapat disebabkan oleh kabel trackpad yang rusak atau komponen trackpad yang mengalami kerusakan.',                                                                   '2026-11-07 08:34:50', '2026-11-07 08:34:50'),
(12, 'P012', 12, 'Gangguan koneksi Wi-Fi dapat disebabkan oleh kesalahan memasukkan password jaringan atau kerusakan pada Wi-Fi card.',                                                           '2026-11-07 08:35:13', '2026-11-07 08:35:13'),
(13, 'P013', 13, 'Tidak adanya suara dapat disebabkan oleh volume yang terlalu rendah atau adanya masalah pada logic board.',                                                                     '2026-11-07 08:35:40', '2026-11-07 08:35:40'),
(14, 'P014', 14, 'MacBook yang mati atau melakukan restart secara otomatis dapat disebabkan oleh macOS yang mengalami crash.',                                                                    '2026-11-07 08:36:09', '2026-11-07 08:36:09'),
(15, 'P015', 15, 'Masalah penyimpanan dapat disebabkan oleh SSD yang mengalami kerusakan sehingga tidak dapat terbaca oleh sistem.',                                                              '2026-11-07 08:36:27', '2026-11-07 08:36:27');

-- ── SOLUSIS ───────────────────────────────────────────────────
INSERT INTO `solusis` (`id`, `kode`, `kerusakan_id`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1,  'S001', 1,  'Lakukan pemeriksaan pada charger yang digunakan. Jika charger mengalami kerusakan, lakukan penggantian charger. Apabila MacBook tetap tidak menyala, diperlukan pemeriksaan lebih lanjut pada bagian mesin.',                        '2026-11-07 08:42:01', '2026-11-07 08:46:37'),
(2,  'S002', 2,  'Periksa kondisi LCD dan kabel LCD. Jika LCD pecah, lakukan penggantian LCD. Apabila kabel LCD robek, lakukan perbaikan kabel. Jika terdapat masalah pada logic board, lakukan perbaikan atau penggantian logic board.',              '2026-11-07 08:47:10', '2026-11-07 08:47:10'),
(3,  'S003', 3,  'Periksa kondisi charger yang digunakan. Jika charger rusak atau mati, lakukan penggantian charger. Apabila baterai mengalami kerusakan, lakukan penggantian baterai.',                                                               '2026-11-07 08:47:39', '2026-11-07 08:47:39'),
(4,  'S004', 4,  'Periksa kondisi kesehatan baterai MacBook. Jika baterai sudah mengalami penurunan kualitas atau sudah waktunya diganti, lakukan penggantian baterai.',                                                                               '2026-11-07 08:48:01', '2026-11-07 08:48:01'),
(5,  'S005', 5,  'Periksa bagian pendingin MacBook. Bersihkan debu atau kotoran yang menyumbat bagian dalam perangkat. Jika kipas mengalami kerusakan atau mati, lakukan penggantian kipas.',                                                          '2026-11-07 08:49:19', '2026-11-07 08:49:19'),
(6,  'S006', 6,  'Periksa kondisi media penyimpanan MacBook. Jika penyimpanan penuh atau mengalami kerusakan, lakukan penggantian atau upgrade penyimpanan sesuai kondisi perangkat.',                                                                 '2026-11-07 08:49:39', '2026-11-07 08:49:39'),
(7,  'S007', 7,  'Periksa kondisi media penyimpanan MacBook. Jika penyimpanan mengalami kerusakan, lakukan penggantian penyimpanan agar perangkat dapat berfungsi kembali dengan baik.',                                                               '2026-11-07 08:49:56', '2026-11-07 08:49:56'),
(8,  'S008', 8,  'Periksa kondisi sistem operasi macOS. Jika terjadi crash atau gangguan pada sistem operasi yang menyebabkan MacBook gagal masuk ke sistem, lakukan instalasi ulang macOS.',                                                          '2026-11-07 08:52:33', '2026-11-07 08:52:33'),
(9,  'S009', 9,  'Periksa kondisi LCD MacBook. Jika LCD mengalami kerusakan yang menyebabkan layar berkedip atau menampilkan garis, lakukan penggantian LCD.',                                                                                        '2026-11-07 08:52:51', '2026-11-07 08:52:51'),
(10, 'S010', 10, 'Periksa kondisi keyboard dan tombol yang tidak berfungsi. Jika keyboard mengalami kerusakan atau terdapat tombol yang macet (stuck key), lakukan penggantian keyboard.',                                                             '2026-11-07 08:53:09', '2026-11-07 08:53:09'),
(11, 'S011', 11, 'Periksa kondisi kabel dan trackpad MacBook. Jika kabel trackpad mengalami kerusakan, lakukan penggantian kabel. Apabila komponen trackpad rusak, lakukan penggantian trackpad.',                                                     '2026-11-07 08:53:57', '2026-11-07 08:53:57'),
(12, 'S012', 12, 'Periksa kembali password jaringan Wi-Fi yang digunakan. Jika masalah disebabkan oleh kerusakan pada Wi-Fi card, lakukan penggantian Wi-Fi card.',                                                                                   '2026-11-07 08:54:18', '2026-11-07 08:54:18'),
(13, 'S013', 13, 'Periksa pengaturan volume suara MacBook dan naikkan volume jika terlalu rendah. Jika terdapat masalah pada logic board, lakukan servis atau penggantian logic board sesuai kondisi kerusakan.',                                      '2026-11-07 08:54:37', '2026-11-07 08:54:37'),
(14, 'S014', 14, 'Periksa kondisi sistem operasi macOS. Jika MacBook mati atau melakukan restart secara otomatis akibat macOS mengalami crash, lakukan instalasi ulang macOS.',                                                                        '2026-11-07 08:54:56', '2026-11-07 08:54:56'),
(15, 'S015', 15, 'Periksa kondisi SSD MacBook. Jika SSD mengalami kerusakan sehingga tidak dapat terbaca oleh sistem, lakukan penggantian SSD.',                                                                                                      '2026-11-07 08:55:47', '2026-11-07 08:55:47');

-- ── ATURANS ───────────────────────────────────────────────────
INSERT INTO `aturans` (`id`, `kode`, `kerusakan_id`, `created_at`, `updated_at`) VALUES
(2,  'R001', 1,  '2026-11-07 09:03:52', '2026-11-07 09:03:52'),
(3,  'R002', 2,  '2026-11-07 09:04:04', '2026-11-07 09:04:04'),
(4,  'R003', 3,  '2026-11-07 09:04:16', '2026-11-07 09:04:16'),
(5,  'R004', 4,  '2026-11-07 09:06:07', '2026-11-07 09:06:07'),
(6,  'R005', 5,  '2026-11-07 09:06:18', '2026-11-07 09:06:18'),
(7,  'R006', 6,  '2026-11-07 09:06:32', '2026-11-07 09:06:32'),
(8,  'R007', 7,  '2026-11-07 09:06:44', '2026-11-07 09:06:44'),
(9,  'R008', 8,  '2026-11-07 09:09:58', '2026-11-07 09:09:58'),
(10, 'R009', 9,  '2026-11-07 09:11:01', '2026-11-07 09:11:01'),
(11, 'R010', 10, '2026-11-07 09:11:19', '2026-11-07 09:12:41'),
(12, 'R011', 11, '2026-11-07 09:13:04', '2026-11-07 09:13:04'),
(13, 'R012', 12, '2026-11-07 09:13:22', '2026-11-07 09:13:22'),
(14, 'R013', 13, '2026-11-07 09:13:43', '2026-11-07 09:13:43'),
(15, 'R014', 14, '2026-11-07 09:13:54', '2026-11-07 09:13:54'),
(16, 'R015', 15, '2026-11-07 09:14:16', '2026-11-07 09:14:16');

-- ── ATURAN_GEJALAS ────────────────────────────────────────────
INSERT INTO `aturan_gejalas` (`id`, `aturan_id`, `gejala_id`) VALUES
(2,  2,  1),
(3,  3,  3),
(4,  4,  4),
(5,  5,  5),
(6,  6,  6),
(9,  6,  7),
(10, 7,  8),
(11, 8,  9),
(12, 9,  10),
(13, 10, 11),
(15, 11, 12),
(16, 12, 13),
(17, 13, 14),
(18, 14, 15),
(19, 15, 16),
(20, 16, 17);

-- ── SITE_SETTINGS ─────────────────────────────────────────────
INSERT INTO `site_settings` (`id`, `kunci`, `nilai`, `tipe`, `label`, `created_at`, `updated_at`) VALUES
(1, 'hero_judul',        'Diagnosis Kerusakan MacBook Dengan Cepat',                                                                                                                                      'text',  'Judul Hero',        '2026-11-08 07:47:34', '2026-11-19 12:16:13'),
(2, 'hero_deskripsi',    'Temukan kemungkinan kerusakan MacBook Anda berdasarkan gejala yang dialami. Sistem akan memberikan analisis awal lengkap dengan penyebab dan solusi penanganan.',                'text',  'Deskripsi Hero',    '2026-11-08 07:47:34', '2026-11-19 12:16:13'),
(3, 'tentang_deskripsi', 'anaMac Komputer adalah toko layanan perbaikan MacBook. Sistem pakar ini dikembangkan untuk membantu pengguna mengetahui kemungkinan kerusakan MacBook sebelum dibawa ke teknisi.','text',  'Deskripsi Tentang', '2026-11-08 07:47:34', '2026-11-19 12:16:13'),
(4, 'logo',              NULL,                                                                                                                                                                             'image', 'Logo aMK',          '2026-11-08 07:47:34', '2026-11-19 12:16:13'),
(5, 'banner_hero',       NULL,                                                                                                                                                                             'image', 'Banner Hero',       '2026-11-08 07:47:34', '2026-11-19 12:16:13');

-- ── KONSULTASIS ───────────────────────────────────────────────
INSERT INTO `konsultasis` (`id`, `model_macbook`, `hasil_kerusakan_id`, `status_diagnosis`, `created_at`, `updated_at`) VALUES
(1, NULL,          1,  'terdiagnosis', '2026-11-07 08:44:04', '2026-11-07 08:44:04'),
(2, 'macbook air', 2,  'terdiagnosis', '2026-11-08 07:36:09', '2026-11-08 07:36:09'),
(3, NULL,          2,  'terdiagnosis', '2026-11-08 07:40:14', '2026-11-08 07:40:14'),
(4, NULL,          4,  'terdiagnosis', '2026-11-09 14:05:46', '2026-11-09 14:05:46'),
(5, NULL,          1,  'terdiagnosis', '2026-11-09 14:37:36', '2026-11-09 14:37:36'),
(6, NULL,          14, 'terdiagnosis', '2026-11-19 13:35:32', '2026-11-19 13:35:32'),
(7, NULL,          13, 'terdiagnosis', '2026-11-19 13:42:58', '2026-11-19 13:42:58'),
(8, 'Macbook air', 1,  'terdiagnosis', '2026-11-19 15:40:25', '2026-11-19 15:40:25');

-- ── KONSULTASI_GEJALAS ────────────────────────────────────────
INSERT INTO `konsultasi_gejalas` (`id`, `konsultasi_id`, `gejala_id`) VALUES
(1,  1, 1),
(2,  2, 3),
(3,  2, 4),
(4,  3, 3),
(5,  4, 5),
(6,  4, 6),
(7,  5, 1),
(8,  5, 4),
(9,  6, 16),
(10, 7, 15),
(11, 7, 17),
(12, 8, 1),
(13, 8, 3),
(14, 8, 5);
