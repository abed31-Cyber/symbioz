<?php

use App\Http\Controllers\Front\HomeController;
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

    // Devis (Sprint 1 — sera complété dans sprint-1/devis)
    Route::get('/devis', fn () => view('front.quote.create'))->name('quote.create');

    // Urgence (Sprint 2 — placeholder)
    Route::get('/urgence', fn () => abort(404))->name('quick.create');
});

/*
|--------------------------------------------------------------------------
| Routes auth (Breeze) — ne pas toucher
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';
