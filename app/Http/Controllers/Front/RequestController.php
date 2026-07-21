<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuoteRequest;
use App\Http\Requests\StoreQuickRequest;
use App\Models\Service;
use App\Services\RequestService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Gère les demandes publiques (devis et urgence).
 * Le contrôleur reste fin : il délègue la logique métier à RequestService.
 */
class RequestController extends Controller
{
    public function __construct(
        private readonly RequestService $requestService,
    ) {
    }

    /* ==================== DEVIS ==================== */

    /**
     * Affiche le formulaire de demande de devis.
     */
    public function createQuote(): View
    {
        return view('front.quote.create', [
            'services' => Service::all(),
        ]);
    }

    /**
     * Enregistre une demande de devis.
     * La validation est faite en amont par StoreQuoteRequest.
     */
    public function storeQuote(StoreQuoteRequest $request): RedirectResponse
    {
        $requestModel = $this->requestService->createFromQuote(
            data: $request->validated(),
            serviceIds: $request->validated('service_ids'),
            photos: $request->file('photos', []),
        );

        // On passe la référence en session flash pour l'afficher sur la confirmation
        return redirect()
            ->route('front.quote.confirmation')
            ->with('reference', $requestModel->reference);
    }

    /**
     * Page de confirmation après soumission du devis.
     * Redirige vers le formulaire si aucune référence en session (accès direct).
     */
    public function confirmationQuote(Request $request): View|RedirectResponse
    {
        if (! $request->session()->has('reference')) {
            return redirect()->route('front.quote.create');
        }

        return view('front.confirmation', [
            'reference' => $request->session()->get('reference'),
            'isQuick'   => false,
        ]);
    }


    /* ==================== URGENCE ==================== */

    /**
     * Affiche le formulaire de demande urgente (maquette 03).
     */
    public function createQuick(): View
    {
        return view('front.quick.create', [
            'services' => Service::all(),
        ]);
    }

    /**
     * Enregistre une demande urgente.
     * La validation est faite en amont par StoreQuickRequest.
     * `is_quick` et `priority` sont fixés par le service (RG-10).
     */
    public function storeQuick(StoreQuickRequest $request): RedirectResponse
    {
        $requestModel = $this->requestService->createFromQuick(
            data: $request->validated(),
            serviceIds: $request->validated('service_ids'),
            photos: $request->file('photos', []),
        );

        return redirect()
            ->route('front.quick.confirmation')
            ->with('reference', $requestModel->reference);
    }

    /**
     * Page de confirmation après soumission urgente (« rappel sous 2h »).
     * Redirige vers le formulaire si aucune référence en session (accès direct).
     */
    public function confirmationQuick(Request $request): View|RedirectResponse
    {
        if (! $request->session()->has('reference')) {
            return redirect()->route('front.quick.create');
        }

        return view('front.confirmation', [
            'reference' => $request->session()->get('reference'),
            'isQuick'   => true,
        ]);
    }




}
