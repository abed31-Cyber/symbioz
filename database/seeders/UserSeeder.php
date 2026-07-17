<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * 1 admin (Pascal/Karim) + 3 compagnons techniciens.
 * Idempotent via updateOrCreate.
 */
class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin — identifiants de démo
        User::updateOrCreate(
            ['email' => 'admin@symbioz.fr'],
            [
                'name'     => 'Karim Belhaj',
                'password' => Hash::make('password'),
                'role'     => UserRole::ADMIN,
            ]
        );

        // Compagnons techniciens
        $compagnons = [
            ['name' => 'Jean Moreau',   'email' => 'jean@symbioz.fr'],
            ['name' => 'Fatou Diallo',  'email' => 'fatou@symbioz.fr'],
            ['name' => 'Lucas Martin',  'email' => 'lucas@symbioz.fr'],
        ];

        foreach ($compagnons as $compagnon) {
            User::updateOrCreate(
                ['email' => $compagnon['email']],
                [
                    'name'     => $compagnon['name'],
                    'password' => Hash::make('password'),
                    'role'     => UserRole::TECHNICIEN,
                ]
            );
        }
    }
}
