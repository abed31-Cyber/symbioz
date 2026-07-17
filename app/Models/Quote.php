<?php

namespace App\Models;

use App\Enums\QuoteStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Devis émis par l'admin, rattaché à une demande (1-N).
 * Montant en DECIMAL(10,2) — jamais de FLOAT (ADR-010).
 */
class Quote extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_id',
        'amount',
        'status',
        'sent_at',
    ];

    protected $casts = [
        'status'  => QuoteStatus::class,
        'amount'  => 'decimal:2',
        'sent_at' => 'datetime',
    ];

    public function request(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Request::class);
    }
}
