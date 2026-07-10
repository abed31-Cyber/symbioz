<?php

namespace App\Enums;

/**
 * Types de service proposés par SYMBIOZ (BTP second œuvre).
 * Valeurs stockées en base en français (cf. MPD), identifiants de case en PascalCase.
 */
enum ServiceType: string
{
    case Plomberie   = 'plomberie';
    case Electricite = 'electricite';
    case Peinture    = 'peinture';
    case Platrerie   = 'platrerie';
    case Menuiserie  = 'menuiserie';

    /**
     * Libellé affiché à l'utilisateur (francophone).
     */
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

    /**
     * Icône (emoji) utilisée sur la vitrine.
     */
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

    /**
     * Description courte présentée sur la page d'accueil et la page services.
     */
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

    /*
     * Image illustrant le service sur la page d'accueil et la page services.
     */
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
}
/**
 * Pourquoi utilise-t-on des Enums ? on verrouille les valeurs possibles en base de données et dans le code.
 * J’ai encapsulé les statuts et les types de prestations dans des Enums PHP natifs.
 * Cela me permet de typer fortement mes données, d'éviter les erreurs de saisie dans le code,
 * et de centraliser les libellés en français pour l'affichage dans mes vues Blade sans dupliquer la logique.
 */


//Ce fichier liste les métiers du second œuvre gérés par Karim.
// Nous y ajoutons une méthode label() pour obtenir la version propre en français dans l'interface.



    /**exemple d'utilisation dans un contrôleur ou une vue Blade :
    *$serviceType = ServiceType::Plomberie;
   * echo $serviceType->label(); // Affiche "Plomberie"
    echo $serviceType->icon(); // Affiche "🔧   "
*
    *exemple d'utilisation dans une vue Blade :
    @foreach (App\Enums\ServiceType::cases() as $serviceType)
        *<div class="service-card">
            *<span class="service-icon">{{ $serviceType->icon() }}</span>
            *<h3 class="service-label">{{ $serviceType->label() }}</h3>
           * <p class="service-description">{{ $serviceType->description() }}</p>
       * </div>
          * <img src="{{ asset($service->image()) }}"
        * alt="Service {{ $service->label() }} — SYMBIOZ"
      *class="h-44 w-full object-cover">
      */
