<?php
/**
 * Konfigurasi Koneksi Database
 * Sistem Pakar Diagnosis Kerusakan MacBook - anaMac Komputer (aMK)
 */

define('DB_HOST', 'localhost');
define('DB_NAME', 'spk_macbook');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

/**
 * Membuat koneksi PDO ke database
 * @return PDO
 */
function getDB(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            // Jangan tampilkan detail error ke pengguna
            error_log("Database connection error: " . $e->getMessage());
            die('<div style="font-family:sans-serif;padding:2rem;color:#721c24;background:#f8d7da;border-radius:8px;margin:2rem;">
                <strong>Koneksi database gagal.</strong><br>
                Pastikan XAMPP berjalan dan database <em>spk_macbook</em> sudah diimport.
                </div>');
        }
    }
    return $pdo;
}
