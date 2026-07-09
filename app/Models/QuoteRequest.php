<?php

namespace App\Models;

use App\Enums\QuoteStatus;
use App\Enums\ServiceType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;


/*
 * Modèle représentant une demande de devis.
 */

class QuoteRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'service_type',
        'description',
        'budget_estimate',
        'status',
        'admin_notes',
        'lost_reason',
    ];

    protected $casts = [
        'service_type' => ServiceType::class,
        'status' => QuoteStatus::class,
        'budget_estimate' => 'decimal:2',
    ];

    /**
     * Nom complet du prospect (pour affichage liste/détail).
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Scope de recherche libre sur nom, prénom, email, téléphone.
     */
    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (empty($term)) {
            return $query;
        }

        return $query->where(function (Builder $q) use ($term) {
            $q->where('first_name', 'like', "%{$term}%")
                ->orWhere('last_name', 'like', "%{$term}%")
                ->orWhere('email', 'like', "%{$term}%")
                ->orWhere('phone', 'like', "%{$term}%");
        });
    }

    /**
     * Scope de filtre par statut.
     */
    public function scopeByStatus(Builder $query, ?string $status): Builder
    {
        if (empty($status)) {
            return $query;
        }

        return $query->where('status', $status);
    }

    /**
     * Scope de filtre par type de service.
     */
    public function scopeByServiceType(Builder $query, ?string $serviceType): Builder
    {
        if (empty($serviceType)) {
            return $query;
        }

        return $query->where('service_type', $serviceType);
    }
}
