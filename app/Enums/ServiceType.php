<?php

namespace App\Enums;

enum ServiceType: string
{
    case Plomberie = 'plomberie';
    case Electricite = 'electricite';
    case Peinture = 'peinture';
    case Platrerie = 'platrerie';
    case Menuiserie = 'menuiserie';

    /**
     * Libellé français pour affichage (vues, emails).
     */
    public function label(): string
    {
        return match($this) {
            self::Plomberie => 'Plomberie',
            self::Electricite => 'Électricité',
            self::Peinture => 'Peinture',
            self::Platrerie => 'Plâtrerie',
            self::Menuiserie => 'Menuiserie',
        };
    }
}
/**
 * Pourquoi utilise-t-on des Enums ? on verrouille les valeurs possibles en base de données et dans le code.
 * J’ai encapsulé les statuts et les types de prestations dans des Enums PHP natifs.
 * Cela me permet de typer fortement mes données, d'éviter les erreurs de saisie dans le code,
 * et de centraliser les libellés en français pour l'affichage dans mes vues Blade sans dupliquer la logique.
 */


//Ce fichier liste les métiers du second œuvre gérés par Karim.
// Nous y ajoutons une méthode label() pour obtenir la version propre en français dans l'interface.
