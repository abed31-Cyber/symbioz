<?php

namespace App\Enums;

/**
 * Statut d'une demande (pipeline commercial).
 * Valeurs FR conformes au MPD v7.1.
 */
enum RequestStatus: string
{
    case NOUVEAU = 'nouveau';
    case EN_COURS = 'en_cours';
    case TRAITE = 'traite';
    case PERDU = 'perdu';

    public function label(): string
    {
        return match ($this) {
            self::NOUVEAU => 'Nouveau',
            self::EN_COURS => 'En cours',
            self::TRAITE   => 'Traité',
            self::PERDU    => 'Perdu',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::NOUVEAU  => 'bg-blue-100 text-blue-700',
            self::EN_COURS => 'bg-amber-100 text-amber-700',
            self::TRAITE   => 'bg-green-100 text-green-700',
            self::PERDU    => 'bg-red-100 text-red-700',
        };
    }
}
