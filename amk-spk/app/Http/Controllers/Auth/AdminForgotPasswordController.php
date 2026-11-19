<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AdminOtpNotification;

class AdminForgotPasswordController extends Controller
{
    /**
     * Tampilkan form "Lupa Password" (input email).
     */
    public function showLinkRequestForm()
    {
        if (session('admin_id')) {
            return redirect()->route('admin.dashboard');
        }
        return view('auth.forgot-password');
    }

    /**
     * Kirim OTP 6 digit ke email admin.
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
        ]);

        $admin = Admin::where('email', $request->email)->first();

        // Tampilkan pesan error jika email tidak terdaftar
        if (!$admin) {
            return back()->withInput()->with('error',
                'Email tersebut tidak terdaftar di sistem. Silakan periksa kembali.'
            );
        }

        // Generate OTP 6 digit
        $otp     = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $expires = now()->addMinutes(2); // berlaku 2 menit

        // Simpan OTP ke database (hapus yang lama dulu)
        DB::table('admin_password_resets')->where('email', $request->email)->delete();
        DB::table('admin_password_resets')->insert([
            'email'      => $request->email,
            'token'      => '',           // tidak dipakai, tapi kolom required
            'otp_code'   => $otp,
            'expires_at' => $expires,
            'created_at' => now(),
        ]);

        // Kirim OTP via email
        try {
            Notification::send($admin, new AdminOtpNotification($otp));
        } catch (\Exception $e) {
            // Hapus OTP jika email gagal dikirim
            DB::table('admin_password_resets')->where('email', $request->email)->delete();
            return back()->with('error',
                'Gagal mengirim email: ' . $e->getMessage() .
                '. Pastikan konfigurasi SMTP di .env sudah benar.'
            )->withInput();
        }

        // Simpan email ke session untuk halaman verifikasi OTP
        session(['otp_email' => $request->email]);

        return redirect()->route('admin.password.otp.form')
            ->with('success', 'Kode verifikasi 6 digit telah dikirim ke ' . $request->email . '. Kode berlaku selama 2 menit.');
    }

    /**
     * Tampilkan form input OTP.
     */
    public function showOtpForm()
    {
        if (!session('otp_email')) {
            return redirect()->route('admin.password.request')
                ->with('error', 'Silakan masukkan email Anda terlebih dahulu.');
        }
        return view('auth.verify-otp');
    }

    /**
     * Verifikasi OTP yang dimasukkan admin.
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
        ], [
            'otp.required' => 'Kode verifikasi wajib diisi.',
            'otp.size'     => 'Kode verifikasi harus 6 digit.',
        ]);

        $email = session('otp_email');
        if (!$email) {
            return redirect()->route('admin.password.request')
                ->with('error', 'Sesi habis. Silakan ulangi dari awal.');
        }

        $record = DB::table('admin_password_resets')
            ->where('email', $email)
            ->first();

        if (!$record || !$record->otp_code) {
            return back()->with('error', 'Kode verifikasi tidak ditemukan. Silakan minta kode baru.');
        }

        // Cek kedaluwarsa
        if (now()->isAfter($record->expires_at)) {
            DB::table('admin_password_resets')->where('email', $email)->delete();
            session()->forget('otp_email');
            return redirect()->route('admin.password.request')
                ->with('error', 'Kode verifikasi sudah kedaluwarsa. Silakan minta kode baru.');
        }

        // Cek kode OTP
        if ($request->otp !== $record->otp_code) {
            return back()->with('error', 'Kode verifikasi salah. Periksa kembali email Anda.');
        }

        // OTP benar — buat token reset dan pindah ke form password baru
        $resetToken = \Illuminate\Support\Str::random(64);
        DB::table('admin_password_resets')
            ->where('email', $email)
            ->update([
                'token'    => hash('sha256', $resetToken),
                'otp_code' => null, // hapus OTP setelah terpakai
            ]);

        session()->forget('otp_email');
        session(['reset_email' => $email, 'reset_token' => $resetToken]);

        return redirect()->route('admin.password.new.form')
            ->with('success', 'Kode benar! Silakan buat password baru.');
    }

    /**
     * Tampilkan form password baru.
     */
    public function showNewPasswordForm()
    {
        if (!session('reset_token') || !session('reset_email')) {
            return redirect()->route('admin.password.request')
                ->with('error', 'Sesi tidak valid. Silakan ulangi dari awal.');
        }
        return view('auth.new-password');
    }

    /**
     * Simpan password baru.
     */
    public function saveNewPassword(Request $request)
    {
        $request->validate([
            'password'              => 'required|min:8|confirmed',
            'password_confirmation' => 'required',
        ], [
            'password.required'              => 'Password baru wajib diisi.',
            'password.min'                   => 'Password minimal 8 karakter.',
            'password.confirmed'             => 'Konfirmasi password tidak cocok.',
            'password_confirmation.required' => 'Konfirmasi password wajib diisi.',
        ]);

        $email = session('reset_email');
        $token = session('reset_token');

        if (!$email || !$token) {
            return redirect()->route('admin.password.request')
                ->with('error', 'Sesi tidak valid. Silakan ulangi dari awal.');
        }

        // Verifikasi token di database
        $record = DB::table('admin_password_resets')->where('email', $email)->first();
        if (!$record || $record->token !== hash('sha256', $token)) {
            session()->forget(['reset_email', 'reset_token']);
            return redirect()->route('admin.password.request')
                ->with('error', 'Token tidak valid. Silakan ulangi dari awal.');
        }

        // Update password admin
        $admin = Admin::where('email', $email)->first();
        if (!$admin) {
            return redirect()->route('admin.password.request')
                ->with('error', 'Akun tidak ditemukan.');
        }

        $admin->update([
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
        ]);

        // Bersihkan token dan session
        DB::table('admin_password_resets')->where('email', $email)->delete();
        session()->forget(['reset_email', 'reset_token']);

        return redirect()->route('admin.login')
            ->with('success', 'Password berhasil diperbarui. Silakan login dengan password baru Anda.');
    }

    /**
     * Kirim ulang OTP.
     */
    public function resendOtp()
    {
        $email = session('otp_email');
        if (!$email) {
            return redirect()->route('admin.password.request')
                ->with('error', 'Sesi habis. Silakan masukkan email kembali.');
        }

        // Cek throttle — boleh kirim ulang jika kode lama sudah kedaluwarsa (expires_at sudah lewat)
        $existing = DB::table('admin_password_resets')->where('email', $email)->first();
        if ($existing && $existing->expires_at && now()->isBefore($existing->expires_at)) {
            $sisaDetik = (int) now()->diffInSeconds($existing->expires_at);
            return redirect()->route('admin.password.otp.form')
                ->with('error', "Kode sebelumnya masih berlaku. Tunggu {$sisaDetik} detik lagi untuk meminta kode baru.");
        }

        $admin = Admin::where('email', $email)->first();
        if (!$admin) {
            return redirect()->route('admin.password.request');
        }

        $otp     = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $expires = now()->addMinutes(2);

        DB::table('admin_password_resets')->where('email', $email)->delete();
        DB::table('admin_password_resets')->insert([
            'email'      => $email,
            'token'      => '',
            'otp_code'   => $otp,
            'expires_at' => $expires,
            'created_at' => now(),
        ]);

        try {
            \Illuminate\Support\Facades\Notification::send($admin, new AdminOtpNotification($otp));
        } catch (\Exception $e) {
            return redirect()->route('admin.password.otp.form')
                ->with('error', 'Gagal mengirim ulang: ' . $e->getMessage());
        }

        return redirect()->route('admin.password.otp.form')
            ->with('success', 'Kode baru telah dikirim ke ' . $email . '.');
    }
}
