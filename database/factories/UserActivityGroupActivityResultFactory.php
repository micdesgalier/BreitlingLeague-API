<?php 

namespace Database\Factories;

use App\Models\UserActivityGroupActivityResult;
use App\Models\User;
use App\Models\ActivityGroupActivity;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserActivityGroupActivityResultFactory extends Factory
{
    /**
     * Modèle associé à cette factory.
     *
     * @var class-string<\App\Models\UserActivityGroupActivityResult>
     */
    protected $model = UserActivityGroupActivityResult::class;

    /**
     * Génère des données factices pour UserActivityGroupActivityResult.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // Indique si l'activité est complétée (80 % de chances)
        $completed = $this->faker->boolean(80);

        return [
            // Création automatique d’un utilisateur associé
            'user_id'                    => User::factory(),

            // Identifiant fixe d’une activité de groupe d’activité
            'activity_group_activity_id' => 1,

            // Indique si l’activité est terminée
            'is_completed'               => $completed,

            // Date d'achèvement si complété, sinon null
            'completion_date'            => $completed
                ? $this->faker->dateTimeBetween('-5 days', 'now')
                : null,

            // Score obtenu sur cette activité
            'score'                     => $this->faker->randomFloat(2, 0, 100),

            // Pourcentage du score obtenu
            'score_percent'             => $this->faker->randomFloat(2, 0, 100),

            // Indique si le score s’est amélioré
            'has_improved_score'        => $this->faker->boolean(50),
        ];
    }
}
