<?php

namespace Database\Factories;

use App\Models\QuizActivityResult;
use App\Models\ActivityResult;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuizActivityResultFactory extends Factory
{
    protected $model = QuizActivityResult::class;

    public function definition(): array
    {
        return [
            'score'                => $this->faker->randomFloat(2, 0, 100),
            'correct_answer_count' => $this->faker->numberBetween(0, 50),
            'activity_result_id'   => ActivityResult::factory(),
        ];
    }
}