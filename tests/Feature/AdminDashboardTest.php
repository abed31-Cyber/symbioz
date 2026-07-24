<?php

namespace Tests\Feature;

use App\Enums\RequestPriority;
use App\Enums\RequestStatus;
use App\Models\Request as RequestModel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Vérifie l'accès protégé au dashboard et l'exactitude des KPI (US-3.2 / US-3.6).
 */
class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_un_invite_est_redirige_vers_le_login(): void
    {
        $this->get(route('admin.dashboard'))
             ->assertRedirect(route('login'));
    }

    public function test_un_admin_connecte_accede_au_dashboard(): void
    {
        $admin = User::factory()->create();

        $this->actingAs($admin)
             ->get(route('admin.dashboard'))
             ->assertOk()
             ->assertViewIs('admin.dashboard');
    }

    public function test_les_compteurs_par_statut_sont_corrects(): void
    {
        $admin = User::factory()->create();

        // Jeu de données maîtrisé : 3 nouveaux, 2 en cours, 1 traité
        RequestModel::factory()->count(3)->create(['status' => RequestStatus::NOUVEAU]);
        RequestModel::factory()->count(2)->create(['status' => RequestStatus::EN_COURS]);
        RequestModel::factory()->count(1)->create(['status' => RequestStatus::TRAITE]);

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        // La vue reçoit bien le tableau countsByStatus avec les bons totaux
        $counts = $response->viewData('countsByStatus');

        $this->assertSame(3, $counts[RequestStatus::NOUVEAU->value]);
        $this->assertSame(2, $counts[RequestStatus::EN_COURS->value]);
        $this->assertSame(1, $counts[RequestStatus::TRAITE->value]);
    }

    public function test_les_demandes_archivees_sont_exclues_des_compteurs(): void
    {
        $admin = User::factory()->create();

        RequestModel::factory()->count(2)->create([
            'status'      => RequestStatus::NOUVEAU,
            'is_archived' => false,
        ]);
        RequestModel::factory()->create([
            'status'      => RequestStatus::NOUVEAU,
            'is_archived' => true, // ne doit PAS être comptée (scope active)
        ]);

        $counts = $this->actingAs($admin)
                       ->get(route('admin.dashboard'))
                       ->viewData('countsByStatus');

        $this->assertSame(2, $counts[RequestStatus::NOUVEAU->value]);
    }

    public function test_l_alerte_urgence_remonte_la_demande_urgente_non_traitee(): void
    {
        $admin = User::factory()->create();

        $urgente = RequestModel::factory()->create([
            'priority' => RequestPriority::URGENT,
            'status'   => RequestStatus::NOUVEAU,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $this->assertNotNull($response->viewData('urgentRequest'));
        $this->assertSame($urgente->id, $response->viewData('urgentRequest')->id);
    }
}
