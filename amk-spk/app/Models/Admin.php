<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Notifications\Notifiable;

class Admin extends Model implements CanResetPasswordContract
{
    use CanResetPassword, Notifiable;

    protected $table = 'admins';

    protected $fillable = [
        'username',
        'password',
        'nama_lengkap',
        'email',
        'email_pending',
        'email_verify_token',
        'email_verify_expires_at',
        'email_change_otp',
        'email_change_otp_expires_at',
    ];

    protected $hidden = ['password'];

    protected $casts = [
        'email_verify_expires_at'     => 'datetime',
        'email_change_otp_expires_at' => 'datetime',
    ];

    /**
     * Diperlukan oleh CanResetPassword — mengembalikan alamat email admin.
     */
    public function getEmailForPasswordReset(): string
    {
        return $this->email ?? '';
    }

    /**
     * Override notifikasi reset password dengan notifikasi custom aMK.
     */
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new \App\Notifications\AdminResetPasswordNotification($token));
    }

    /**
     * Route notifikasi untuk mail channel.
     */
    public function routeNotificationForMail(): string
    {
        return $this->email ?? '';
    }
}
