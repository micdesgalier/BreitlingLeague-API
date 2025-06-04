<?php

namespace Database\Factories;

use App\Models\Pool;
use App\Models\Question;
use App\Models\PoolQuestion;
use Illuminate\Database\Eloquent\Factories\Factory;

class PoolQuestionFactory extends Factory
{
    protected $model = PoolQuestion::class;

    public function definition(): array
    {
        return [
            'pool_code_id'     => Pool::factory()->create()->code_id,     // s'assure d’avoir un code_id existant
            'question_code_id' => Question::factory()->create()->code_id, // idem
            'order'            => $this->faker->numberBetween(1, 10),
        ];
    }
}