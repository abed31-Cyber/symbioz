<?php

namespace App\Http\Controllers\Front;

use App\Enums\ServiceType;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuoteRequestRequest;
use App\Services\QuoteRequestService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class QuoteRequestController extends Controller
{
    /**
     * Affiche le formulaire de demande de devis.
     */
    public function create(): View
    {
        return view('front.quote-request.create', [
            'services' => ServiceType::cases(),
        ]);
    }

    /**
     * Enregistre une nouvelle demande de devis.
     */
    public function store(StoreQuoteRequestRequest $request, QuoteRequestService $service): RedirectResponse
    {
        // On ne persiste que les champs métier : 'consent' (RGPD) est validé mais non stocké.
        //
        $service->create($request->safe()->except('consent'));

        return redirect()->route('front.quote-request.confirmation');
    }

    /**
     * Affiche la page de confirmation après soumission.
     */
    public function confirmation(): View
    {
        return view('front.quote-request.confirmation');
    }
}




/**
 * si on avais utiliser $request-validated() on récuperes uniquement les champs qui ont passé avec succées les Rules de validation
 *  mais ca inclut aussi la case consent (RGPD)
 * donc on utilise la methode safe de FormeRequest $request-safe() Transforme les données validées en un objet manipulable,
 *  permettant d'utiliser except() le case 'consent' elle permet d'exclure proprement la case RGPD avant d'enregistrer en base.
 */
