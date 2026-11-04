<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Agenda extends Model
{
    protected $fillable = ['user_id', 'judul', 'deskripsi', 'tanggal', 'jam', 'selesai'];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'selesai' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}