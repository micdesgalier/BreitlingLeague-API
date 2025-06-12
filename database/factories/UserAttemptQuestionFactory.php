<?php

namespace Database\Factories;

use App\Models\UserAttemptQuestion;
use App\Models\UserAttempt;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserAttemptQuestionFactory extends Factory
{
    protected $model = UserAttemptQuestion::class;

    public function definition()
    {
        return [
            'user_attempt_id'   => UserAttempt::factory(),   // correspond au champ dans $fillable
            'order'             => $this->faker->numberBetween(1, 20),  // ordre de la question dans la tentative
            'is_correct'        => $this->faker->boolean(50),
            'score'             => $this->faker->randomElement([0, 1000]),
            'question_code_id'  => Question::factory(),      // correspond au champ dans $fillable
            'combo_bonus_value' => $this->faker->numberBetween(0, 50),
        ];
    }
}