<?php

namespace App\Models;

use App\Enums\RequestPriority;
use App\Enums\RequestStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Demande (devis ou urgence) — table fusionnée.
 *
 * ⚠ ALIAS OBLIGATOIRE dans tout fichier qui importe aussi Illuminate\Http\Request :
 *   use App\Models\Request as RequestModel;
 *
 * Variable nommée $requestModel ou $demande, jamais $request.
 */
class Request extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'client_id',
        'project_id',
        'reference',
        'description',
        'is_quick',
        'priority',
        'budget_estimate',
        'status',
        'closing_reason',
        'admin_notes',
        'is_archived',
    ];

    protected $casts = [
        'status'          => RequestStatus::class,
        'priority'        => RequestPriority::class,
        'is_quick'        => 'boolean',
        'is_archived'     => 'boolean',
        'budget_estimate' => 'decimal:2',
    ];

    /* ---------- Relations ---------- */

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class);
    }

    public function quotes(): HasMany
    {
        return $this->hasMany(Quote::class);
    }

    /**
     * N-N n°1 : services concernés par cette demande.
     * Pivot : request_service. Géré via sync() dans RequestService.
     */
    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class);
    }

    /* ---------- Scopes ---------- */

    /**
     * Recherche par nom, email ou téléphone du client.
     */
    public function scopeSearch(Builder $query, ?string $term): void
    {
        $query->when($term, fn (Builder $q) => $q->whereHas('client', fn (Builder $c) =>
            $c->where('last_name', 'like', "%{$term}%")
              ->orWhere('email', 'like', "%{$term}%")
              ->orWhere('phone', 'like', "%{$term}%")
        ));
    }

    /**
     * Filtre par statut (pipeline commercial).
     */
    public function scopeByStatus(Builder $query, ?string $status): void
    {
        $query->when($status, fn (Builder $q) => $q->where('status', $status));
    }

    /**
     * Filtre par service (via pivot N-N).
     */
    public function scopeByService(Builder $query, ?int $serviceId): void
    {
        $query->when($serviceId, fn (Builder $q) => $q->whereHas('services',
            fn (Builder $s) => $s->where('services.id', $serviceId)
        ));
    }

    /**
     * Demandes non archivées uniquement.
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('is_archived', false);
    }
}
