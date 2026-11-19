<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kerusakan extends Model
{
    protected $table = 'kerusakans';

    protected $fillable = ['kode', 'nama', 'deskripsi'];

    public function penyebabs(): HasMany
    {
        return $this->hasMany(Penyebab::class, 'kerusakan_id');
    }

    public function solusIs(): HasMany
    {
        return $this->hasMany(Solusi::class, 'kerusakan_id');
    }

    public function aturans(): HasMany
    {
        return $this->hasMany(Aturan::class, 'kerusakan_id');
    }
}
