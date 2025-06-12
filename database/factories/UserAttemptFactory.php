<?php

namespace Database\Factories;

use App\Models\UserAttempt;
use App\Models\User;
use App\Models\Quiz;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserAttemptFactory extends Factory
{
    protected $model = UserAttempt::class;

    public function definition()
    {
        $start = $this->faker->dateTimeBetween('-10 days', 'now');
        $end = $this->faker->dateTimeBetween($start, 'now');

        return [
            'user_id'           => User::factory(),    // correspond au champ dans $fillable
            'quiz_code_id'      => Quiz::factory(),    // correspond au champ dans $fillable
            'start_date'        => $start,
            'end_date'          => $end,
            'is_completed'      => $this->faker->boolean(70),
            'duration'          => $this->faker->numberBetween(30, 3600), // durée en secondes par exemple
            'score'             => $this->faker->numberBetween(0, 20000),
            'initial_score'     => $this->faker->numberBetween(0, 100),
            'combo_bonus_score' => $this->faker->numberBetween(0, 50),
            'time_bonus_score'  => $this->faker->numberBetween(0, 50),
        ];
    }
}