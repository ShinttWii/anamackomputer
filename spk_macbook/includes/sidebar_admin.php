<?php
$currentPage = basename($_SERVER['PHP_SELF']);
$currentDir  = basename(dirname($_SERVER['PHP_SELF']));
?>
<!-- Sidebar Admin -->
<aside class="admin-sidebar" id="adminSidebar">
    <div class="sidebar-header">
        <div class="d-flex align-items-center gap-2">
            <div class="brand-icon"><i class="bi bi-laptop"></i></div>
            <div>
                <div class="brand-name">aMK</div>
                <div class="brand-sub">Panel Admin</div>
            </div>
        </div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section-label">Utama</div>
        <a href="<?= BASE_URL ?>/admin/index.php"
           class="nav-item <?= ($currentPage === 'index.php' && $currentDir === 'admin') ? 'active' : '' ?>">
            <i class="bi bi-grid-1x2"></i>
            <span>Dashboard</span>
        </a>

        <div class="nav-section-label mt-3">Data Master</div>
        <a href="<?= BASE_URL ?>/admin/kerusakan/index.php"
           class="nav-item <?= ($currentDir === 'kerusakan') ? 'active' : '' ?>">
            <i class="bi bi-exclamation-triangle"></i>
            <span>Data Kerusakan</span>
        </a>
        <a href="<?= BASE_URL ?>/admin/gejala/index.php"
           class="nav-item <?= ($currentDir === 'gejala') ? 'active' : '' ?>">
            <i class="bi bi-clipboard-pulse"></i>
            <span>Data Gejala</span>
        </a>
        <a href="<?= BASE_URL ?>/admin/penyebab/index.php"
           class="nav-item <?= ($currentDir === 'penyebab') ? 'active' : '' ?>">
            <i class="bi bi-search"></i>
            <span>Data Penyebab</span>
        </a>
        <a href="<?= BASE_URL ?>/admin/solusi/index.php"
           class="nav-item <?= ($currentDir === 'solusi') ? 'active' : '' ?>">
            <i class="bi bi-tools"></i>
            <span>Data Solusi</span>
        </a>

        <div class="nav-section-label mt-3">Diagnosis</div>
        <a href="<?= BASE_URL ?>/admin/aturan/index.php"
           class="nav-item <?= ($currentDir === 'aturan') ? 'active' : '' ?>">
            <i class="bi bi-diagram-3"></i>
            <span>Aturan Diagnosis</span>
        </a>
        <a href="<?= BASE_URL ?>/admin/riwayat/index.php"
           class="nav-item <?= ($currentDir === 'riwayat') ? 'active' : '' ?>">
            <i class="bi bi-clock-history"></i>
            <span>Riwayat Konsultasi</span>
        </a>
    </nav>

    <div class="sidebar-footer">
        <a href="<?= BASE_URL ?>/admin/logout.php" class="nav-item text-danger"
           onclick="return confirm('Yakin ingin logout?')">
            <i class="bi bi-box-arrow-left"></i>
            <span>Logout</span>
        </a>
    </div>
</aside>
