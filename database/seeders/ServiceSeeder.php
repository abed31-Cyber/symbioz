<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Référentiel figé des 6 services (CDC §4.4).
 * Idempotent : utilise updateOrCreate pour éviter les doublons.
 */
class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            'Plomberie',
            'Électricité',
            'Peinture',
            'Plâtrerie',
            'Menuiserie',
            'Rénovation globale',
        ];

        foreach ($services as $name) {
            Service::updateOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            );
        }
    }
}
