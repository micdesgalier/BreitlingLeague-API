<?php

namespace Database\Seeders;

use App\Models\Challenge;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ChallengeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            Challenge::create([
                'titre' => "Challenge $i",
                'contenu' => "Contenu du challenge $i : " . Str::random(50),
            ]);
        }
    }
}