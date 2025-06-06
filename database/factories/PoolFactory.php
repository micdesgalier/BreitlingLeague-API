<?php

namespace Database\Factories;

use App\Models\Pool;
use App\Models\Stage;
use Illuminate\Database\Eloquent\Factories\Factory;

class PoolFactory extends Factory
{
    protected $model = Pool::class;

    public function definition(): array
    {
        return [
            'code_id'                    => $this->faker->word(),
            'stage_code_id'              => Stage::factory(), // Crée un Stage et récupère son code_id
            'order'                      => $this->faker->numberBetween(1, 10),
            'number_of_question'         => $this->faker->numberBetween(5, 20),
            'consecutive_correct_answer' => $this->faker->numberBetween(1, 5),
            'minimum_correct_question'   => $this->faker->numberBetween(1, 5),
        ];
    }
}