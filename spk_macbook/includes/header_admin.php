<?php
if (session_status() === PHP_SESSION_NONE) session_start();

if (!defined('BASE_URL')) {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    // Auto-detect base path
    $script = str_replace('\\', '/', dirname($_SERVER['SCRIPT_FILENAME']));
    $docroot = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);
    $basePath = str_replace($docroot, '', $script);
    // Walk up to spk_macbook root
    $parts = explode('/', trim($basePath, '/'));
    $rootIdx = array_search('spk_macbook', $parts);
    if ($rootIdx !== false) {
        $rootPath = '/' . implode('/', array_slice($parts, 0, $rootIdx + 1));
    } else {
        $rootPath = '/' . implode('/', $parts);
    }
    define('BASE_URL', $protocol . '://' . $host . $rootPath);
}

require_once dirname(__DIR__, 1) . '/config/database.php';
require_once dirname(__DIR__, 1) . '/includes/functions.php';
require_once dirname(__DIR__, 1) . '/includes/csrf.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? e($pageTitle) . ' — ' : '' ?>Admin | SPK MacBook aMK</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/admin.css">
</head>
<body class="admin-body">
<?php require_once dirname(__DIR__, 1) . '/includes/sidebar_admin.php'; ?>

<!-- Main Content Wrapper -->
<div class="admin-main" id="adminMain">
    <!-- Top Bar -->
    <div class="admin-topbar">
        <button class="btn btn-sm btn-outline-secondary" id="sidebarToggle">
            <i class="bi bi-list fs-5"></i>
        </button>
        <div class="topbar-title">
            <?= isset($pageTitle) ? e($pageTitle) : 'Dashboard' ?>
        </div>
        <div class="topbar-user">
            <i class="bi bi-person-circle text-orange me-1"></i>
            <span class="fw-medium"><?= e($_SESSION['admin_nama'] ?? 'Admin') ?></span>
            <a href="<?= BASE_URL ?>/admin/logout.php" class="btn btn-sm btn-outline-danger ms-3"
               onclick="return confirm('Yakin ingin logout?')">
                <i class="bi bi-box-arrow-left"></i>
            </a>
        </div>
    </div>

    <!-- Content Area -->
    <div class="admin-content">
        <?= showFlash() ?>
