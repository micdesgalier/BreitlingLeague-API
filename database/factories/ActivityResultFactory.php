<?php

namespace Database\Factories;

use App\Models\ActivityResult;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActivityResultFactory extends Factory
{
    protected $model = ActivityResult::class;

    public function definition(): array
    {
        return [
            'duration' => $this->faker->numberBetween(30, 3600), // durée réaliste en secondes (ex : 30s à 1h)
        ];
    }
}