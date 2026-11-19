<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Notifications\AdminEmailChangeOtpNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{
    /**
     * Tampilkan halaman Profil Admin.
     */
    public function index()
    {
        $admin = Admin::findOrFail(session('admin_id'));

        // Hitung sisa detik OTP — untuk countdown di view
        $sisaDetikOtp = 0;
        if ($admin->email_change_otp_expires_at && now()->isBefore($admin->email_change_otp_expires_at)) {
            $sisaDetikOtp = (int) now()->diffInSeconds($admin->email_change_otp_expires_at);
        }

        return view('admin.account.index', compact('admin', 'sisaDetikOtp'));
    }

    /**
     * Langkah 1: Validasi email baru, konfirmasi email, dan password.
     * Kemudian kirim OTP ke EMAIL LAMA.
     */
    public function requestOtp(Request $request)
    {
        $admin = Admin::findOrFail(session('admin_id'));

        $request->validate([
            'email_baru'        => [
                'required', 'email', 'max:150',
                Rule::unique('admins', 'email')->ignore($admin->id),
            ],
            'email_konfirmasi'  => 'required|email|same:email_baru',
            'password_sekarang' => 'required|string',
        ], [
            'email_baru.required'       => 'Email baru wajib diisi.',
            'email_baru.email'          => 'Format email baru tidak valid.',
            'email_baru.unique'         => 'Email tersebut sudah digunakan akun lain.',
            'email_konfirmasi.required' => 'Konfirmasi email wajib diisi.',
            'email_konfirmasi.same'     => 'Konfirmasi email tidak cocok.',
            'password_sekarang.required'=> 'Password saat ini wajib diisi.',
        ]);

        if ($request->email_baru === $admin->email) {
            return back()->with('error', 'Email baru tidak boleh sama dengan email saat ini.')
                ->withInput($request->except('password_sekarang'));
        }

        if (!Hash::check($request->password_sekarang, $admin->password)) {
            return back()->withErrors(['password_sekarang' => 'Password saat ini tidak benar.'])
                ->withInput($request->except('password_sekarang'));
        }

        if (!$admin->email) {
            return back()->with('error', 'Email saat ini belum diatur. Tidak dapat mengirim kode verifikasi.')
                ->withInput($request->except('password_sekarang'));
        }

        // Generate OTP 6 digit
        $otp     = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $expires = now()->addMinutes(2);

        $admin->update([
            'email_pending'              => $request->email_baru,
            'email_change_otp'           => $otp,
            'email_change_otp_expires_at'=> $expires,
        ]);

        try {
            $admin->notify(new AdminEmailChangeOtpNotification($otp, $request->email_baru));
        } catch (\Exception $e) {
            $admin->update([
                'email_pending'              => null,
                'email_change_otp'           => null,
                'email_change_otp_expires_at'=> null,
            ]);
            return back()->with('error', 'Gagal mengirim kode: ' . $e->getMessage())
                ->withInput($request->except('password_sekarang'));
        }

        return back()->with('otp_sent', true)
            ->with('success', 'Kode verifikasi telah dikirim ke email lama Anda (' . $admin->email . '). Berlaku 2 menit.');
    }

    /**
     * Langkah 2: Verifikasi OTP dan terapkan email baru.
     */
    public function verifyOtp(Request $request)
    {
        $admin = Admin::findOrFail(session('admin_id'));

        $request->validate([
            'otp_kode' => 'required|string|size:6',
        ], [
            'otp_kode.required' => 'Kode verifikasi wajib diisi.',
            'otp_kode.size'     => 'Kode verifikasi harus 6 digit.',
        ]);

        if (!$admin->email_pending || !$admin->email_change_otp) {
            return back()->with('error', 'Tidak ada permintaan perubahan email yang aktif. Silakan ulangi dari awal.');
        }

        // Cek kedaluwarsa
        if (now()->isAfter($admin->email_change_otp_expires_at)) {
            $admin->update([
                'email_pending'              => null,
                'email_change_otp'           => null,
                'email_change_otp_expires_at'=> null,
            ]);
            return back()->with('error', 'Kode verifikasi sudah kedaluwarsa. Silakan ulangi dari awal.');
        }

        // Cek kode OTP
        if ($request->otp_kode !== $admin->email_change_otp) {
            return back()->with('error', 'Kode verifikasi salah. Periksa kembali email Anda.')
                ->with('otp_sent', true);
        }

        // OTP benar — terapkan email baru
        $emailBaru = $admin->email_pending;
        $admin->update([
            'email'                      => $emailBaru,
            'email_pending'              => null,
            'email_change_otp'           => null,
            'email_change_otp_expires_at'=> null,
            // Bersihkan token lama jika ada
            'email_verify_token'         => null,
            'email_verify_expires_at'    => null,
        ]);

        return back()->with('email_changed', true)
            ->with('success', 'Email berhasil diubah menjadi ' . $emailBaru . '.');
    }

    /**
     * Kirim ulang OTP ke email lama.
     */
    public function resendOtp(Request $request)
    {
        $admin = Admin::findOrFail(session('admin_id'));

        if (!$admin->email_pending) {
            return back()->with('error', 'Tidak ada permintaan perubahan email yang aktif.');
        }

        // Throttle — boleh kirim ulang setelah kode lama kedaluwarsa (2 menit)
        if ($admin->email_change_otp_expires_at && now()->isBefore($admin->email_change_otp_expires_at)) {
            $sisaDetik = (int) now()->diffInSeconds($admin->email_change_otp_expires_at);
            return back()->with('error', "Kode sebelumnya masih berlaku. Tunggu {$sisaDetik} detik lagi.")
                ->with('otp_sent', true);
        }

        $otp     = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $expires = now()->addMinutes(2);

        $admin->update([
            'email_change_otp'           => $otp,
            'email_change_otp_expires_at'=> $expires,
        ]);

        try {
            $admin->notify(new AdminEmailChangeOtpNotification($otp, $admin->email_pending));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengirim ulang kode: ' . $e->getMessage())
                ->with('otp_sent', true);
        }

        return back()->with('otp_sent', true)
            ->with('success', 'Kode baru telah dikirim ke ' . $admin->email . '.');
    }

    /**
     * Batalkan permintaan perubahan email.
     */
    public function cancelChange()
    {
        $admin = Admin::findOrFail(session('admin_id'));
        $admin->update([
            'email_pending'              => null,
            'email_change_otp'           => null,
            'email_change_otp_expires_at'=> null,
        ]);
        return back()->with('success', 'Permintaan perubahan email dibatalkan.');
    }
}
