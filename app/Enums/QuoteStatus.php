<?php

namespace App\Enums;

enum QuoteStatus: string
{
    case Nouveau = 'nouveau';
    case EnCours = 'en_cours';
    case Traite = 'traite';
    case Perdu = 'perdu';

    /**
     * Libellé français pour affichage.
     */
    public function label(): string
    {
        return match ($this) {
            self::Nouveau => 'Nouveau',
            self::EnCours => 'En cours',
            self::Traite => 'Traité',
            self::Perdu => 'Perdu',
        };
    }

    /**
     * Couleur Tailwind pour le badge de statut (composant StatusBadge).
     */
    public function color(): string
    {
        return match ($this) {
            self::Nouveau => 'blue',
            self::EnCours => 'yellow',
            self::Traite => 'green',
            self::Perdu => 'red',
        };
    }
}
