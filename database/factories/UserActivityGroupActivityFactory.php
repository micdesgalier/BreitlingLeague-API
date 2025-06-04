<?php

namespace Database\Factories;

use App\Models\UserActivityGroupActivity;
use App\Models\User;
use App\Models\ActivityGroupActivity;
use App\Models\ActivityResult;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserActivityGroupActivityFactory extends Factory
{
    protected $model = UserActivityGroupActivity::class;

    public function definition()
    {
        $start = $this->faker->dateTimeBetween('-10 days', 'now');
        $end   = $this->faker->dateTimeBetween($start, '+5 days');

        return [
            'start_date'                 => $start,
            'end_date'                   => $end,
            'progression_score'          => $this->faker->randomFloat(2, 0, 100),
            'progression_score_percent'  => $this->faker->randomFloat(2, 0, 100),
            'external_id'                => $this->faker->numberBetween(1000, 9999),

            // Relations via factories (créent les entités associées automatiquement)
            'user_id'                    => User::factory(),
            'activity_group_activity_id' => 1,

            // Crée un ActivityResult, puis récupère son id pour activity_result_id
            'activity_result_id'         => ActivityResult::factory()->create()->id,
        ];
    }
}