<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Solusi extends Model
{
    protected $table = 'solusis';

    protected $fillable = ['kode', 'kerusakan_id', 'deskripsi'];

    public function kerusakan(): BelongsTo
    {
        return $this->belongsTo(Kerusakan::class, 'kerusakan_id');
    }
}
