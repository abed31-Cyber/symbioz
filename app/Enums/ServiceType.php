<?php

namespace App\Enums;

enum ServiceType: string
{
    case PAINTING = 'painting';
    case PLASTERING = 'plastering';
    case PLUMBING = 'plumbing';
    case ELECTRICITY = 'electricity';
    case CARPENTRY = 'carpentry'; // Menuiserie

    /**
     * Récupérer le libellé en français pour l'affichage.
     */
    public function label(): string
    {
        return match($this) {
            self::PAINTING => 'Peinture',
            self::PLASTERING => 'Plâtrerie / Isolation',
            self::PLUMBING => 'Plomberie',
            self::ELECTRICITY => 'Électricité',
            self::CARPENTRY => 'Menuiserie',
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
