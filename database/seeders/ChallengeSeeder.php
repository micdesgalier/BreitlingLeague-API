<?php 

namespace Database\Seeders;

use App\Models\Challenge;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ChallengeSeeder extends Seeder
{
    /**
     * Exécute le seed pour insérer des challenges en base.
     *
     * Crée 10 challenges avec un titre simple et un contenu aléatoire.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            Challenge::create([
                'titre'   => "Challenge $i",
                'contenu' => "Contenu du challenge $i : " . Str::random(50),
            ]);
        }
    }
}