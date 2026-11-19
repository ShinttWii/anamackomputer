<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Aturan extends Model
{
    protected $table = 'aturans';

    protected $fillable = ['kode', 'kerusakan_id'];

    public function kerusakan(): BelongsTo
    {
        return $this->belongsTo(Kerusakan::class, 'kerusakan_id');
    }

    public function gejalas(): BelongsToMany
    {
        return $this->belongsToMany(Gejala::class, 'aturan_gejalas', 'aturan_id', 'gejala_id');
    }
}
