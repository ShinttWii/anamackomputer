<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class AdminResetPasswordNotification extends Notification
{
    use Queueable;

    public function __construct(public string $token) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        // Gunakan config('app.url') secara eksplisit agar URL selalu benar
        // meski dijalankan dari context yang berbeda (CLI, bridge, dll)
        $appUrl   = rtrim(config('app.url'), '/');
        $path     = route('admin.password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false);
        $resetUrl = $appUrl . $path;

        return (new MailMessage)
            ->subject('Reset Password — Panel Admin aMK')
            ->greeting('Halo, ' . $notifiable->nama_lengkap . '!')
            ->line('Anda menerima email ini karena kami menerima permintaan reset password untuk akun Admin Anda.')
            ->action('Reset Password Sekarang', $resetUrl)
            ->line('Tautan reset password ini akan kedaluwarsa dalam **60 menit**.')
            ->line('Jika Anda tidak meminta reset password, abaikan email ini.')
            ->salutation('Hormat kami, Tim anaMac Komputer (aMK)');
    }
}
