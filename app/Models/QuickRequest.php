<?php

namespace App\Models;

use App\Enums\QuoteStatus;
use App\Enums\ServiceType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class QuickRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'contact_name',
        'contact_phone',
        'contact_email',
        'address',
        'service_type',
        'description',
        'status',
        'admin_notes',
        'lost_reason',
    ];

    protected $casts = [
        'service_type' => ServiceType::class,
        'status' => QuoteStatus::class,
    ];

    /**
     * Scope de recherche libre sur nom, téléphone, email.
     */
    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (empty($term)) {
            return $query;
        }

        return $query->where(function (Builder $q) use ($term) {
            $q->where('contact_name', 'like', "%{$term}%")
                ->orWhere('contact_phone', 'like', "%{$term}%")
                ->orWhere('contact_email', 'like', "%{$term}%");
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
