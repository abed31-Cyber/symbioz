<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Request as RequestModel;
use App\Models\Service;
use App\Notifications\NewRequestNotification;
use App\Notifications\RequestReceivedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

/**
 * Parcours de soumission d'une demande urgente.
 */
class QuickSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_quick_form_is_accessible(): void
    {
        Service::factory()->count(6)->create();

        $this->get(route('front.quick.create'))
            ->assertOk()
            ->assertSee('Un problème urgent');
    }

    /**
     * RG-10 : is_quick et priority sont fixés par le serveur, pas par le client.
     */
    public function test_valid_submission_creates_urgent_request(): void
    {
        Notification::fake();

        $services = Service::factory()->count(2)->create();

        $response = $this->post(route('front.quick.store'), [
            'last_name'   => 'Mercier',
            'phone'       => '0612345678',
            'service_ids' => $services->pluck('id')->toArray(),
            'description' => 'Fuite sous l’évier, urgent.',
        ]);

        $response->assertRedirect(route('front.quick.confirmation'));

        $requestModel = RequestModel::where('is_quick', true)->latest('id')->first();
        $this->assertNotNull($requestModel);
        $this->assertEquals('nouveau', $requestModel->status->value);
        $this->assertEquals('urgent', $requestModel->priority->value);

        // Assertion N-N : 2 services cochés → 2 lignes pivot
        $this->assertCount(2, $requestModel->services);

        Notification::assertSentOnDemand(NewRequestNotification::class);
    }

    /**
     * RG-9 : au moins un service obligatoire.
     */
    public function test_submission_without_service_is_rejected(): void
    {
        $this->post(route('front.quick.store'), [
            'last_name'   => 'Mercier',
            'phone'       => '0612345678',
            'description' => 'Fuite sous l’évier.',
        ])->assertSessionHasErrors('service_ids');

        $this->assertDatabaseCount('requests', 0);
    }

    /**
     * RG-8 : sans email, la demande est créée et aucun accusé client n'est envoyé.
     */
    public function test_submission_without_email_creates_request_and_sends_no_receipt(): void
    {
        Notification::fake();

        $services = Service::factory()->count(1)->create();

        $this->post(route('front.quick.store'), [
            'last_name'   => 'Mercier',
            'phone'       => '0612345678',
            'service_ids' => $services->pluck('id')->toArray(),
            'description' => 'Fuite sous l’évier, urgent.',
        ]);

        // La demande existe bien, malgré l'absence d'email
        $this->assertDatabaseCount('requests', 1);
        $this->assertDatabaseHas('clients', ['email' => null]);

        // L'admin est prévenu (RG-6, inconditionnel)
        Notification::assertSentOnDemand(NewRequestNotification::class);

        // Mais le client ne reçoit rien (RG-8)
        Notification::assertNotSentTo(
            Client::whereNull('email')->get(),
            RequestReceivedNotification::class
        );
    }

    /**
     * RG-7 : avec email, l'accusé de réception client est envoyé.
     */
    public function test_submission_with_email_sends_receipt(): void
    {
        Notification::fake();

        $services = Service::factory()->count(1)->create();

        $this->post(route('front.quick.store'), [
            'last_name'   => 'Mercier',
            'phone'       => '0612345678',
            'email'       => 'sophie@email.fr',
            'service_ids' => $services->pluck('id')->toArray(),
            'description' => 'Fuite sous l’évier, urgent.',
        ]);

        $this->assertDatabaseHas('clients', ['email' => 'sophie@email.fr']);

        Notification::assertSentTo(
            Client::where('email', 'sophie@email.fr')->get(),
            RequestReceivedNotification::class
        );
    }

    /**
     * RG-5 : rate limit 10/min.
     */
    public function test_rate_limit_blocks_after_ten_submissions(): void
    {
        Notification::fake();

        $services = Service::factory()->count(1)->create();

        $payload = [
            'last_name'   => 'Test',
            'phone'       => '0612345678',
            'service_ids' => $services->pluck('id')->toArray(),
            'description' => 'Description de test.',
        ];

        for ($i = 0; $i < 10; $i++) {
            $this->post(route('front.quick.store'), $payload);
        }

        $this->post(route('front.quick.store'), $payload)->assertStatus(429);
    }
}
