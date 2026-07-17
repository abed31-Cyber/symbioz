<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Project;
use App\Models\Quote;
use App\Models\Request as RequestModel;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;
/**
 * La classe DatabaseSeeder est responsable de l'initialisation de la base de données avec des données de démonstration.
 * Elle crée un compte administrateur et génère des demandes de devis et des demandes urgentes fictives
 * pour permettre aux développeurs et testeurs de travailler avec un environnement réaliste.
 */


/**
 * Seeder principal — produit une base réaliste pour la démo.
 *
 * ~30 clients, ~50 demandes (mix devis/urgence),
 * services attachés (N-N n°1 peuplé),
 * quelques chantiers avec compagnons assignés (N-N n°2 peuplé),
 * quelques devis.
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Données de référence
        $this->call([
            ServiceSeeder::class,
            UserSeeder::class,
        ]);

        $services   = Service::all();
        $techniciens = User::where('role', 'technicien')->pluck('id');

        // 2. Clients (~30 dont quelques pros sans prénom et quelques sans email)
        $clients = Client::factory(25)->create();
        $clients = $clients->merge(Client::factory(3)->company()->create());
        $clients = $clients->merge(Client::factory(2)->withoutEmail()->create());

        // 3. Demandes (~50) rattachées à des clients existants
        $requests = collect();

        // ~35 demandes devis
        $requests = $requests->merge(
            RequestModel::factory(35)
                ->quote()
                ->recycle($clients)
                ->create()
        );

        // ~15 demandes urgence
        $requests = $requests->merge(
            RequestModel::factory(15)
                ->quick()
                ->recycle($clients)
                ->create()
        );

        // 4. N-N n°1 : attacher 1 à 3 services par demande
        $requests->each(function (RequestModel $request) use ($services) {
            $request->services()->sync(
                $services->random(rand(1, 3))->pluck('id')->toArray()
            );
        });

        // 5. Chantiers (~8) rattachés à des clients existants
        $projects = Project::factory(8)->recycle($clients)->create();

        // Rattacher quelques demandes à des chantiers
        $requests->random(12)->each(function (RequestModel $request) use ($projects) {
            $request->update([
                'project_id' => $projects->random()->id,
            ]);
        });

        // 6. N-N n°2 : assigner 1 à 2 techniciens par chantier
        $projects->each(function (Project $project) use ($techniciens) {
            $project->users()->sync(
                $techniciens->random(rand(1, min(2, $techniciens->count())))->toArray()
            );
        });

        // 7. Quelques devis sur des demandes non-urgence
        $requests->where('is_quick', false)->random(10)->each(function (RequestModel $request) {
            Quote::factory()->create(['request_id' => $request->id]);
        });
    }
}



/* Pour tester que tout ton circuit de données (Migrations + Enums + Models + Factories + Seeder) fonctionne parfaitement,
on exécute la commande de réinitialisation complète :
sail artisan migrate:fresh --seed
Cette commande vide toutes les tables, rejoue les migrations, puis exécute le Seeder).
migrate:fresh supprime toutes les tables et rejoue les migrations, --seed lance le seeder juste après.
 Base propre + peuplée en une commande.*/
