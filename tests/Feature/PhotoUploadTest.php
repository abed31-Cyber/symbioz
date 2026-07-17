<?php

namespace Tests\Feature;

use App\Models\Request as RequestModel;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * Upload et stockage des photos jointes à une demande.
 */
class PhotoUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_photos_are_stored_and_linked(): void
    {
        Storage::fake('public');
        Notification::fake();

        $services = Service::factory()->count(1)->create();

        $this->post(route('front.quote.store'), [
            'last_name'   => 'Laurent',
            'email'       => 'marie@email.fr',
            'phone'       => '0612345678',
            'address'     => '22 bd de Strasbourg',
            'city'        => 'Toulouse',
            'service_ids' => $services->pluck('id')->toArray(),
            'description' => 'Rénovation avec photos jointes.',
            'photos'      => [
                UploadedFile::fake()->image('cuisine.jpg'),
                UploadedFile::fake()->image('salle-bain.png'),
            ],
        ]);

        $requestModel = RequestModel::latest('id')->first();

        $this->assertCount(2, $requestModel->photos);

        foreach ($requestModel->photos as $photo) {
            Storage::disk('public')->assertExists($photo->path);
        }
    }

    public function test_non_image_file_is_rejected(): void
    {
        Storage::fake('public');

        $services = Service::factory()->count(1)->create();

        $this->post(route('front.quote.store'), [
            'last_name'   => 'Laurent',
            'email'       => 'marie@email.fr',
            'phone'       => '0612345678',
            'address'     => '22 bd de Strasbourg',
            'city'        => 'Toulouse',
            'service_ids' => $services->pluck('id')->toArray(),
            'description' => 'Tentative avec un PDF.',
            'photos'      => [
                UploadedFile::fake()->create('document.pdf', 100, 'application/pdf'),
            ],
        ])->assertSessionHasErrors('photos.0');

        $this->assertDatabaseCount('requests', 0);
    }
}
