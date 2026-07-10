<?php

namespace App\Enums;

/**
 * Types de service proposés par SYMBIOZ (BTP second œuvre).
 * Source de vérité unique des métadonnées métier (label, visuel, prestations).
 * Valeurs stockées en base en français (cf. MPD), cases en PascalCase.
 */
enum ServiceType: string
{
    case Plomberie   = 'plomberie';
    case Electricite = 'electricite';
    case Peinture    = 'peinture';
    case Platrerie   = 'platrerie';
    case Menuiserie  = 'menuiserie';

    /** Libellé affiché à l'utilisateur (francophone). */
    public function label(): string
    {
        return match ($this) {
            self::Plomberie   => 'Plomberie',
            self::Electricite => 'Électricité',
            self::Peinture    => 'Peinture',
            self::Platrerie   => 'Plâtrerie',
            self::Menuiserie  => 'Menuiserie',
        };
    }

    /** Icône (emoji) utilisée sur la vitrine. */
    public function icon(): string
    {
        return match ($this) {
            self::Plomberie   => '🔧',
            self::Electricite => '⚡',
            self::Peinture    => '🎨',
            self::Platrerie   => '🧱',
            self::Menuiserie  => '🪵',
        };
    }

    /** Chemin de l'image (dans public/), utilisée sur les cartes. */
    public function image(): string
    {
        return match ($this) {
            self::Plomberie   => 'images/services/plomberie.jpg',
            self::Electricite => 'images/services/electricite.jpg',
            self::Peinture    => 'images/services/peinture.jpg',
            self::Platrerie   => 'images/services/platrerie.jpg',
            self::Menuiserie  => 'images/services/menuiserie.jpg',
        };
    }

    /** Description courte (accueil + carte service). */
    public function description(): string
    {
        return match ($this) {
            self::Plomberie   => 'Fuites, robinetterie, installation sanitaire et dépannage.',
            self::Electricite => 'Mise aux normes, tableaux, prises et éclairage.',
            self::Peinture    => 'Murs, plafonds, boiseries : finitions intérieures soignées.',
            self::Platrerie   => 'Cloisons, doublages, enduits et faux plafonds.',
            self::Menuiserie  => 'Pose de portes, fenêtres, parquets et aménagements sur mesure.',
        };
    }

    /** Accroche courte « le problème » (page services). */
    public function tagline(): string
    {
        return match ($this) {
            self::Plomberie   => "L'eau, c'est sérieux.",
            self::Electricite => 'Mise aux normes, tranquillité.',
            self::Peinture    => 'Rafraîchir, transformer, protéger.',
            self::Platrerie   => 'Cloisons, faux plafonds, isolation.',
            self::Menuiserie  => 'Pose sur-mesure, agencement.',
        };
    }

    /**
     * Liste des prestations détaillées (page services).
     *
     * @return list<string>
     */
    public function prestations(): array
    {
        return match ($this) {
            self::Plomberie => [
                'Installation et remplacement : robinetterie, tuyauterie, chauffe-eau',
                'WC, douches, évacuations, raccordements',
                'Dépannage fuite 7j/7 sur Toulouse et petite couronne',
            ],
            self::Electricite => [
                'Tableaux, prises, éclairage, VMC, domotique',
                'Mise en conformité NF C 15-100, diagnostics pré-vente',
                'Dépannage panne électrique, devis détaillé avant intervention',
            ],
            self::Peinture => [
                'Peinture intérieure et extérieure, papier peint',
                'Enduits décoratifs, traitement anti-humidité',
                'Finitions soignées, protection des sols et meubles incluse',
            ],
            self::Platrerie => [
                'Création et démolition de cloisons (placo, carreaux de plâtre)',
                'Faux plafonds, isolation thermique et acoustique',
                'Reprise de fissures et préparation avant peinture',
            ],
            self::Menuiserie => [
                'Pose de parquet, escaliers, portes intérieures',
                'Fenêtres bois / PVC / alu, cuisines équipées, dressings',
                'Travail soigné, finitions précises',
            ],
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
