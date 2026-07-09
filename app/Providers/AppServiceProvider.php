<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */

    // methode register() est utilisée pour enregistrer des services dans le conteneur d'injection de dépendances de Laravel.
    // C'est ici que vous pouvez lier des interfaces à des implémentations concrètes, enregistrer des singletons,
    // ou effectuer d'autres configurations liées aux services.
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
