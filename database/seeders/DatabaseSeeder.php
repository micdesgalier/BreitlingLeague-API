<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{
    Quiz,
    Stage,
    Pool,
    Question,
    Choice,
    PoolQuestion
};
use Database\Seeders\JsonQuestionSeeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1) Import JSON pour peaufiner questions et choices
        $this->call(JsonQuestionSeeder::class);

        $this->call(ChallengeSeeder::class);
        
        User::factory()->count(10)->create();

        // Récupérer en mémoire l’ensemble des questions (code_id)
        $allQuestionCodes = Question::pluck('code_id')->toArray();

        // 2) Créer des Quizzes
        //    Ici on crée 2 quizzes pour l’exemple ; adaptez selon vos besoins.
        Quiz::factory()->count(2)->create()->each(function ($quiz) use ($allQuestionCodes) {
            // 3) Pour chacun, créer 2 à 4 Stages
            $nbStages = rand(2, 4);
            Stage::factory()->count($nbStages)->create([
                'quiz_code_id' => $quiz->code_id
            ])->each(function ($stage) use ($allQuestionCodes) {
                // 4) Pour chaque stage, créer 1 à 3 Pools
                $nbPools = rand(1, 3);
                Pool::factory()->count($nbPools)->create([
                    'stage_code_id' => $stage->code_id
                ])->each(function ($pool) use ($allQuestionCodes) {
                    // 5) Pour chaque pool, lier aléatoirement 3 questions via la pivot
                    shuffle($allQuestionCodes);
                    $selected = array_slice($allQuestionCodes, 0, 3); // prend 3 questions au hasard

                    $order = 1;
                    foreach ($selected as $qCode) {
                        PoolQuestion::create([
                            'pool_code_id'     => $pool->code_id,
                            'question_code_id' => $qCode,
                            'order'            => $order++,
                        ]);
                    }
                });
            });
        });

        // À ce stade, chaque Question (venue du JSON) appartient à un Pool,  
        // chaque Pool appartient à un Stage, et chaque Stage appartient à un Quiz.

        // (Optionnel) 6) Si vous souhaitez lier Choice à autre chose, ou lancer d’autres seeders, faites-le ici.
    }
}