<?php

namespace Database\Factories;

use App\Models\Stage;
use App\Models\Quiz;
use Illuminate\Database\Eloquent\Factories\Factory;

class StageFactory extends Factory
{
    protected $model = Stage::class;

    public function definition()
    {
        return [
            'code_id'               => $this->faker->unique()->numberBetween(100, 999),

            // Au lieu de créer un nouveau Quiz à chaque fois,
            // on récupère aléatoirement un quiz déjà existant en base.
            // Assure-toi qu’au moins un Quiz a été seedé AVANT d’utiliser StageFactory.
            'quiz_code_id'          => function () {
                // Récupère un code_id de Quiz existant
                return Quiz::inRandomOrder()->value('code_id');
            },

            'order'                 => $this->faker->numberBetween(1, 10),
            'number_of_time_to_use' => $this->faker->numberBetween(1, 5),
        ];
    }
}