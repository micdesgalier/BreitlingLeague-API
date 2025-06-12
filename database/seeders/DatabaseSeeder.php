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
        // Import des questions JSON et création des challenges
        $this->call(JsonQuestionSeeder::class);
        $this->call(ChallengeSeeder::class);

        // Création d’un utilisateur spécifique avec des données fixes
        User::factory()->create([
            'nickname' => 'BreitlingSpecialistTest',
            'email'    => 'breitling.specialist@example.com',
            'user_type'=> 'specialist',
            'media'    => "/assets/images/avatar/1avatar.webp",
            'password' => bcrypt('test123'),
        ]);

        // Création de 31 autres utilisateurs avec avatars spécifiques
        for ($i = 2; $i <= 32; $i++) {
            User::factory()->create([
                'media' => "/assets/images/avatar/{$i}avatar.webp",
            ]);
        }

        // Récupération des codes de toutes les questions existantes
        $allQuestionCodes = Question::pluck('code_id')->toArray();

        // Création de 2 quiz avec leurs stages, pools et questions associées
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

        // Récupération en mémoire des utilisateurs et des quiz avec relations imbriquées
        $users  = User::all();
        $quizzes = Quiz::with('stages.pools.questions.choices')->get();

        // Pour chaque utilisateur, création de 1 à 3 tentatives sur des quiz aléatoires
        foreach ($users as $user) {
            $attemptsCount = rand(1, 3);
            for ($i = 0; $i < $attemptsCount; $i++) {
                $quiz = $quizzes->random();

                // Création d’une tentative d’utilisateur sur un quiz donné
                $ua = UserAttempt::create([
                    'user_id'       => $user->id,
                    'quiz_code_id'  => $quiz->code_id,
                    'start_date'    => now()->subMinutes(rand(10, 100)),
                    'end_date'      => now(),
                    'is_completed'  => true,
                    'duration'      => rand(60, 600),
                    'score'         => 0, // sera recalculé ensuite
                    'initial_score' => 0,
                    'combo_bonus_score' => 0,
                    'time_bonus_score' => 0,
                ]);

                $totalScore = 0;

                // Parcours de toutes les questions du quiz dans l’ordre stage→pool→ordre pivot
                foreach ($quiz->stages as $stage) {
                    foreach ($stage->pools as $pool) {
                        foreach ($pool->questions as $question) {
                            // Création d’une entrée UserAttemptQuestion liée à la tentative
                            $uaq = UserAttemptQuestion::create([
                                'user_attempt_id'  => $ua->id,
                                'question_code_id' => $question->code_id,
                                'order'            => $question->pivot->order,
                                'is_correct'       => false, // sera mis à jour après choix
                                'score'            => 0,
                                'combo_bonus_value'=> 0,
                            ]);

                            // Choix aléatoire parmi les choix disponibles de la question
                            $choice = $question->choices->random();
                            $isCorrect = $choice->is_correct;
                            $points = $isCorrect 
                                ? $quiz->correct_choice_points 
                                : $quiz->wrong_choice_points;

                            // Enregistrement du choix fait par l’utilisateur
                            UserAttemptChoice::create([
                                'user_attempt_question_id' => $uaq->id,
                                'choice_code_id'           => $choice->code_id,
                                'is_selected'              => true,
                                'is_correct'               => $isCorrect,
                            ]);

                            // Mise à jour de la question dans la tentative avec le résultat
                            $uaq->update([
                                'is_correct' => $isCorrect,
                                'score'      => $points,
                            ]);

                            $totalScore += $points;
                        }
                    }
                }

                // Mise à jour du score total de la tentative après traitement des questions
                $ua->update(['score' => $totalScore]);
            }
        }

        // Possibilité d’appeler d’autres seeders ici si besoin
    }
}