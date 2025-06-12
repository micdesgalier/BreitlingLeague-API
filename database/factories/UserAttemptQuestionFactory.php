<?php 

namespace Database\Factories;

use App\Models\UserAttemptQuestion;
use App\Models\UserAttempt;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserAttemptQuestionFactory extends Factory
{
    /**
     * Modèle associé à cette factory.
     *
     * @var class-string<\App\Models\UserAttemptQuestion>
     */
    protected $model = UserAttemptQuestion::class;

    /**
     * Génère des données factices pour une question dans une tentative utilisateur.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            // Création automatique d’une tentative utilisateur associée
            'user_attempt_id'   => UserAttempt::factory(),

            // Position de la question dans l’ordre des questions de la tentative
            'order'             => $this->faker->numberBetween(1, 20),

            // Indique si la réponse donnée est correcte (50 % de chances)
            'is_correct'        => $this->faker->boolean(50),

            // Score attribué à cette question (0 ou 1000 points)
            'score'             => $this->faker->randomElement([0, 1000]),

            // Création automatique d’une question associée
            'question_code_id'  => Question::factory(),

            // Valeur du bonus de combo pour cette question
            'combo_bonus_value' => $this->faker->numberBetween(0, 50),
        ];
    }
}