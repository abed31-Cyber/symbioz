<?php

namespace Database\Factories;

use App\Enums\RequestPriority;
use App\Enums\RequestStatus;
use App\Models\Client;
use App\Models\Request;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory pour les demandes (devis et urgence).
 *
 * @extends Factory<Request>
 */
class RequestFactory extends Factory
{
    protected $model = Request::class;

    /**
     * Compteur statique pour garantir l'unicité des références.
     */
    private static int $refCounter = 0;

    public function definition(): array
    {
        $isQuick = fake()->boolean(30); // 30% urgences, 70% devis

        return [
            'client_id'       => Client::factory(),
            'project_id'      => null,
            'reference'       => 'REF-' . str_pad(++self::$refCounter, 4, '0', STR_PAD_LEFT),
            'description'     => fake('fr_FR')->realText(200),
            'is_quick'        => $isQuick,
            'priority'        => $isQuick ? RequestPriority::URGENT : RequestPriority::NORMAL,
            'budget_estimate' => $isQuick ? null : fake()->randomFloat(2, 500, 25000),
            'status'          => fake()->randomElement(RequestStatus::cases()),
            'closing_reason'  => null,
            'admin_notes'     => fake()->optional(0.3)->sentence(),
            'is_archived'     => false,
        ];
    }

    /**
     * Demande de type devis.
     */
    public function quote(): static
    {
        return $this->state(fn () => [
            'is_quick'        => false,
            'priority'        => RequestPriority::NORMAL,
            'budget_estimate' => fake()->randomFloat(2, 1000, 20000),
        ]);
    }

    /**
     * Demande de type urgence.
     */
    public function quick(): static
    {
        return $this->state(fn () => [
            'is_quick'        => true,
            'priority'        => RequestPriority::URGENT,
            'budget_estimate' => null,
        ]);
    }

    /**
     * Demande avec statut « perdu » + raison obligatoire (RG-2).
     */
    public function lost(): static
    {
        return $this->state(fn () => [
            'status'         => RequestStatus::PERDU,
            'closing_reason' => fake('fr_FR')->sentence(),
        ]);
    }
}
