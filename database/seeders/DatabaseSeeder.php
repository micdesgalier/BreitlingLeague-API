<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{
    User,
    Quiz,
    Stage,
    Pool,
    Question,
    Choice,
    PoolQuestion,
    UserAttempt,
    UserAttemptQuestion,
    UserAttemptChoice
};
use Database\Seeders\ChallengeSeeder;
use Database\Seeders\JsonQuestionSeeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // --- Partie existante : import JSON, challenges, users, quiz/stage/pool/question linkage
        $this->call(JsonQuestionSeeder::class);
        $this->call(ChallengeSeeder::class);

        // 1) Créer le user spécifique en premier : la factory va générer l’ID 1 puisque la table est vide.
        User::factory()->create([
            'nickname' => 'BreitlingSpecialistTest',
            'email'    => 'breitling.specialist@example.com', 
            // autres champs spécifiques si besoin, sinon la factory génère last_name, first_name aléatoires
            'user_type'=> 'specialist',
            'media' => "/assets/images/avatar/1avatar.webp",
            'password' => bcrypt('test123'),
            // ...
        ]);

        for ($i = 2; $i <= 10; $i++) {
            User::factory()->create([
                'media' => "/assets/images/avatar/{$i}avatar.webp",
            ]);
        }

        $allQuestionCodes = Question::pluck('code_id')->toArray();

        Quiz::factory()->count(2)->create()->each(function ($quiz) use ($allQuestionCodes) {
            $nbStages = rand(2, 4);
            Stage::factory()->count($nbStages)->create([
                'quiz_code_id' => $quiz->code_id
            ])->each(function ($stage) use ($allQuestionCodes) {
                $nbPools = rand(1, 3);
                Pool::factory()->count($nbPools)->create([
                    'stage_code_id' => $stage->code_id
                ])->each(function ($pool) use ($allQuestionCodes) {
                    shuffle($allQuestionCodes);
                    $selected = array_slice($allQuestionCodes, 0, 3);

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

        // --- NOUVEAU : lier User → UserAttempt → UserAttemptQuestion → UserAttemptChoice

        // 1) récupérer en mémoire tous les users et quizzes
        $users  = User::all();
        $quizzes = Quiz::with('stages.pools.questions.choices')->get();

        foreach ($users as $user) {
            // chaque user peut faire 1 à 3 tentatives
            $attemptsCount = rand(1, 3);
            for ($i = 0; $i < $attemptsCount; $i++) {
                // 2) choisir un quiz au hasard
                $quiz = $quizzes->random();

                // 3) créer la tentative
                $ua = UserAttempt::create([
                    'user_id'       => $user->id,
                    'quiz_code_id'  => $quiz->code_id,
                    'start_date'    => now()->subMinutes(rand(10, 100)),
                    'end_date'      => now(),
                    'is_completed'  => true,
                    'duration'      => rand(60, 600),
                    'score'         => 0,    // on recalculera plus bas
                    'initial_score'=> 0,
                    'combo_bonus_score'=> 0,
                    'time_bonus_score' => 0,
                ]);

                $totalScore = 0;

                // 4) itérer toutes les questions du quiz en respectant l'ordre stage→pool→pivot.order
                foreach ($quiz->stages as $stage) {
                    foreach ($stage->pools as $pool) {
                        foreach ($pool->questions as $question) {
                            // créer l'entrée UserAttemptQuestion
                            $uaq = UserAttemptQuestion::create([
                                'user_attempt_id'   => $ua->id,
                                'question_code_id'  => $question->code_id,
                                'order'             => $question->pivot->order,
                                'is_correct'        => false,  // maj après choix
                                'score'             => 0,
                                'combo_bonus_value' => 0,
                            ]);

                            // choisir un choix au hasard parmi les choices
                            $choice = $question->choices->random();
                            $isCorrect = $choice->is_correct ? true : false;
                            $points    = $isCorrect 
                                         ? $quiz->correct_choice_points 
                                         : $quiz->wrong_choice_points;

                            // créer UserAttemptChoice
                            UserAttemptChoice::create([
                                'user_attempt_question_id' => $uaq->id,
                                'choice_code_id'           => $choice->code_id,
                                'is_selected'              => true,
                                'is_correct'               => $isCorrect,
                            ]);

                            // mettre à jour questionAttempt
                            $uaq->update([
                                'is_correct' => $isCorrect,
                                'score'      => $points,
                            ]);

                            $totalScore += $points;
                        }
                    }
                }

                // 5) mettre à jour le score total de la tentative
                $ua->update(['score' => $totalScore]);
            }
        }

        // … tu peux ensuite appeler d’autres seeders si besoin …
    }
}