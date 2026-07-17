<?php

namespace App\Enums;

/**
 * Statut d'un client : prospect ou client confirmé.
 */
enum ClientStatus: string
{
    case PROSPECT = 'prospect';
    case CLIENT = 'client';

    /**
     * Libellé d'affichage en français.
     */
    public function label(): string
    {
        return match ($this) {
            self::PROSPECT => 'Prospect',
            self::CLIENT   => 'Client',
        };
    }

    /**
     * Classes Tailwind pour le badge de statut.
     */
    public function color(): string
    {
        return match ($this) {
            self::PROSPECT => 'bg-gray-100 text-gray-700',
            self::CLIENT   => 'bg-green-100 text-green-700',
        };
    }
}
