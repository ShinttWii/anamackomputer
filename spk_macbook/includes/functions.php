<?php
/**
 * Fungsi-fungsi helper umum
 */

/**
 * Escape output HTML untuk mencegah XSS
 */
function e(string $str): string {
    return htmlspecialchars($str, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

/**
 * Redirect ke URL tertentu
 */
function redirect(string $url): void {
    header('Location: ' . $url);
    exit;
}

/**
 * Simpan pesan flash ke session
 */
function setFlash(string $type, string $message): void {
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

/**
 * Ambil dan hapus pesan flash dari session
 */
function getFlash(): ?array {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

/**
 * Tampilkan alert Bootstrap dari flash message
 */
function showFlash(): string {
    $flash = getFlash();
    if (!$flash) return '';
    $typeMap = [
        'success' => 'alert-success',
        'error'   => 'alert-danger',
        'warning' => 'alert-warning',
        'info'    => 'alert-info',
    ];
    $class = $typeMap[$flash['type']] ?? 'alert-info';
    return '<div class="alert ' . $class . ' alert-dismissible fade show" role="alert">'
         . e($flash['message'])
         . '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>'
         . '</div>';
}

/**
 * Format tanggal ke bahasa Indonesia
 */
function formatTanggal(string $date): string {
    $bulan = [
        1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',
        5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',
        9=>'September',10=>'Oktober',11=>'November',12=>'Desember'
    ];
    $ts = strtotime($date);
    return date('d', $ts) . ' ' . $bulan[(int)date('n', $ts)] . ' ' . date('Y', $ts);
}

/**
 * Generate kode otomatis berdasarkan prefix dan jumlah data
 */
function generateKode(string $prefix, int $count): string {
    return $prefix . str_pad($count + 1, 3, '0', STR_PAD_LEFT);
}
