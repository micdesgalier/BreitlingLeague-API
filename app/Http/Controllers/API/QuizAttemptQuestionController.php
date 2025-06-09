<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuizAnswerRequest;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\UserAttempt;
use Illuminate\Http\JsonResponse;

class QuizAttemptQuestionController extends Controller
{
    /**
     * Fusionne création de l'UserAttempt et enregistrement de la réponse.
     */
    public function storeOrStart(
        Quiz $quiz,
        Question $question,
        StoreQuizAnswerRequest $request
    ): JsonResponse {
        // On simule un utilisateur en local
        $user = \App\Models\User::inRandomOrder()->first();

        // Crée ou récupère la tentative non complétée
        $attempt = UserAttempt::firstOrCreate(
            [
                'user_id'      => $user->id,
                'quiz_code_id' => $quiz->code_id,
                'is_completed' => false,
            ],
            [
                'start_date'         => now(),
                'end_date'           => null,
                'duration'           => 0,
                'score'              => 0,
                'initial_score'      => 0,
                'combo_bonus_score'  => 0,
                'time_bonus_score'   => 0,
            ]
        );

        // Délègue à store() et renvoie toujours un JsonResponse
        try {
            return $this->store($quiz, $attempt, $question, $request);
        } catch (\Throwable $e) {
            \Log::error('Quiz answer error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'error'   => 'Impossible d\'enregistrer la réponse.',
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ], 500);
        }
    }

    /**
     * Enregistre la réponse de l'utilisateur à une question d'un quiz.
     */
    public function store(
        Quiz $quiz,
        UserAttempt $attempt,
        Question $question,
        StoreQuizAnswerRequest $request
    ): JsonResponse {
        // 1) Vérifier la cohérence
        abort_unless($attempt->quiz_code_id === $quiz->code_id, 404);

        // 2) Créer ou récupérer UserAttemptQuestion
        $uaq = $attempt->userAttemptQuestions()->firstOrCreate(
            ['question_code_id' => $question->code_id],
            [
                'order'             => $request->input('order', 0),
                'is_correct'        => false,
                'score'             => 0,
                'combo_bonus_value' => 0,
            ]
        );

        // 3) Enregistrer les choix
        $uaq->userAttemptChoices()->delete();
        $selected     = $request->input('selected_choices', []);
        $isAllCorrect = true;

        foreach ($selected as $choiceCode) {
            $choice = $question->choices()->where('code_id', $choiceCode)->first();
            if (! $choice) {
                continue;
            }
            if (! $choice->is_correct) {
                $isAllCorrect = false;
            }
            $uaq->userAttemptChoices()->create([
                'choice_code_id' => $choice->code_id,
                'is_selected'    => true,
                'is_correct'     => $choice->is_correct,
            ]);
        }

        // 4) Calcul du score
        $points = $isAllCorrect
            ? ($quiz->correct_choice_points ?? 1)
            : ($quiz->wrong_choice_points   ?? 0);

        $uaq->update([
            'is_correct' => $isAllCorrect,
            'score'      => $points,
        ]);

        // 5) Réponse JSON
        return response()->json([
            'attempt_id' => $attempt->id,
            'question'   => $question->code_id,
            'is_correct' => $isAllCorrect,
            'score'      => $points,
        ]);
    }
}