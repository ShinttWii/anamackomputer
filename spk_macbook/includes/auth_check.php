<?php
/**
 * Auth Check - Proteksi halaman admin
 * Sertakan file ini di awal setiap halaman admin
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin_id']) || !isset($_SESSION['admin_username'])) {
    header('Location: ' . BASE_URL . '/admin/login.php?redirect=' . urlencode($_SERVER['REQUEST_URI']));
    exit;
}
