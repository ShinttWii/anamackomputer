<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $table = 'site_settings';

    protected $fillable = ['kunci', 'nilai', 'tipe', 'label'];

    /**
     * Ambil nilai setting berdasarkan kunci.
     */
    public static function get(string $kunci, mixed $default = null): mixed
    {
        $setting = static::where('kunci', $kunci)->first();
        return $setting?->nilai ?? $default;
    }

    /**
     * Simpan nilai setting.
     */
    public static function set(string $kunci, mixed $nilai): void
    {
        static::where('kunci', $kunci)->update(['nilai' => $nilai]);
    }
}
