<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class AdminOtpNotification extends Notification
{
    use Queueable;

    public function __construct(public string $otp) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Kode Verifikasi Reset Password — Panel Admin aMK')
            ->greeting('Halo, ' . $notifiable->nama_lengkap . '!')
            ->line('Anda menerima email ini karena ada permintaan reset password untuk akun Admin.')
            ->line('Masukkan kode verifikasi berikut di halaman reset password:')
            ->line('## ' . chunk_split($this->otp, 3, ' '))
            ->line('**Kode ini berlaku selama 2 menit.**')
            ->line('Jangan bagikan kode ini kepada siapa pun.')
            ->line('Jika Anda tidak meminta reset password, abaikan email ini.')
            ->salutation('Hormat kami, Tim anaMac Komputer (aMK)');
    }
}
