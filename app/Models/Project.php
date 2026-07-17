<?php

namespace App\Models;

use App\Enums\ProjectStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Chantier rattaché à un client, avec équipe de compagnons (N-N n°2).
 */
class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'label',
        'status',
    ];

    protected $casts = [
        'status' => ProjectStatus::class,
    ];

    /* ---------- Relations ---------- */

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Demandes rattachées à ce chantier.
     * FQCN obligatoire pour éviter la collision avec Illuminate\Http\Request.
     */
    public function requests(): HasMany
    {
        return $this->hasMany(\App\Models\Request::class);
    }

    /**
     * N-N n°2 : compagnons assignés à ce chantier.
     * Pivot : project_user. Géré via sync() dans ProjectService.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
