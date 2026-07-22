<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

/**
 * Tableau de bord administrateur.
 * Les KPI seront ajoutés au Sprint 3 (US-3.2).
 */
class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard');
    }
}
