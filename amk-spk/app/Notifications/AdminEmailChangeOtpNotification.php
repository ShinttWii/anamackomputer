<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class AdminEmailChangeOtpNotification extends Notification
{
    use Queueable;

    public function __construct(
        public string $otp,
        public string $emailBaru
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Kode Verifikasi Perubahan Email — Panel Admin aMK')
            ->greeting('Halo, ' . $notifiable->nama_lengkap . '!')
            ->line('Ada permintaan untuk mengubah email akun admin menjadi:')
            ->line('**' . $this->emailBaru . '**')
            ->line('Masukkan kode verifikasi berikut untuk mengonfirmasi perubahan:')
            ->line('## ' . chunk_split($this->otp, 3, ' '))
            ->line('**Kode berlaku selama 2 menit.**')
            ->line('Jika Anda tidak meminta perubahan ini, abaikan email ini. Email Anda tidak akan berubah.')
            ->salutation('Hormat kami, Tim anaMac Komputer (aMK)');
    }
}
