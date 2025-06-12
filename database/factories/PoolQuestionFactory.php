<?php

namespace Database\Factories;

use App\Models\Pool;
use App\Models\Question;
use App\Models\PoolQuestion;
use Illuminate\Database\Eloquent\Factories\Factory;

class PoolQuestionFactory extends Factory
{
    /**
     * Modèle associé à cette factory.
     *
     * @var class-string<\App\Models\PoolQuestion>
     */
    protected $model = PoolQuestion::class;

    /**
     * Génère des données factices pour associer une question à un pool.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Choisit un pool existant au hasard
            'pool_code_id' => Pool::inRandomOrder()->value('code_id'),

            // Choisit une question existante au hasard
            'question_code_id' => Question::inRandomOrder()->value('code_id'),

            // Position ou ordre de la question dans le pool
            'order' => $this->faker->numberBetween(1, 10),
        ];
    }
}