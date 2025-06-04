<?php

namespace Database\Factories;

use App\Models\UserActivityGroupActivityResult;
use App\Models\User;
use App\Models\ActivityGroupActivity;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserActivityGroupActivityResultFactory extends Factory
{
    protected $model = UserActivityGroupActivityResult::class;

    public function definition()
    {
        $completed = $this->faker->boolean(80);

        return [
            'user_id'                     => User::factory(),
            'activity_group_activity_id'  => 1,
            'is_completed'                => $completed,
            'completion_date'             => $completed
                ? $this->faker->dateTimeBetween('-5 days', 'now')
                : null,
            'score'                       => $this->faker->randomFloat(2, 0, 100),
            'score_percent'               => $this->faker->randomFloat(2, 0, 100),
            'has_improved_score'          => $this->faker->boolean(50),
        ];
    }
}