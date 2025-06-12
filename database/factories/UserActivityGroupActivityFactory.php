<?php

namespace Database\Factories;

use App\Models\UserActivityGroupActivity;
use App\Models\User;
use App\Models\ActivityGroupActivity;
use App\Models\ActivityResult;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserActivityGroupActivityFactory extends Factory
{
    /**
     * Modèle associé à cette factory.
     *
     * @var class-string<\App\Models\UserActivityGroupActivity>
     */
    protected $model = UserActivityGroupActivity::class;

    /**
     * Génère des données factices pour UserActivityGroupActivity.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // Date de début comprise entre il y a 10 jours et maintenant
        $start = $this->faker->dateTimeBetween('-10 days', 'now');

        // Date de fin comprise entre la date de début et 5 jours après
        $end = $this->faker->dateTimeBetween($start, '+5 days');

        return [
            'start_date'                => $start,
            'end_date'                  => $end,
            'progression_score'         => $this->faker->randomFloat(2, 0, 100),
            'progression_score_percent' => $this->faker->randomFloat(2, 0, 100),
            'external_id'               => $this->faker->numberBetween(1000, 9999),

            // Création automatique d’un utilisateur associé
            'user_id'                   => User::factory(),

            // Référence fixe à une activité de groupe d’activités (id = 1)
            'activity_group_activity_id'=> 1,

            // Création et association d’un résultat d’activité
            'activity_result_id'        => ActivityResult::factory()->create()->id,
        ];
    }
}