<?php

namespace App\Enums;

/**
 * Rôle d'un utilisateur authentifié.
 * Admin = Pascal (gérant). Technicien = compagnon assignable aux chantiers.
 */
enum UserRole: string
{
    case ADMIN = 'admin';
    case TECHNICIEN = 'technicien';

    public function label(): string
    {
        return match ($this) {
            self::ADMIN      => 'Administrateur',
            self::TECHNICIEN => 'Technicien',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::ADMIN      => 'bg-purple-100 text-purple-700',
            self::TECHNICIEN => 'bg-teal-100 text-teal-700',
        };
    }
}
