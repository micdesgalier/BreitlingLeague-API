<?php

namespace Database\Factories;

use App\Models\ActivityResult;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActivityResultFactory extends Factory
{
    /**
     * Le modèle associé à cette factory.
     *
     * @var class-string<\App\Models\ActivityResult>
     */
    protected $model = ActivityResult::class;

    /**
     * Génère des données factices pour un résultat d'activité.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Durée de l'activité en secondes (entre 30s et 1h)
            'duration' => $this->faker->numberBetween(30, 3600),
        ];
    }
}