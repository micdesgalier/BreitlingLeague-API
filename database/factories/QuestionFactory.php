<?php

namespace Database\Factories;

use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    /**
     * Modèle associé à cette factory.
     *
     * @var class-string<\App\Models\Question>
     */
    protected $model = Question::class;

    /**
     * Génère des données factices pour une question.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Identifiant unique de la question
            'code_id' => $this->faker->unique()->numberBetween(100000, 999999),

            // Intitulé ou label de la question (ici un nombre fictif)
            'label' => $this->faker->numberBetween(1, 9999),

            // Indique si la question est active
            'is_active' => $this->faker->boolean(80),

            // Id du média associé, nul par défaut
            'media_id' => null,

            // Type de question : texte, nombre ou sélection
            'type' => $this->faker->randomElement(['text', 'number', 'select']),

            // Indique si l'ordre des choix est mélangé
            'is_choice_shuffle' => $this->faker->boolean(),

            // Valeur correcte attendue pour la question
            'correct_value' => $this->faker->word(),
        ];
    }
}