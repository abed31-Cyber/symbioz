<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClientController extends Controller
{
    /**
     * Liste paginée des clients avec recherche par nom ou ville (maquette 14).
     */
    public function index(Request $request): View
    {
        $clients = Client::query()
            ->withCount('requests')                  // ajoute requests_count sans charger les demandes (anti N+1)
            ->search($request->input('search'))
            ->orderBy('last_name')
            ->paginate(15)
            ->withQueryString();

        return view('admin.clients.index', ['clients' => $clients]);
    }
}
