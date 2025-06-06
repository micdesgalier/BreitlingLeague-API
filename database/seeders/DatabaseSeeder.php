<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{
    Challenge,
    User,
    Quiz,
    Stage,
    Pool,
    Question,
    Choice,
    UserAttempt,
    UserAttemptQuestion,
    UserAttemptChoice,
    UserActivityGroupActivity,
    ActivityResult,
    QuizActivityResult,
    UserActivityGroupActivityResult,
    PoolQuestion
};
use Database\Seeders\JsonQuestionSeeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1) Créer quelques utilisateurs, quizzes, stages et pools avec Faker
        User::factory()->count(10)->create();
        Quiz::factory()->count(5)->create();
        Stage::factory()->count(5)->create();
        Pool::factory()->count(5)->create();

        // 2) Import JSON pour peupler questions et choices (unique)
        $this->call(JsonQuestionSeeder::class);

        // 3) Associer Pool ↔ Question dans la table pivot pool_questions
        $allPools         = Pool::all();
        $allQuestionCodes = Question::pluck('code_id')->toArray();

        foreach ($allPools as $pool) {
            shuffle($allQuestionCodes);
            $subset = array_slice($allQuestionCodes, 0, 3); // par ex. 3 questions par pool
            $order = 1;
            foreach ($subset as $qCode) {
                DB::table('pool_questions')->insert([
                    'pool_code_id'     => $pool->code_id,
                    'question_code_id' => $qCode,
                    'order'            => $order++,
                ]);
            }
        }

        // 4) Générer UserAttempt, UserAttemptQuestion, UserAttemptChoice via Faker
        $questionCodes = Question::pluck('code_id')->toArray();
        $choicesByQuestion = Choice::all()->groupBy('question_code_id');

        UserAttempt::factory()->count(20)->create()->each(function ($ua) use ($questionCodes, $choicesByQuestion) {
            $numQ = rand(2, 5);
            for ($i = 0; $i < $numQ; $i++) {
                $qCode = $questionCodes[array_rand($questionCodes)];
                $uatQ  = UserAttemptQuestion::factory()->create([
                    'user_attempt_id'  => $ua->id,
                    'question_code_id' => $qCode,
                ]);
                if (isset($choicesByQuestion[$qCode])) {
                    $choicesList = $choicesByQuestion[$qCode]->pluck('code_id')->toArray();
                    $picked      = $choicesList[array_rand($choicesList)];
                    UserAttemptChoice::factory()->create([
                        'user_attempt_question_id' => $uatQ->id,
                        'choice_code_id'           => $picked,
                    ]);
                }
            }
        });

        // 5) Autres seeders rapides
        UserActivityGroupActivity::factory()->count(10)->create();
        ActivityResult::factory()->count(10)->create();
        QuizActivityResult::factory()->count(10)->create();
        UserActivityGroupActivityResult::factory()->count(10)->create();

        // 6) ChallengeSeeder si nécessaire
        $this->call(ChallengeSeeder::class);
    }
}