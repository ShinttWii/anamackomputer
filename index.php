<?php
/**
 * Bridge Entry Point — anaMac Komputer (aMK)
 *
 * http://localhost/anamackomputer/         → Beranda Customer
 * http://localhost/anamackomputer/konsultasi → Konsultasi
 * http://localhost/anamackomputer/admin/    → Dashboard Admin
 * http://localhost/anamackomputer/admin/login → Login Admin
 */

$laravelPublic = __DIR__ . '/amk-spk/public';

// Ubah working directory ke public agar path relatif Laravel benar
chdir($laravelPublic);

// Jalankan public/index.php Laravel
// LARAVEL_START akan didefinisikan di sana
require $laravelPublic . '/index.php';
