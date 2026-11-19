<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Konsultasi extends Model
{
    protected $table = 'konsultasis';

    protected $fillable = ['model_macbook', 'hasil_kerusakan_id', 'status_diagnosis'];

    public function kerusakan(): BelongsTo
    {
        return $this->belongsTo(Kerusakan::class, 'hasil_kerusakan_id');
    }

    public function gejalas(): BelongsToMany
    {
        return $this->belongsToMany(Gejala::class, 'konsultasi_gejalas', 'konsultasi_id', 'gejala_id');
    }
}
