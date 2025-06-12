<?php

namespace Database\Factories;

use App\Models\Quiz;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuizFactory extends Factory
{
    /**
     * Modèle associé à cette factory.
     *
     * @var class-string<\App\Models\Quiz>
     */
    protected $model = Quiz::class;

    /**
     * Génère des données factices pour un quiz.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Identifiant unique du quiz
            'code_id' => $this->faker->unique()->numberBetween(1000, 9999),

            // Type de quiz : classique, duel ou examen
            'type' => $this->faker->randomElement(['classic', 'duel', 'exam']),

            // Code de traduction pour le label du quiz
            'label_translation_code_id' => $this->faker->numberBetween(10000, 99999),

            // Type de mélange des questions ou choix
            'shuffle_type' => $this->faker->randomElement(['none', 'question', 'choice']),

            // Portée du mélange : global ou par stage
            'shuffle_scope' => $this->faker->randomElement(['global', 'stage']),

            // Type de tirage des questions : aléatoire ou fixe
            'draw_type' => $this->faker->randomElement(['random', 'fixed']),

            // Nombre maximal de tentatives par utilisateur
            'max_user_attempt' => $this->faker->numberBetween(1, 10),

            // Indique si le nombre de tentatives est illimité (20% de chances)
            'is_unlimited' => $this->faker->boolean(20),

            // Durée totale du quiz en secondes
            'duration' => $this->faker->numberBetween(60, 3600),

            // Durée allouée par question en secondes
            'question_duration' => $this->faker->numberBetween(10, 120),

            // Points attribués pour un choix correct
            'correct_choice_points' => 1000,

            // Points attribués pour un choix incorrect
            'wrong_choice_points' => 0,
        ];
    }
}