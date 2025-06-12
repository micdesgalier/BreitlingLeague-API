<?php

namespace Database\Factories;

use App\Models\Stage;
use App\Models\Quiz;
use Illuminate\Database\Eloquent\Factories\Factory;

class StageFactory extends Factory
{
    /**
     * Modèle associé à cette factory.
     *
     * @var class-string<\App\Models\Stage>
     */
    protected $model = Stage::class;

    /**
     * Génère des données factices pour un stage.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            // Identifiant unique du stage
            'code_id' => $this->faker->unique()->numberBetween(100, 999),

            // Sélectionne aléatoirement un quiz existant en base
            // Nécessite qu'au moins un Quiz soit déjà seedé
            'quiz_code_id' => function () {
                return Quiz::inRandomOrder()->value('code_id');
            },

            // Ordre d'affichage ou de priorité du stage
            'order' => $this->faker->numberBetween(1, 10),

            // Nombre de fois que ce stage peut être utilisé
            'number_of_time_to_use' => $this->faker->numberBetween(1, 5),
        ];
    }
}