<?php

namespace Database\Factories;

use App\Models\UserAttemptChoice;
use App\Models\UserAttemptQuestion;
use App\Models\Choice;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserAttemptChoiceFactory extends Factory
{
    /**
     * Modèle associé à cette factory.
     *
     * @var class-string<\App\Models\UserAttemptChoice>
     */
    protected $model = UserAttemptChoice::class;

    /**
     * Génère des données factices pour UserAttemptChoice.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            // Crée une question liée à la tentative utilisateur
            'user_attempt_question_id' => UserAttemptQuestion::factory(),

            // Crée un choix associé à cette question
            'choice_code_id'           => Choice::factory(),

            // Indique si ce choix a été sélectionné par l'utilisateur
            'is_selected'              => $this->faker->boolean(80),

            // Indique si ce choix est correct
            'is_correct'               => $this->faker->boolean(50),
        ];
    }
}