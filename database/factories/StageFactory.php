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
            'code_id'           => $this->faker->unique()->numberBetween(100, 999),
            'quiz_code_id'      => Quiz::factory(),  // génère automatiquement un quiz et récupère son code_id
            'order'             => $this->faker->numberBetween(1, 10),
            'number_of_time_to_use' => $this->faker->numberBetween(1, 5),
        ];
    }
}