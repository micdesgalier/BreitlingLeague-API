<?php

namespace Database\Factories;

use App\Models\QuizActivityResult;
use App\Models\ActivityResult;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuizActivityResultFactory extends Factory
{
    /**
     * Modèle associé à cette factory.
     *
     * @var class-string<\App\Models\QuizActivityResult>
     */
    protected $model = QuizActivityResult::class;

    /**
     * Génère des données factices pour un résultat d’activité de quiz.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Score obtenu, avec 2 décimales entre 0 et 100
            'score' => $this->faker->randomFloat(2, 0, 100),

            // Nombre de réponses correctes dans l’activité
            'correct_answer_count' => $this->faker->numberBetween(0, 50),

            // Création automatique d’un résultat d’activité lié
            'activity_result_id' => ActivityResult::factory(),
        ];
    }
}