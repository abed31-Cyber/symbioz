<?php

namespace App\Models;

use App\Enums\ClientStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Client (particulier ou professionnel).
 * first_name nullable : « Ste BuildCorp » n'a pas de prénom.
 * email nullable : le formulaire urgence ne l'exige pas.
 */
class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'city',
        'status',
    ];

    protected $casts = [
        'status' => ClientStatus::class,
    ];

    /* ---------- Relations ---------- */

    public function requests(): HasMany
    {
        return $this->hasMany(\App\Models\Request::class);
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    /* ---------- Accesseurs ---------- */

    /**
     * Nom complet d'affichage (« Jean Mercier » ou « Ste BuildCorp »).
     */
    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }
}
