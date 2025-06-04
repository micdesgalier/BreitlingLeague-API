<?php

namespace Database\Factories;

use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    protected $model = Question::class;

    public function definition(): array
    {
        return [
            'code_id'                   => $this->faker->unique()->numberBetween(100000, 999999),
            'label_translation_code_id' => $this->faker->numberBetween(1, 9999),
            'is_active'                 => $this->faker->boolean(80),
            'media_id'                  => null, // ou Media::factory()->create()->id si tu veux associer un média
            'type'                      => $this->faker->randomElement(['text', 'number', 'select']),
            'is_choice_shuffle'         => $this->faker->boolean(),
            'correct_value'             => $this->faker->word(),
        ];
    }
}