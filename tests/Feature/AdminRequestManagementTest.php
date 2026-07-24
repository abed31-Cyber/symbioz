<?php

namespace Tests\Feature;

use App\Enums\RequestPriority;
use App\Enums\RequestStatus;
use App\Models\Request as RequestModel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Vérifie le pilotage d'une demande côté admin : statut, priorité, RG-2 (US-4.2).
 */
class AdminRequestManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_un_invite_ne_peut_pas_modifier_une_demande(): void
    {
        $requestModel = RequestModel::factory()->create();

        $this->patch(route('admin.requests.update', $requestModel), [
            'status'   => RequestStatus::EN_COURS->value,
            'priority' => RequestPriority::NORMAL->value,
        ])->assertRedirect(route('login'));
    }

    public function test_l_admin_change_le_statut_et_la_priorite(): void
    {
        $admin = User::factory()->create();
        $requestModel = RequestModel::factory()->create([
            'status'   => RequestStatus::NOUVEAU,
            'priority' => RequestPriority::NORMAL,
        ]);

        $this->actingAs($admin)
             ->patch(route('admin.requests.update', $requestModel), [
                 'status'      => RequestStatus::EN_COURS->value,
                 'priority'    => RequestPriority::URGENT->value,
                 'admin_notes' => 'RDV téléphonique prévu jeudi 14h.',
             ])
             ->assertRedirect(route('admin.requests.show', $requestModel));

        $this->assertDatabaseHas('requests', [
            'id'          => $requestModel->id,
            'status'      => RequestStatus::EN_COURS->value,
            'priority'    => RequestPriority::URGENT->value,
            'admin_notes' => 'RDV téléphonique prévu jeudi 14h.',
        ]);
    }

    public function test_passer_a_perdu_sans_raison_est_rejete(): void
    {
        $admin = User::factory()->create();
        $requestModel = RequestModel::factory()->create([
            'status' => RequestStatus::NOUVEAU,
        ]);

        $this->actingAs($admin)
             ->patch(route('admin.requests.update', $requestModel), [
                 'status'         => RequestStatus::PERDU->value,
                 'priority'       => RequestPriority::NORMAL->value,
                 'closing_reason' => '', // RG-2 : vide → doit échouer
             ])
             ->assertSessionHasErrors('closing_reason');

        // La demande n'a PAS été passée en perdu
        $this->assertDatabaseHas('requests', [
            'id'     => $requestModel->id,
            'status' => RequestStatus::NOUVEAU->value,
        ]);
    }

    public function test_passer_a_perdu_avec_raison_est_accepte(): void
    {
        $admin = User::factory()->create();
        $requestModel = RequestModel::factory()->create([
            'status' => RequestStatus::NOUVEAU,
        ]);

        $this->actingAs($admin)
             ->patch(route('admin.requests.update', $requestModel), [
                 'status'         => RequestStatus::PERDU->value,
                 'priority'       => RequestPriority::NORMAL->value,
                 'closing_reason' => 'Le client a choisi un concurrent moins cher.',
             ])
             ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('requests', [
            'id'             => $requestModel->id,
            'status'         => RequestStatus::PERDU->value,
            'closing_reason' => 'Le client a choisi un concurrent moins cher.',
        ]);
    }

    public function test_quitter_le_statut_perdu_efface_la_raison(): void
    {
        $admin = User::factory()->create();
        // Demande déjà perdue avec une raison
        $requestModel = RequestModel::factory()->lost()->create();

        $this->actingAs($admin)
             ->patch(route('admin.requests.update', $requestModel), [
                 'status'   => RequestStatus::EN_COURS->value,
                 'priority' => RequestPriority::NORMAL->value,
             ])
             ->assertSessionHasNoErrors();

        // La raison est effacée : pas de closing_reason orpheline
        $this->assertDatabaseHas('requests', [
            'id'             => $requestModel->id,
            'status'         => RequestStatus::EN_COURS->value,
            'closing_reason' => null,
        ]);
    }
}
