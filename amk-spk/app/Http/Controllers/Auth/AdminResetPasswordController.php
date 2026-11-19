<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

class AdminResetPasswordController extends Controller
{
    /**
     * Tampilkan form reset password.
     */
    public function showResetForm(Request $request, string $token)
    {
        if (session('admin_id')) {
            return redirect()->route('admin.dashboard');
        }

        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email', ''),
        ]);
    }

    /**
     * Proses reset password.
     */
    public function reset(Request $request)
    {
        $request->validate([
            'token'                 => 'required',
            'email'                 => 'required|email',
            'password'              => 'required|min:8|confirmed',
            'password_confirmation' => 'required',
        ], [
            'password.required'              => 'Password baru wajib diisi.',
            'password.min'                   => 'Password minimal 8 karakter.',
            'password.confirmed'             => 'Konfirmasi password tidak cocok.',
            'password_confirmation.required' => 'Konfirmasi password wajib diisi.',
        ]);

        $status = Password::broker('admins')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (Admin $admin, string $password) {
                $admin->forceFill([
                    'password' => Hash::make($password),
                ])->save();

                event(new PasswordReset($admin));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('admin.login')
                ->with('success', 'Password berhasil direset. Silakan login dengan password baru Anda.');
        }

        // Token tidak valid atau kedaluwarsa
        if ($status === Password::INVALID_TOKEN) {
            return back()->with('error',
                'Tautan reset password tidak valid atau sudah kedaluwarsa. Silakan minta tautan baru.'
            )->withInput(['email' => $request->email]);
        }

        return back()->withErrors(['email' => __($status)])
            ->withInput(['email' => $request->email]);
    }
}
