<?php

namespace Tests\Unit;

use App\Models\Request as RequestModel;
use App\Models\Service;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Vérifie la relation N-N request_service au niveau du pivot.
 * Point clé jury : le retrait est testé autant que l'ajout (preuve du Many-to-Many).
 */
class RequestServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_sync_ajoute_puis_retire_des_services_dans_le_pivot(): void
    {
        $requestModel = RequestModel::factory()->create();
        $services = Service::factory()->count(3)->create();

        // Ajout : on attache les 3 services
        $requestModel->services()->sync($services->pluck('id'));

        $this->assertCount(3, $requestModel->services()->get());
        $this->assertDatabaseHas('request_service', [
            'request_id' => $requestModel->id,
            'service_id' => $services->first()->id,
        ]);

        // Retrait : on ne garde qu'un seul service
        $requestModel->services()->sync([$services->first()->id]);

        // La ligne conservée existe toujours...
        $this->assertDatabaseHas('request_service', [
            'request_id' => $requestModel->id,
            'service_id' => $services->first()->id,
        ]);

        // ...mais les deux autres ont disparu du pivot (c'est ça, la preuve du N-N)
        $this->assertDatabaseMissing('request_service', [
            'request_id' => $requestModel->id,
            'service_id' => $services->last()->id,
        ]);
        $this->assertCount(1, $requestModel->services()->get());
    }
}
