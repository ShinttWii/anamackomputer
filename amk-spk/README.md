# Sistem Pakar Diagnosis Kerusakan MacBook
**anaMac Komputer (aMK)** — Proyek Akhir Mahasiswa Informatika

Sistem pakar berbasis web menggunakan metode **Forward Chaining** untuk mendiagnosis kerusakan MacBook berdasarkan gejala yang dipilih pengguna.

---

## Teknologi

| Komponen | Detail |
|----------|--------|
| Backend  | Laravel 11 (PHP 8.3) |
| Database | MySQL via XAMPP |
| Frontend | Bootstrap 5, HTML, CSS, JavaScript |
| Template | Blade |
| ORM      | Eloquent |
| Metode   | Forward Chaining |

---

## Instalasi

### Prasyarat
- XAMPP (Apache + MySQL)
- PHP 8.2+
- Composer

### Langkah Instalasi

**1. Letakkan folder proyek**
```
C:\xampp\htdocs\anamackomputer\amk-spk\
```

**2. Buka XAMPP Control Panel → Start Apache & MySQL**

**3. Install dependensi Laravel**
```bash
cd C:\xampp\htdocs\anamackomputer\amk-spk
composer install
```

**4. Salin file environment**
```bash
copy .env.example .env
php artisan key:generate
```

**5. Setup database & data awal**
```bash
php database/setup.php
```
Script ini otomatis membuat database `spk_macbook`, semua tabel, dan mengisi data awal.

**6. Buka aplikasi di browser**
```
http://localhost/anamackomputer/amk-spk/public/
```

---

## Akun Default

| Role  | Username | Password  |
|-------|----------|-----------|
| Admin | `admin`  | `admin123`|

**URL Login Admin:** `http://localhost/anamackomputer/amk-spk/public/admin/login`

> Ganti password setelah login pertama melalui phpMyAdmin.

---

## Fitur Sistem

### Customer (Tanpa Login)
- Beranda dengan informasi sistem
- Panduan penggunaan sistem
- Informasi kerusakan MacBook
- Konsultasi diagnosis (pilih gejala → hasil diagnosis)
- Cetak hasil diagnosis

### Admin (Login Diperlukan)
- Dashboard dengan statistik real-time
- CRUD Data Kerusakan
- CRUD Data Gejala  
- CRUD Data Penyebab
- CRUD Data Solusi
- CRUD Aturan Diagnosis (Forward Chaining)
- Riwayat konsultasi & detail

---

## Cara Kerja Forward Chaining

```
1. Customer pilih gejala → jadi FAKTA AWAL
2. Sistem ambil semua ATURAN dari database
3. Untuk setiap aturan: cek apakah SEMUA kondisi gejala ada di fakta
4. Jika ya → kerusakan ditambahkan ke HASIL DIAGNOSIS
5. Ulangi sampai tidak ada aturan baru yang terpenuhi
6. Tampilkan hasil + penyebab + solusi
```

---

## Struktur Database

```
admins          → akun admin
kerusakans      → jenis kerusakan MacBook
gejalas         → gejala kerusakan
penyebabs       → penyebab per kerusakan
solusis         → solusi per kerusakan
aturans         → aturan Forward Chaining
aturan_gejalas  → relasi aturan ↔ gejala (M:N)
konsultasis     → riwayat konsultasi customer
konsultasi_gejalas → gejala yang dipilih per konsultasi
```

---

## Reset Data

Untuk menghapus semua data dan mengisi ulang:
```bash
php database/setup.php --reset
```

---

## Deploy ke Railway

### Langkah Deploy

**1. Push ke GitHub** (sudah dilakukan)

**2. Buat project baru di [Railway](https://railway.app)**
- New Project → Deploy from GitHub repo → pilih `anamackomputer`
- Set **Root Directory** ke `amk-spk`

**3. Tambah MySQL database**
- Di Railway dashboard: Add Service → Database → MySQL
- Railway otomatis inject `MYSQL_URL` ke environment

**4. Set Environment Variables di Railway**
```
APP_NAME=anaMac Komputer
APP_ENV=production
APP_KEY=         ← generate: php artisan key:generate --show
APP_DEBUG=false
APP_URL=         ← isi setelah Railway beri domain

DB_CONNECTION=mysql
DB_HOST=         ← dari Railway MySQL service (MYSQLHOST)
DB_PORT=         ← dari Railway MySQL service (MYSQLPORT)
DB_DATABASE=     ← dari Railway MySQL service (MYSQLDATABASE)
DB_USERNAME=     ← dari Railway MySQL service (MYSQLUSER)
DB_PASSWORD=     ← dari Railway MySQL service (MYSQLPASSWORD)

SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
LOG_CHANNEL=stderr
```

**5. Railway otomatis build & deploy** menggunakan `nixpacks.toml`

### Perintah yang dijalankan Railway saat build
```bash
composer install --no-dev --optimize-autoloader
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link
```

### Perintah saat start
```bash
php artisan migrate --force
php -S 0.0.0.0:$PORT -t public
```

---

## Catatan Penting

> Hasil diagnosis sistem ini bersifat **perkiraan awal** berdasarkan gejala yang dipilih dan **tidak menggantikan** pemeriksaan langsung oleh teknisi MacBook yang berpengalaman. Data pengetahuan adalah data contoh yang perlu diverifikasi oleh teknisi anaMac Komputer.

---

## Struktur Folder Utama

```
amk-spk/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/          ← Controller admin (CRUD)
│   │   │   ├── Auth/           ← Login/logout admin
│   │   │   └── Customer/       ← Halaman customer
│   │   └── Middleware/
│   │       └── AdminAuth.php   ← Proteksi halaman admin
│   ├── Models/                 ← Eloquent models
│   └── Services/
│       └── ForwardChainingService.php ← Mesin inferensi
├── database/
│   └── setup.php               ← Script setup database
├── public/
│   ├── css/                    ← style.css, admin.css
│   └── js/                     ← main.js
├── resources/views/
│   ├── layouts/                ← Layout customer & admin
│   ├── customer/               ← Halaman customer
│   ├── admin/                  ← Halaman admin
│   └── auth/                   ← Halaman login
└── routes/
    └── web.php                 ← Semua route
```
