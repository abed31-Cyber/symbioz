<?php

namespace Database\Factories;

use App\Enums\ClientStatus;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory pour les clients — données réalistes francophones.
 *
 * @extends Factory<Client>
 */
class ClientFactory extends Factory
{
    protected $model = Client::class;

    public function definition(): array
    {
        return [
            'first_name' => fake('fr_FR')->firstName(),
            'last_name'  => fake('fr_FR')->lastName(),
            'email'      => fake()->unique()->safeEmail(),
            'phone'      => fake('fr_FR')->numerify('06########'),
            'address'    => fake('fr_FR')->streetAddress(),
            'city'       => fake('fr_FR')->city(),
            'status'     => fake()->randomElement(ClientStatus::cases()),
        ];
    }

    /**
     * Client professionnel (pas de prénom, raison sociale dans last_name).
     */
    public function company(): static
    {
        return $this->state(fn () => [
            'first_name' => null,
            'last_name'  => fake('fr_FR')->company(),
        ]);
    }

    /**
     * Client sans email (cas urgence).
     */
    public function withoutEmail(): static
    {
        return $this->state(fn () => [
            'email' => null,
        ]);
    }
}
