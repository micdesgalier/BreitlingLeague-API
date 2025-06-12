<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    // Indique à Laravel sur quel modèle cette factory porte
    protected $model = User::class;

    public function definition()
    {
        // Listes fixes pour country et group
        $countries = ['Switzerland', 'France', 'Germany', 'Spain', 'Italy'];
        $groups    = ['Groupe A', 'Groupe B', 'Groupe C', 'Groupe D', 'Groupe E'];

        return [
            'last_name'       => $this->faker->lastName(),
            'first_name'      => $this->faker->firstName(),
            'nickname'        => $this->faker->userName(),
            'is_active'       => $this->faker->boolean(100), // 100 % de chances d’être actif
            'user_type'       => $this->faker->randomElement(['specialist', 'user']),
            'onboarding_done' => $this->faker->boolean(50),
            'email'           => $this->faker->unique()->safeEmail(),
            // Exemple de media séquentiel ou aléatoire : ici on laisse Faker générique
            'media'           => $this->faker->imageUrl(200, 200, 'people', true),
            'password'        => bcrypt('test123'),

            // Nouveaux champs group et country avec valeurs limitées
            'group'           => $this->faker->randomElement($groups),
            'country'         => $this->faker->randomElement($countries),

            // Si vous aviez d’autres champs comme boutique/pays, adaptables de la même façon :
            // 'boutique' => $this->faker->company(),
            // 'pays'     => $this->faker->randomElement(['Switzerland', 'France', ...]),
        ];
    }
}