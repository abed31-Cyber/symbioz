<?php

namespace App\Http\Controllers\Front;

use App\Enums\ServiceType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * HomeContrôleur gère la page d'accueil du site vitrine.
 */
class HomeController extends Controller
{

    /**
     * Affchage de la page du site vitrine.
     */

    public function index(): View
    {

        // On récupère toutes les valeurs de l'Enum ServiceType pour les passer à la vue
        return view('front.home', [
            'services' => ServiceType::cases(),

        ]);
    }

    /**Affiche la page détaillé des services */

    public function services(): View
    {
        return view('front.services', [
            'services' => ServiceType::cases(),
        ]);

    }

}

