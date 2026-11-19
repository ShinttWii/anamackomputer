<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once dirname(__DIR__) . '/config/database.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/csrf.php';

// Tentukan halaman aktif
$currentPage = basename($_SERVER['PHP_SELF']);
$currentDir  = basename(dirname($_SERVER['PHP_SELF']));
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? e($pageTitle) . ' — ' : '' ?>SPK MacBook | anaMac Komputer</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>
<body>

<!-- Navbar Customer -->
<nav class="navbar navbar-expand-lg navbar-customer sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="<?= BASE_URL ?>/index.php">
            <div class="brand-icon">
                <i class="bi bi-laptop"></i>
            </div>
            <div>
                <span class="brand-name">aMK</span>
                <span class="brand-sub d-none d-sm-inline">anaMac Komputer</span>
            </div>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCustomer">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCustomer">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-1">
                <li class="nav-item">
                    <a class="nav-link <?= ($currentPage === 'index.php' && $currentDir !== 'customer') ? 'active' : '' ?>"
                       href="<?= BASE_URL ?>/index.php">
                        <i class="bi bi-house me-1"></i>Beranda
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($currentPage === 'panduan.php') ? 'active' : '' ?>"
                       href="<?= BASE_URL ?>/customer/panduan.php">
                        <i class="bi bi-book me-1"></i>Panduan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($currentPage === 'informasi.php') ? 'active' : '' ?>"
                       href="<?= BASE_URL ?>/customer/informasi.php">
                        <i class="bi bi-info-circle me-1"></i>Info Kerusakan
                    </a>
                </li>
                <li class="nav-item ms-lg-2">
                    <a class="btn btn-primary-amk <?= ($currentPage === 'konsultasi.php') ? 'active' : '' ?>"
                       href="<?= BASE_URL ?>/customer/konsultasi.php">
                        <i class="bi bi-search-heart me-1"></i>Mulai Konsultasi
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
