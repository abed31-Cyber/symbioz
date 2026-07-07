<?php

namespace App\Enums;

enum QuoteStatus: string
{
    case NEW = 'new';
    case IN_PROGRESS = 'in_progress';
    case TREATED = 'treated';
    case LOST = 'lost';

    /**
     * Récupérer le libellé en français pour l'affichage.
     */
    public function label(): string
    {
        return match($this) {
            self::NEW => 'Nouveau',
            self::IN_PROGRESS => 'En cours',
            self::TREATED => 'Traité',
            self::LOST => 'Perdu',
        };
    }

    /**
     * Récupérer la classe de couleur Tailwind pour les badges admin.
     */
    public function color(): string
    {
        return match($this) {
            self::NEW => 'bg-blue-100 text-blue-800',
            self::IN_PROGRESS => 'bg-warning-100 text-warning-800', // Adaptable selon ta charte Tailwind
            self::TREATED => 'bg-green-100 text-green-800',
            self::LOST => 'bg-red-100 text-red-800',
        };
    }
}
