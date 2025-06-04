<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    // Indique à Laravel sur quel modèle cette factory porte
    protected $model = User::class;

    public function definition()
    {
        return [
            'last_name'              => $this->faker->lastName(),
            'first_name'             => $this->faker->firstName(),
            'nickname'               => $this->faker->userName(),
            'is_active'              => $this->faker->boolean(100), // 100 % de chances d’être actif
            'user_type'              => $this->faker->randomElement(['admin','user']),
            'onboarding_done'        => $this->faker->boolean(50),
            'email'                  => $this->faker->unique()->safeEmail(),
            // si vous gérez un mot de passe :
            'password' => bcrypt('test123'), 
        ];
    }
}