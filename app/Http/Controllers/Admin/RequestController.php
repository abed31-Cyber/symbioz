<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Request as RequestModel;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Requests\UpdateRequestRequest;
use App\Services\RequestService;
use Illuminate\Http\RedirectResponse;

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
    public function show(RequestModel $requestModel): View
    {
        // Route model binding : {request} → instance, ou 404 automatique.
        $requestModel->load(['client', 'services', 'photos']);

        return view('admin.requests.show', ['requestModel' => $requestModel]);
    }
    /**
     * Met à jour le statut, la priorité et les notes d'une demande (RG-2, RG-11).
     */
    public function update(UpdateRequestRequest $request, RequestModel $requestModel, RequestService $service): RedirectResponse
    {
        $service->updateStatus($requestModel, $request->validated());

        return redirect()
            ->route('admin.requests.show', $requestModel)
            ->with('success', 'Demande mise à jour.');
    }
    /**
     * Archive une demande puis renvoie vers la liste (RG-3).
     */
    public function archive(RequestModel $requestModel, RequestService $service): RedirectResponse
    {
        $service->archive($requestModel);

        return redirect()
            ->route('admin.requests.index')
            ->with('success', 'Demande archivée.');
    }
}
