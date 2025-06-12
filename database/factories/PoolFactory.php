<?php

namespace Database\Factories;

use App\Models\Pool;
use App\Models\Stage;
use Illuminate\Database\Eloquent\Factories\Factory;

class PoolFactory extends Factory
{
    /**
     * Le modèle associé à cette factory.
     *
     * @var class-string<\App\Models\Pool>
     */
    protected $model = Pool::class;

    /**
     * Génère des données factices pour un pool.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Identifiant unique du pool
            'code_id' => $this->faker->unique()->word(),

            // Choix aléatoire d'un stage existant pour associer ce pool
            'stage_code_id' => function () {
                return Stage::inRandomOrder()->value('code_id');
            },

            // Ordre d’affichage du pool dans le stage
            'order' => $this->faker->numberBetween(1, 10),

            // Nombre de questions contenues dans ce pool
            'number_of_question' => $this->faker->numberBetween(5, 20),

            // Nombre de réponses correctes consécutives requises
            'consecutive_correct_answer' => $this->faker->numberBetween(1, 5),

            // Nombre minimum de questions correctes à valider
            'minimum_correct_question' => $this->faker->numberBetween(1, 5),
        ];
    }
}