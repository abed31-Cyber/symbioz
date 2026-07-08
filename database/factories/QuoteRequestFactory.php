<?php

namespace Database\Factories;

use App\Enums\QuoteStatus;
use App\Enums\ServiceType;
use App\Models\QuoteRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<QuoteRequest>
 */

// la classe QuoteRequestFactory est utilisée pour générer des instances de la classe QuoteRequest avec des données factices
// pour les tests et le développement. Elle utilise la bibliothèque Faker pour créer des valeurs aléatoires
// pour les différents champs de la requête de devis, en respectant certaines conditions, comme l'obligation de fournir
// une raison de perte si le statut est "perdu".
class QuoteRequestFactory extends Factory
{
    protected $model = QuoteRequest::class;

    public function definition(): array
    {
        $status = fake()->randomElement(QuoteStatus::cases());

        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->numerify('06########'),
            'address' => fake()->optional()->streetAddress(),
            'service_type' => fake()->randomElement(ServiceType::cases()),
            'description' => fake()->sentence(15),
            'budget_estimate' => fake()->optional()->randomFloat(2, 500, 15000),
            'status' => $status,
            'admin_notes' => fake()->optional()->sentence(),
            // lost_reason obligatoire seulement si status=perdu (RG-2)
            'lost_reason' => $status === QuoteStatus::LOST ? fake()->sentence() : null,
            'created_at' => fake()->dateTimeBetween('-2 months', 'now'),
        ];
    }
}


/**
 * RG-2 : Si le statut est "perdu", la raison de la perte doit être fournie.
 * Cette règle de gestion est respectée dans la méthode definition() de la factory.
 * Si le statut généré est "perdu", une raison de perte aléatoire est générée, sinon elle est laissée à null.
 */

/**
 * RG-3 : Le budget estimatif doit être un nombre décimal positif.
 * Cette règle de gestion est respectée dans la méthode definition() de la factory.
 * Le budget estimatif est généré aléatoirement entre 500 et 15000, avec une précision de 2 décimales.
 */

/**
 * RG-4 : Le type de service doit être l'un des types définis dans l'énumération ServiceType.
 * Cette règle de gestion est respectée dans la méthode definition() de la factory.
 * Le type de service est choisi aléatoirement parmi les valeurs de l'énumération ServiceType.
 */
