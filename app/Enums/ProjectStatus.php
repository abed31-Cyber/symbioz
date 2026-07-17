<?php

namespace App\Enums;

/**
 * Statut d'un chantier.
 */
enum ProjectStatus: string
{
    case OPEN = 'open';
    case IN_PROGRESS = 'in_progress';
    case CLOSED = 'closed';

    public function label(): string
    {
        return match ($this) {
            self::OPEN        => 'Ouvert',
            self::IN_PROGRESS => 'En cours',
            self::CLOSED      => 'Clôturé',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::OPEN        => 'bg-blue-100 text-blue-700',
            self::IN_PROGRESS => 'bg-amber-100 text-amber-700',
            self::CLOSED      => 'bg-gray-100 text-gray-700',
        };
    }
}
