<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\HomeController;

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

// Stubs temporaires remplacés en US-1.3 (services) et US-1.5 (devis)
Route::get('/devis', fn () => 'Devis  à venir')->name('front.quote-request.create');
Route::get('/urgence', fn () => 'Quick Demande à venir (Sprint 2)')->name('front.quick-request.create');


require __DIR__.'/auth.php';
