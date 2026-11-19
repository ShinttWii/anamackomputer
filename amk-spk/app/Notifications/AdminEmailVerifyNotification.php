<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class AdminEmailVerifyNotification extends Notification
{
    use Queueable;

    public function __construct(
        public string $token,
        public string $newEmail
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        // Gunakan config('app.url') secara eksplisit agar URL selalu benar
        $appUrl    = rtrim(config('app.url'), '/');
        $path      = route('admin.account.verify-email', ['token' => $this->token], false);
        $verifyUrl = $appUrl . $path;

        return (new MailMessage)
            ->subject('Verifikasi Email Baru — Panel Admin aMK')
            ->greeting('Halo, ' . $notifiable->nama_lengkap . '!')
            ->line('Anda meminta perubahan email akun admin menjadi: **' . $this->newEmail . '**')
            ->action('Verifikasi Email Baru', $verifyUrl)
            ->line('Tautan verifikasi ini akan kedaluwarsa dalam **60 menit**.')
            ->line('Jika Anda tidak meminta perubahan email ini, abaikan email ini dan email lama Anda tetap aktif.')
            ->salutation('Hormat kami, Tim anaMac Komputer (aMK)');
    }
}
