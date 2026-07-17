<?php

use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\RequestController;
use App\Http\Controllers\Front\ServiceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes publiques (vitrine)
|--------------------------------------------------------------------------
*/

Route::name('front.')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/services', [ServiceController::class, 'index'])->name('services');

    /* ---------- Demande de devis ---------- */
    Route::get('/devis', [RequestController::class, 'createQuote'])->name('quote.create');
    Route::post('/devis', [RequestController::class, 'storeQuote'])
        ->middleware('throttle:10,1')                              // RG-5 : anti-spam (US-1.8)
        ->name('quote.store');
    Route::get('/devis/confirmation', [RequestController::class, 'confirmationQuote'])
        ->name('quote.confirmation');

    /* ---------- Demande urgente (Sprint 2 — placeholder) ---------- */
    Route::get('/urgence', fn () => abort(404))->name('quick.create');
});

/*
|--------------------------------------------------------------------------
| Routes auth (Breeze)
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';



/**
 * Point soutenance : le throttle:10,1 est un middleware appliqué uniquement sur le POST — 10 requêtes/minute max par IP,
 * la 11e renvoie un 429. C'est la couche anti-abus (RG-5) qui remplace une éventuelle authentification sur un formulaire
 * public.
*Note : $request->validated('service_ids') —
*j'extrais les service_ids déjà validés plutôt que de refaire $request->input(). Propre et sûr.
 */
