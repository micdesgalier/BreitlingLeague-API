<?php

namespace Database\Factories;

use App\Models\Quiz;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuizFactory extends Factory
{
    protected $model = Quiz::class;

    public function definition(): array
    {
        return [
            'code_id'                   => $this->faker->unique()->numberBetween(1000, 9999),
            'type'                      => $this->faker->randomElement(['classic', 'duel', 'exam']),
            'label_translation_code_id' => $this->faker->numberBetween(10000, 99999),
            'shuffle_type'              => $this->faker->randomElement(['none', 'question', 'choice']),
            'shuffle_scope'             => $this->faker->randomElement(['global', 'stage']),
            'draw_type'                 => $this->faker->randomElement(['random', 'fixed']),
            'max_user_attempt'          => $this->faker->numberBetween(1, 10),
            'is_unlimited'              => $this->faker->boolean(20),
            'duration'                  => $this->faker->numberBetween(60, 3600), // en secondes
            'question_duration'         => $this->faker->numberBetween(10, 120),
            'correct_choice_points'     => 1000,
            'wrong_choice_points'       => 0,
        ];
    }
}