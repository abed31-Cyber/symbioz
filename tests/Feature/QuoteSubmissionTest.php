<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Request as RequestModel;
use App\Models\Service;
use App\Notifications\NewRequestNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

/**
 * Parcours de soumission d'une demande de devis.
 */
class QuoteSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_quote_form_is_accessible(): void
    {
        Service::factory()->count(6)->create();

        $this->get(route('front.quote.create'))
            ->assertOk()
            ->assertSee('Parlez-nous de votre projet');
    }

    public function test_valid_submission_creates_request_with_services(): void
    {
        Notification::fake();

        $services = Service::factory()->count(2)->create();

        $response = $this->post(route('front.quote.store'), [
            'last_name'   => 'Laurent',
            'email'       => 'marie.laurent@email.fr',
            'phone'       => '0612345678',
            'address'     => '22 boulevard de Strasbourg',
            'city'        => 'Toulouse',
            'service_ids' => $services->pluck('id')->toArray(),
            'description' => 'Rénovation complète de la salle de bain.',
        ]);

        $response->assertRedirect(route('front.quote.confirmation'));

        $requestModel = RequestModel::where('is_quick', false)->latest('id')->first();
        $this->assertNotNull($requestModel);
        $this->assertEquals('nouveau', $requestModel->status->value);

        // Assertion N-N : 2 services cochés → 2 lignes pivot
        $this->assertCount(2, $requestModel->services);
        $this->assertDatabaseHas('request_service', [
            'request_id' => $requestModel->id,
            'service_id' => $services->first()->id,
        ]);

        $this->assertDatabaseHas('clients', ['email' => 'marie.laurent@email.fr']);

        Notification::assertSentOnDemand(NewRequestNotification::class);
    }

    public function test_submission_without_service_is_rejected(): void
    {
        $this->post(route('front.quote.store'), [
            'last_name'   => 'Laurent',
            'email'       => 'marie@email.fr',
            'phone'       => '0612345678',
            'address'     => '22 bd de Strasbourg',
            'city'        => 'Toulouse',
            'description' => 'Une description assez longue.',
        ])->assertSessionHasErrors('service_ids');

        $this->assertDatabaseCount('requests', 0);
    }

    public function test_same_email_does_not_duplicate_client(): void
    {
        Notification::fake();
        $services = Service::factory()->count(1)->create();

        $payload = [
            'last_name'   => 'Laurent',
            'email'       => 'marie@email.fr',
            'phone'       => '0612345678',
            'address'     => '22 bd de Strasbourg',
            'city'        => 'Toulouse',
            'service_ids' => $services->pluck('id')->toArray(),
            'description' => 'Première demande de rénovation.',
        ];

        $this->post(route('front.quote.store'), $payload);
        $this->post(route('front.quote.store'), array_merge($payload, [
            'description' => 'Deuxième demande, même client.',
        ]));

        $this->assertEquals(1, Client::where('email', 'marie@email.fr')->count());
        $this->assertDatabaseCount('requests', 2);
    }

    public function test_rate_limit_blocks_after_ten_submissions(): void
    {
        Notification::fake();
        $services = Service::factory()->count(1)->create();

        $payload = [
            'last_name'   => 'Test',
            'email'       => 'test@email.fr',
            'phone'       => '0612345678',
            'address'     => 'Adresse',
            'city'        => 'Toulouse',
            'service_ids' => $services->pluck('id')->toArray(),
            'description' => 'Description de test suffisamment longue.',
        ];

        for ($i = 0; $i < 10; $i++) {
            $this->post(route('front.quote.store'), $payload);
        }

        $this->post(route('front.quote.store'), $payload)->assertStatus(429);
    }
}
