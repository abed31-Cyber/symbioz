<?php

namespace App\Enums;

/**
 * Priorité d'une demande, assignée par l'admin (RG-11).
 * Pré-remplie selon is_quick, mais modifiable.
 */
enum RequestPriority: string
{
    case NORMAL = 'normal';
    case URGENT = 'urgent';

    public function label(): string
    {
        return match ($this) {
            self::NORMAL => 'Normale',
            self::URGENT => 'Urgente',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::NORMAL => 'bg-gray-100 text-gray-700',
            self::URGENT => 'bg-red-100 text-red-700',
        };
    }
}
