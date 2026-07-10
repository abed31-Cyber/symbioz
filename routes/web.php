<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\QuoteRequestController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


/**
 *   Routes public du site vitrine
 */
Route::controller(HomeController::class)->group(function(){

Route::get('/', 'index')->name('front.home');
Route::get('/services', 'services')->name('front.services');
});

// Demande de devis (US-1.5)
Route::controller(QuoteRequestController::class)->group(function () {
    Route::get('/devis', 'create')->name('front.quote-request.create');
    Route::post('/devis', 'store')->middleware('throttle:10,1')->name('front.quote-request.store'); // RG-5
    Route::get('/devis/confirmation', 'confirmation')->name('front.quote-request.confirmation');
});



// Stubs temporaires remplacés en US-1.3 (services) et US-1.5 (devis)

Route::get('/urgence', fn () => 'Quick Demande à venir (Sprint 2)')->name('front.quick-request.create');


require __DIR__.'/auth.php';
