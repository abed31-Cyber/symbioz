<?php

namespace App\Enums;

/**
 * Statut d'un devis émis par l'admin.
 */
enum QuoteStatus: string
{
    case DRAFT = 'draft';
    case SENT = 'sent';
    case ACCEPTED = 'accepted';
    case REFUSED = 'refused';
    case PAID = 'paid';

    public function label(): string
    {
        return match ($this) {
            self::DRAFT    => 'Brouillon',
            self::SENT     => 'Envoyé',
            self::ACCEPTED => 'Accepté',
            self::REFUSED  => 'Refusé',
            self::PAID     => 'Payé',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::DRAFT    => 'bg-gray-100 text-gray-700',
            self::SENT     => 'bg-blue-100 text-blue-700',
            self::ACCEPTED => 'bg-green-100 text-green-700',
            self::REFUSED  => 'bg-red-100 text-red-700',
            self::PAID     => 'bg-emerald-100 text-emerald-700',
        };
    }
}
