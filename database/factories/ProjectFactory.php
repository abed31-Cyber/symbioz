<?php

namespace Database\Factories;

use App\Enums\ProjectStatus;
use App\Models\Client;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    protected $model = Project::class;

    /** Libellés réalistes BTP. */
    private const LABELS = [
        'Rénovation cuisine',
        'Réfection salle de bain',
        'Extension véranda',
        'Mise aux normes électriques',
        'Ravalement façade',
        'Aménagement combles',
        'Création terrasse',
        'Rénovation globale appartement',
        'Remplacement plomberie',
        'Isolation thermique',
    ];

    public function definition(): array
    {
        return [
            'client_id' => Client::factory(),
            'label'     => fake()->randomElement(self::LABELS) . ' — ' . fake('fr_FR')->lastName(),
            'status'    => fake()->randomElement(ProjectStatus::cases()),
        ];
    }
}
