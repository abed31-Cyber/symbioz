<?php

namespace Tests\Feature;

use App\Models\Request as RequestModel;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Vérifie le cycle de vie archivage d'une demande : archive, restore, forceDelete (US-4.4 à 4.6, RG-3/RG-4).
 */
class AdminArchiveTest extends TestCase
{
    use RefreshDatabase;

    public function test_un_invite_ne_peut_pas_archiver(): void
    {
        $requestModel = RequestModel::factory()->create();

        $this->delete(route('admin.requests.archive', $requestModel))
             ->assertRedirect(route('login'));
    }

    public function test_l_admin_archive_une_demande(): void
    {
        $admin = User::factory()->create();
        $requestModel = RequestModel::factory()->create();

        $this->actingAs($admin)
             ->delete(route('admin.requests.archive', $requestModel))
             ->assertRedirect(route('admin.requests.index'));

        // Soft delete : la ligne existe encore mais deleted_at est renseigné
        $this->assertSoftDeleted('requests', ['id' => $requestModel->id]);
    }

    public function test_une_demande_archivee_disparait_de_la_liste_active(): void
    {
        $admin = User::factory()->create();
        $requestModel = RequestModel::factory()->create();

        $requestModel->delete(); // archivage

        // La liste active ne doit plus la contenir (SoftDeletes l'exclut)
        $this->actingAs($admin)
             ->get(route('admin.requests.index'))
             ->assertDontSee($requestModel->reference);
    }

    public function test_l_admin_restaure_une_demande_archivee(): void
    {
        $admin = User::factory()->create();
        $requestModel = RequestModel::factory()->create();
        $requestModel->delete();

        $this->actingAs($admin)
             ->patch(route('admin.archives.restore', $requestModel->id))
             ->assertRedirect(route('admin.archives.index'));

        // deleted_at repasse à null : la demande n'est plus archivée
        $this->assertNotSoftDeleted('requests', ['id' => $requestModel->id]);
    }

    public function test_la_suppression_definitive_detruit_la_demande_et_le_pivot(): void
    {
        $admin = User::factory()->create();
        $services = Service::factory()->count(2)->create();

        $requestModel = RequestModel::factory()->create();
        $requestModel->services()->sync($services->pluck('id'));
        $requestModel->delete(); // il faut être archivé avant de supprimer (RG-3)

        $this->actingAs($admin)
             ->delete(route('admin.archives.destroy', $requestModel->id))
             ->assertRedirect(route('admin.archives.index'));

        // Hard delete : la ligne n'existe plus du tout
        $this->assertDatabaseMissing('requests', ['id' => $requestModel->id]);

        // Cascade : les lignes pivot ont disparu avec la demande (ON DELETE CASCADE)
        $this->assertDatabaseMissing('request_service', ['request_id' => $requestModel->id]);
    }
}
