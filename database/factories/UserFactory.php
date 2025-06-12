<?php 

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * Modèle associé à cette factory.
     *
     * @var class-string<\App\Models\User>
     */
    protected $model = User::class;

    /**
     * Génère des données factices pour un utilisateur.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // Listes fixes de pays et groupes pour limiter les valeurs possibles
        $countries = ['Switzerland', 'France', 'Germany', 'Spain', 'Italy'];
        $groups    = ['Groupe A', 'Groupe B', 'Groupe C', 'Groupe D', 'Groupe E'];

        return [
            'last_name'       => $this->faker->lastName(),
            'first_name'      => $this->faker->firstName(),
            'nickname'        => $this->faker->userName(),

            // Toujours actif dans ce cas (100% de chances)
            'is_active'       => $this->faker->boolean(100),

            // Type d'utilisateur : spécialiste ou utilisateur standard
            'user_type'       => $this->faker->randomElement(['specialist', 'user']),

            'onboarding_done' => $this->faker->boolean(50),

            'email'           => $this->faker->unique()->safeEmail(),

            // Image générique de profil (dimensions 200x200, catégorie people)
            'media'           => $this->faker->imageUrl(200, 200, 'people', true),

            // Mot de passe hashé par défaut (valeur test)
            'password'        => bcrypt('test123'),

            // Affectation aléatoire d’un groupe et d’un pays parmi les listes fixes
            'group'           => $this->faker->randomElement($groups),
            'country'         => $this->faker->randomElement($countries),
        ];
    }
}