<?php 

namespace Database\Factories;

use App\Models\UserAttempt;
use App\Models\User;
use App\Models\Quiz;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserAttemptFactory extends Factory
{
    /**
     * Modèle associé à cette factory.
     *
     * @var class-string<\App\Models\UserAttempt>
     */
    protected $model = UserAttempt::class;

    /**
     * Génère des données factices pour une tentative utilisateur.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // Date de début aléatoire dans les 10 derniers jours
        $start = $this->faker->dateTimeBetween('-10 days', 'now');
        // Date de fin entre la date de début et maintenant
        $end = $this->faker->dateTimeBetween($start, 'now');

        return [
            // Création automatique d’un utilisateur associé
            'user_id'           => User::factory(),

            // Création automatique d’un quiz associé
            'quiz_code_id'      => Quiz::factory(),

            'start_date'        => $start,
            'end_date'          => $end,

            // Indique si la tentative est terminée (70 % de chances)
            'is_completed'      => $this->faker->boolean(70),

            // Durée de la tentative en secondes
            'duration'          => $this->faker->numberBetween(30, 3600),

            // Scores et bonus associés à la tentative
            'score'             => $this->faker->numberBetween(0, 20000),
            'initial_score'     => $this->faker->numberBetween(0, 100),
            'combo_bonus_score' => $this->faker->numberBetween(0, 50),
            'time_bonus_score'  => $this->faker->numberBetween(0, 50),
        ];
    }
}