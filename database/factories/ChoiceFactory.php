<?php

namespace Database\Factories;

use App\Models\Choice;
use App\Models\Question;
use App\Models\Media;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChoiceFactory extends Factory
{
    protected $model = Choice::class;

    public function definition(): array
    {
        return [
            'code_id' => $this->faker->unique()->numberBetween(100000, 999999),
            'media_id' => null,
            'order' => $this->faker->numberBetween(1, 5),
            'is_correct' => $this->faker->boolean(25),
            'question_code_id' => Question::factory(), // création automatique de la question associée
        ];
    }
}