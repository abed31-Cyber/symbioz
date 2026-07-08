<?php

namespace Database\Factories;

use App\Enums\QuoteStatus;
use App\Enums\ServiceType;
use App\Models\QuickRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<QuickRequest>
 */
class QuickRequestFactory extends Factory
{
    protected $model = QuickRequest::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $this->faker = \Faker\Factory::create('fr_FR');

        $status = $this->faker->randomElement(QuoteStatus::cases());

        return [
            'contact_name' => $this->faker->name(),
            'contact_phone' => $this->faker->phoneNumber(),
            'contact_email' => $this->faker->safeEmail(),
            'address' => $this->faker->address(),
            'service_type' => $this->faker->randomElement(ServiceType::cases()),
            'description' => $this->faker->text(200),
            'status' => $status,
            'admin_notes' => $this->faker->optional(0.3)->sentence(),
            'lost_reason' => $status === QuoteStatus::LOST ? $this->faker->sentence() : null,
            'created_at' => $this->faker->dateTimeBetween('-2 weeks', 'now'), // Plus récent car "urgent"
        ];
    }
}





/**
 * Mes factories produisent des données qui respectent les règles de gestion,
 * comme lost_reason conditionnel au statut perdu.
 *  L'environnement de démo reflète fidèlement le comportement réel de l'application.
 */
