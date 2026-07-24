<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Request as RequestModel;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Vérifie l'accès à la fiche client et l'affichage de l'historique (US-3.5 / US-3.6).
 */
class ClientHistoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_un_invite_ne_peut_pas_voir_une_fiche_client(): void
    {
        $client = Client::factory()->create();

        $this->get(route('admin.clients.show', $client))
             ->assertRedirect(route('login'));
    }

    public function test_la_fiche_client_affiche_toutes_ses_demandes(): void
    {
        $admin  = User::factory()->create();
        $client = Client::factory()->create();

        // 3 demandes rattachées à ce client
        RequestModel::factory()->count(3)->create(['client_id' => $client->id]);
        // 1 demande d'un autre client : ne doit PAS apparaître
        RequestModel::factory()->create();

        $response = $this->actingAs($admin)
                         ->get(route('admin.clients.show', $client));

        $response->assertOk();

        // La fiche ne liste que les 3 demandes du bon client
        $this->assertCount(3, $response->viewData('client')->requests);
    }

    public function test_la_fiche_affiche_la_reference_des_demandes(): void
    {
        $admin  = User::factory()->create();
        $client = Client::factory()->create();

        $requestModel = RequestModel::factory()->create([
            'client_id' => $client->id,
            'reference' => 'REF-TEST-42',
        ]);

        $this->actingAs($admin)
             ->get(route('admin.clients.show', $client))
             ->assertOk()
             ->assertSee('REF-TEST-42'); // la référence apparaît bien dans le HTML rendu
    }

    public function test_une_fiche_client_inexistante_renvoie_404(): void
    {
        $admin = User::factory()->create();

        $this->actingAs($admin)
             ->get('/admin/clients/999999')
             ->assertNotFound(); // route model binding → 404 automatique
    }
}
