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

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // --- Créer un nombre réduit de données pour tests rapides ---

        User::factory()->count(10)->create();
        Quiz::factory()->count(5)->create();
        Stage::factory()->count(5)->create();
        Pool::factory()->count(5)->create();

        // Créer Questions et Choices séparément pour éviter duplications
        Question::factory()->count(20)->create();
        Choice::factory()->count(50)->create();

        // Associer Pool ↔ Question via pivot (PoolQuestion)
        PoolQuestion::factory()->count(20)->create();

        // Précharger en mémoire les questions et choix pour éviter requêtes répétées
        $questions = Question::all();
        $questionIds = $questions->pluck('code_id')->toArray();

        $choicesGrouped = Choice::all()->groupBy('question_code_id');

        // Générer UserAttempts avec UserAttemptQuestions et UserAttemptChoices
        UserAttempt::factory()->count(20)->create()->each(function ($ua) use ($questionIds, $choicesGrouped) {
            $numQuestions = rand(2, 5);

            for ($i = 0; $i < $numQuestions; $i++) {
                $questionCodeId = $questionIds[array_rand($questionIds)];

                $userAttemptQuestion = UserAttemptQuestion::factory()->create([
                    'user_attempt_id'  => $ua->id,
                    'question_code_id' => $questionCodeId,
                ]);

                if (isset($choicesGrouped[$questionCodeId])) {
                    $choicesForQuestion = $choicesGrouped[$questionCodeId]->pluck('code_id')->toArray();
                    $choiceCodeId = $choicesForQuestion[array_rand($choicesForQuestion)];

                    UserAttemptChoice::factory()->create([
                        'user_attempt_question_id' => $userAttemptQuestion->id,
                        'choice_code_id'           => $choiceCodeId,
                    ]);
                }
            }
        });

        // Autres modèles avec un petit nombre d'exemples
        UserActivityGroupActivity::factory()->count(10)->create();
        ActivityResult::factory()->count(10)->create();
        QuizActivityResult::factory()->count(10)->create();
        UserActivityGroupActivityResult::factory()->count(10)->create();

        $this->call([ChallengeSeeder::class]);
    }
}