<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Photo jointe à une demande (1-N).
 * Pas de HasFactory : les photos sont créées via PhotoService@attachMany.
 */
class Photo extends Model
{
    protected $fillable = [
        'request_id',
        'path',
    ];

    public function request(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Request::class);
    }
}
