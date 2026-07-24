<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Request as RequestModel;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RequestController extends Controller
{
    /**
     * Liste paginée des demandes actives, avec recherche, filtres et tri (maquette 06).
     */
    public function index(Request $request): View
    {
        $requests = RequestModel::query()
            ->active()
            ->with(['client', 'services'])          // anti N+1 : client + services en 2 requêtes, pas 1 par ligne
            ->search($request->input('search'))
            ->byStatus($request->input('status'))
            ->byService($request->input('service'))
            ->latest()                               // tri par date de création décroissante
            ->paginate(15)
            ->withQueryString();                     // conserve search/status/service dans les liens de pagination

        return view('admin.requests.index', [
            'requests' => $requests,
            'services' => Service::orderBy('name')->get(),  // alimente le dropdown de filtre
        ]);
    }
    /**
     * Fiche détail d'une demande en lecture seule (maquette 07, RG-1).
     */
    public function show(RequestModel $request): View
    {
        // Route model binding : {request} → instance, ou 404 automatique.
        $request->load(['client', 'services', 'photos']);

        return view('admin.requests.show', ['requestModel' => $request]);
    }
}
