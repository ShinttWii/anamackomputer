<?php
/**
 * Bridge script — digunakan .htaccess untuk forward request ke Laravel
 * Lokasi: C:\xampp\htdocs\anamackomputer\app.php
 *
 * URL Customer : http://localhost/anamackomputer/
 * URL Admin    : http://localhost/anamackomputer/admin/
 */

// Path ke direktori public Laravel
$laravelPublic = __DIR__ . '/amk-spk/public';

// Patch SCRIPT_NAME dan PATH_INFO agar Laravel mengenali subfolder
$_SERVER['SCRIPT_NAME']     = '/anamackomputer/app.php';
$_SERVER['SCRIPT_FILENAME'] = $laravelPublic . '/index.php';

// Ubah REQUEST_URI: hilangkan /anamackomputer prefix tapi pertahankan sisanya
// Contoh: /anamackomputer/admin/login → /admin/login
$requestUri = $_SERVER['REQUEST_URI'] ?? '/';
$base = '/anamackomputer';

if (str_starts_with($requestUri, $base)) {
    $pathAfterBase = substr($requestUri, strlen($base));
    if ($pathAfterBase === '' || $pathAfterBase[0] !== '/') {
        $pathAfterBase = '/' . $pathAfterBase;
    }
    $_SERVER['REQUEST_URI']  = $pathAfterBase;
    $_SERVER['PATH_INFO']    = strtok($pathAfterBase, '?');
}

// Ubah ke direktori public agar require path relatif benar
chdir($laravelPublic);

// Jalankan Laravel
require $laravelPublic . '/index.php';
