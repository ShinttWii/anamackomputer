<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Gejala extends Model
{
    protected $table = 'gejalas';

    protected $fillable = ['kode', 'nama', 'deskripsi'];

    public function aturans(): BelongsToMany
    {
        return $this->belongsToMany(Aturan::class, 'aturan_gejalas', 'gejala_id', 'aturan_id');
    }
}
