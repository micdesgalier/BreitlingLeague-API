<?php

namespace Database\Factories;

use App\Models\Choice;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChoiceFactory extends Factory
{
    /**
     * Le modèle associé à cette factory.
     *
     * @var class-string<\App\Models\Choice>
     */
    protected $model = Choice::class;

    /**
     * Génère des données factices pour un choix de question.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Identifiant unique du choix
            'code_id' => $this->faker->unique()->numberBetween(100000, 999999),

            // Identifiant du média associé, null par défaut (pas de média)
            'media_id' => null,

            // Position du choix parmi les options (ordre d’affichage)
            'order' => $this->faker->numberBetween(1, 5),

            // Indique si ce choix est la bonne réponse (25% de chances)
            'is_correct' => $this->faker->boolean(25),

            // Création automatique d'une question liée pour ce choix
            'question_code_id' => Question::factory(),
        ];
    }
}