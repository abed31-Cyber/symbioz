<?php

namespace Database\Seeders;

use App\Models\QuickRequest;
use App\Models\QuoteRequest;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * La classe DatabaseSeeder est responsable de l'initialisation de la base de données avec des données de démonstration.
 * Elle crée un compte administrateur et génère des demandes de devis et des demandes urgentes fictives
 * pour permettre aux développeurs et testeurs de travailler avec un environnement réaliste.
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Création du compte administrateur unique pour Karim
        User::factory()->create([
            'name' => 'Karim Admin',
            'email' => 'admin@symbioz.fr',
            'password' => Hash::make('password'),
        ]);

      // 2. Génération des 30 demandes de devis classiques via la Factory
        QuoteRequest::factory()->count(30)->create();
        // 3. Génération des 30 demandes urgentes (Quick Demandes) via la Factory
        QuickRequest::factory()->count(30)->create();
    }
}




/* Pour tester que tout ton circuit de données (Migrations + Enums + Models + Factories + Seeder) fonctionne parfaitement,
on exécute la commande de réinitialisation complète :
sail artisan migrate:fresh --seed
Cette commande vide toutes les tables, rejoue les migrations, puis exécute le Seeder). */
