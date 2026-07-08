<?php

namespace App\Http\Controllers\Front;

use App\Enums\ServiceType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{

    /**
     * Affchage de la page du site vitrine.
     */

public function index(): View{

// On récupère toutes les valeurs de l'Enum ServiceType pour les passer à la vue
return view('front.home', ['services' =>ServiceType::cases(),

    ]);
}


}

