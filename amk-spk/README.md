# Sistem Pakar Diagnosis Kerusakan MacBook
**anaMac Komputer (aMK)** — Proyek Akhir

Sistem pakar berbasis web menggunakan metode **Forward Chaining** untuk mendiagnosis kerusakan MacBook berdasarkan gejala yang dipilih pengguna.

🌐 **Live Demo:** [anamackomputer-production.up.railway.app](https://anamackomputer-production.up.railway.app)

---

## Teknologi

| Komponen | Detail |
|----------|--------|
| Backend  | Laravel 11 (PHP 8.3) |
| Database | MySQL |
| Frontend | Bootstrap 5, HTML, CSS, JavaScript |
| Template | Blade |
| ORM      | Eloquent |
| Metode   | Forward Chaining |
| Deploy   | Railway |

---

## Fitur Sistem

### Customer (Tanpa Login)
- Beranda dengan informasi sistem
- Panduan penggunaan sistem
- Informasi kerusakan MacBook
- Konsultasi diagnosis — pilih gejala → hasil diagnosis lengkap
- Cetak hasil diagnosis

### Admin (Login Diperlukan)
- Dashboard statistik real-time
- CRUD Data Kerusakan
- CRUD Data Gejala
- CRUD Data Penyebab
- CRUD Data Solusi
- CRUD Aturan Diagnosis (Forward Chaining)
- Riwayat konsultasi & detail
- Kelola konten (judul, deskripsi, logo, banner)

---

## Cara Kerja Forward Chaining

```
1. Customer pilih gejala  →  menjadi FAKTA AWAL
2. Sistem ambil semua ATURAN dari database
3. Tiap aturan: cek apakah SEMUA gejala kondisinya ada di fakta
4. Jika terpenuhi → kerusakan ditambahkan ke HASIL DIAGNOSIS
5. Ulangi sampai tidak ada aturan baru yang cocok
6. Tampilkan hasil + penyebab + solusi
```

---

## Instalasi Lokal (XAMPP)

### Prasyarat
- XAMPP (Apache + MySQL)
- PHP 8.2+
- Composer

### Langkah

```bash
# 1. Clone repo
git clone https://github.com/ShinttWii/anamackomputer.git
cd anamackomputer/amk-spk

# 2. Install dependensi
composer install

# 3. Setup environment
copy .env.example .env
php artisan key:generate

# 4. Isi .env dengan konfigurasi database lokal
#    DB_CONNECTION=mysql
#    DB_HOST=127.0.0.1
#    DB_PORT=3306
#    DB_DATABASE=spk_macbook
#    DB_USERNAME=root
#    DB_PASSWORD=

# 5. Migrate & seed
php artisan migrate
php artisan db:seed

# 6. Storage link
php artisan storage:link

# 7. Buka di browser
#    http://localhost/anamackomputer/
```

### Akun Default

| Role  | Username | Password  |
|-------|----------|-----------|
| Admin | `admin`  | `admin123` |

---

## Struktur Database

```
admins              → akun admin
kerusakans          → jenis kerusakan MacBook
gejalas             → gejala kerusakan
penyebabs           → penyebab per kerusakan
solusis             → solusi per kerusakan
aturans             → aturan Forward Chaining
aturan_gejalas      → relasi aturan ↔ gejala (M:N)
konsultasis         → riwayat konsultasi customer
konsultasi_gejalas  → gejala yang dipilih per konsultasi
site_settings       → konten dinamis (judul, deskripsi, logo)
admin_password_resets → token reset password admin
```

---

## Deploy ke Railway

### Prasyarat
- Akun [Railway](https://railway.app)
- Repo sudah di GitHub

### Langkah Deploy

**1. Buat project baru di Railway**
- New Project → Deploy from GitHub → pilih repo `anamackomputer`
- Set **Root Directory** → `amk-spk`

**2. Tambah MySQL**
- Add Service → Database → MySQL

**3. Set Environment Variables**

```env
APP_NAME=anaMac Komputer
APP_ENV=production
APP_KEY=base64:...          # php artisan key:generate --show
APP_DEBUG=false
APP_URL=https://your-domain.up.railway.app

DB_CONNECTION=mysql
DB_HOST=                    # dari Railway MySQL → Variables → MYSQLHOST
DB_PORT=                    # MYSQLPORT
DB_DATABASE=                # MYSQLDATABASE
DB_USERNAME=                # MYSQLUSER
DB_PASSWORD=                # MYSQLPASSWORD

SESSION_DRIVER=cookie
SESSION_SECURE_COOKIE=true
CACHE_STORE=file
QUEUE_CONNECTION=sync
LOG_CHANNEL=stderr

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your@gmail.com
MAIL_FROM_NAME=anaMac Komputer
```

**4. Railway otomatis build & deploy**

Railway menggunakan `nixpacks.toml` di folder `amk-spk/` untuk:
- Install PHP 8.3 + ekstensi yang dibutuhkan
- Jalankan `composer install --no-dev`
- Jalankan `start.sh` saat startup

**5. Import data ke Railway MySQL**

Buka Railway → MySQL service → tab **Database** → kotak query, jalankan SQL dari file export phpMyAdmin lokal.

---

## Struktur Folder

```
anamackomputer/
├── amk-spk/                        ← Laravel app (Root Directory Railway)
│   ├── app/
│   │   ├── Http/Controllers/
│   │   │   ├── Admin/              ← CRUD admin
│   │   │   ├── Auth/               ← Login & reset password
│   │   │   └── Customer/           ← Halaman publik
│   │   ├── Models/                 ← Eloquent models
│   │   └── Services/
│   │       └── ForwardChainingService.php
│   ├── database/
│   │   ├── migrations/             ← Semua migration + seed data awal
│   │   └── seeders/
│   ├── public/
│   │   ├── css/                    ← style.css, admin.css
│   │   └── js/                     ← main.js
│   ├── resources/views/
│   │   ├── layouts/                ← Layout customer & admin
│   │   ├── customer/               ← Halaman publik
│   │   ├── admin/                  ← Panel admin
│   │   └── auth/                   ← Login & reset password
│   ├── routes/web.php
│   ├── nixpacks.toml               ← Konfigurasi build Railway
│   └── start.sh                    ← Script startup Railway
├── spk_macbook/                    ← Versi PHP native (legacy)
├── index.php                       ← Bridge script XAMPP
├── app.php                         ← Bridge script XAMPP
└── .htaccess                       ← Routing XAMPP
```

---

## Catatan

> Hasil diagnosis sistem ini bersifat **perkiraan awal** berdasarkan gejala yang dipilih dan **tidak menggantikan** pemeriksaan langsung oleh teknisi MacBook yang berpengalaman.
