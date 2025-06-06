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
            // Récupère aléatoirement un code_id de Pool déjà en base
            'pool_code_id'     => Pool::inRandomOrder()->value('code_id'),
            
            // Récupère aléatoirement un code_id de Question déjà en base
            'question_code_id' => Question::inRandomOrder()->value('code_id'),
            
            'order'            => $this->faker->numberBetween(1, 10),
        ];
    }
}