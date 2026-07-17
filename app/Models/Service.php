<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Référentiel des 6 services (table figée, sans timestamps).
 */
class Service extends Model
{
    /** @var bool Pas de created_at / updated_at (données de référence). */
    public $timestamps = false;

    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * N-N n°1 : un service concerne 0 à N demandes.
     * Pivot : request_service.
     */
    public function requests(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Request::class);
    }
}
