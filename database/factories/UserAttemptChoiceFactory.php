<?php

namespace Database\Factories;

use App\Models\UserAttemptChoice;
use App\Models\UserAttemptQuestion;
use App\Models\Choice;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserAttemptChoiceFactory extends Factory
{
    protected $model = UserAttemptChoice::class;

    public function definition()
    {
        return [
            'user_attempt_question_id' => UserAttemptQuestion::factory(), // relation correcte
            'choice_code_id'           => Choice::factory(),              // relation correcte

            'is_selected'              => $this->faker->boolean(80),
            'is_correct'               => $this->faker->boolean(50),
        ];
    }
}