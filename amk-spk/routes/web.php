<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\AdminForgotPasswordController;
use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Customer\BerandaController;
use App\Http\Controllers\Customer\PanduanController;
use App\Http\Controllers\Customer\InformasiController;
use App\Http\Controllers\Customer\KonsultasiController;
use App\Http\Controllers\Customer\HasilController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KerusakanController;
use App\Http\Controllers\Admin\GejalaController;
use App\Http\Controllers\Admin\PenyebabController;
use App\Http\Controllers\Admin\SolusiController;
use App\Http\Controllers\Admin\AturanController;
use App\Http\Controllers\Admin\RiwayatController;
use App\Http\Controllers\Admin\KontenController;

// ============================================================
// CUSTOMER ROUTES (publik, tanpa login)
// ============================================================
Route::get('/', [BerandaController::class, 'index'])->name('beranda');
Route::get('/panduan', [PanduanController::class, 'index'])->name('panduan');
Route::get('/informasi', [InformasiController::class, 'index'])->name('informasi');
Route::get('/konsultasi', [KonsultasiController::class, 'index'])->name('konsultasi');
Route::post('/konsultasi/proses', [KonsultasiController::class, 'proses'])->name('konsultasi.proses');
Route::get('/hasil', [HasilController::class, 'index'])->name('hasil');

// ============================================================
// ADMIN AUTH ROUTES
// ============================================================
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Lupa Password — sistem OTP
Route::get('/admin/forgot-password',  [AdminForgotPasswordController::class, 'showLinkRequestForm'])->name('admin.password.request');
Route::post('/admin/forgot-password', [AdminForgotPasswordController::class, 'sendOtp'])->name('admin.password.email');

// Verifikasi OTP
Route::get('/admin/verify-otp',  [AdminForgotPasswordController::class, 'showOtpForm'])->name('admin.password.otp.form');
Route::post('/admin/verify-otp', [AdminForgotPasswordController::class, 'verifyOtp'])->name('admin.password.otp.verify');
Route::get('/admin/resend-otp',  [AdminForgotPasswordController::class, 'resendOtp'])->name('admin.password.otp.resend');

// Form password baru (setelah OTP benar)
Route::get('/admin/new-password',  [AdminForgotPasswordController::class, 'showNewPasswordForm'])->name('admin.password.new.form');
Route::post('/admin/new-password', [AdminForgotPasswordController::class, 'saveNewPassword'])->name('admin.password.new.save');

// ============================================================
// ADMIN PROTECTED ROUTES
// ============================================================
Route::prefix('admin')->name('admin.')->middleware('admin.auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('kerusakan', KerusakanController::class)->except(['show']);
    Route::resource('gejala', GejalaController::class)->except(['show']);
    Route::resource('penyebab', PenyebabController::class)->except(['show']);
    Route::resource('solusi', SolusiController::class)->except(['show']);
    Route::resource('aturan', AturanController::class)->except(['show']);

    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');
    Route::get('/riwayat/{id}', [RiwayatController::class, 'show'])->name('riwayat.show');

    // Kelola Konten
    Route::get('/konten', [KontenController::class, 'index'])->name('konten.index');
    Route::post('/konten/update', [KontenController::class, 'update'])->name('konten.update');
    Route::delete('/konten/hapus-gambar/{kunci}', [KontenController::class, 'hapusGambar'])->name('konten.hapus-gambar');

    // Profil Admin
    Route::get('/account', [AccountController::class, 'index'])->name('account.index');
    Route::post('/account/request-otp', [AccountController::class, 'requestOtp'])->name('account.request-otp');
    Route::post('/account/verify-otp', [AccountController::class, 'verifyOtp'])->name('account.verify-otp');
    Route::post('/account/resend-otp', [AccountController::class, 'resendOtp'])->name('account.resend-otp');
    Route::post('/account/cancel', [AccountController::class, 'cancelChange'])->name('account.cancel');
});
