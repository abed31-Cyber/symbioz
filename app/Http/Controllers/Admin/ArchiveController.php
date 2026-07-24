<?php

namespace App\Http\Controllers\Admin;

use App\Enums\RequestStatus;
use App\Http\Controllers\Controller;
use App\Models\Request as RequestModel;
use App\Services\RequestService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArchiveController extends Controller
{
    /**
     * Liste des demandes archivées (soft-deleted) + KPI (maquette 09, RG-4).
     */
    public function index(Request $request): View
    {
        $archives = RequestModel::onlyTrashed()          // uniquement les deleted_at NOT NULL
            ->with(['client', 'services'])               // anti N+1
            ->search($request->input('search'))
            ->latest('deleted_at')
            ->paginate(15)
            ->withQueryString();

        // KPI calculés sur l'ensemble des archives (pas seulement la page courante)
        $kpi = [
            'total'  => RequestModel::onlyTrashed()->count(),
            'traite' => RequestModel::onlyTrashed()->where('status', RequestStatus::TRAITE)->count(),
            'perdu'  => RequestModel::onlyTrashed()->where('status', RequestStatus::PERDU)->count(),
        ];

        return view('admin.archives.index', [
            'archives' => $archives,
            'kpi'      => $kpi,
        ]);
    }

    /**
     * Restaure une demande archivée (RG-4).
     */
    public function restore(int $id, RequestService $service): RedirectResponse
    {
        $requestModel = RequestModel::onlyTrashed()->findOrFail($id);
        $service->restore($requestModel);

        return redirect()
            ->route('admin.archives.index')
            ->with('success', 'Demande restaurée.');
    }

    /**
     * Supprime définitivement une demande (hard delete, irréversible — RG-4).
     */
    public function destroy(int $id, RequestService $service): RedirectResponse
    {
        $requestModel = RequestModel::onlyTrashed()->findOrFail($id);
        $service->forceDelete($requestModel);

        return redirect()
            ->route('admin.archives.index')
            ->with('success', 'Demande supprimée définitivement.');
    }
}
