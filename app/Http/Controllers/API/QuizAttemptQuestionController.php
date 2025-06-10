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
     * Enregistre la réponse de l'utilisateur à une question d'un quiz.
     * Vérifie l'existence et la cohérence de la tentative (attempt_id) passée en body.
     */
    public function storeOrStart(
        Quiz $quiz,
        Question $question,
        StoreQuizAnswerRequest $request
    ): JsonResponse {
        // Récupérer attempt_id depuis la requête
        $attemptId = $request->input('attempt_id');
        if (! $attemptId) {
            return response()->json(['error' => 'Le champ attempt_id est requis.'], 400);
        }

        // Récupérer la tentative
        $attempt = UserAttempt::find($attemptId);
        if (! $attempt) {
            return response()->json(['error' => 'Tentative introuvable.'], 404);
        }

        // Vérifier la cohérence : tentative non complétée et correspond bien au quiz
        if ($attempt->is_completed) {
            return response()->json(['error' => 'Cette tentative est déjà terminée.'], 400);
        }
        if ($attempt->quiz_code_id !== $quiz->code_id) {
            return response()->json(['error' => 'Tentative invalide pour ce quiz.'], 400);
        }

        // Déléguer à store() et renvoyer toujours un JsonResponse
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
     * 
     * @param Quiz $quiz
     * @param UserAttempt $attempt  // reçu depuis storeOrStart, on ne crée plus ici
     * @param Question $question
     * @param StoreQuizAnswerRequest $request
     * @return JsonResponse
     */
    public function store(
        Quiz $quiz,
        UserAttempt $attempt,
        Question $question,
        StoreQuizAnswerRequest $request
    ): JsonResponse {
        // 1) Vérifier la cohérence (déjà faite dans storeOrStart, mais on peut double-check)
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

        // 3) Enregistrer les choix : on supprime d'abord d'éventuelles réponses précédentes
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

        $totalScore = $attempt->userAttemptQuestions()->sum('score');
        $attempt->update(['score' => $totalScore]);

        // 5) Réponse JSON
        return response()->json([
            'attempt_id' => $attempt->id,
            'question'   => $question->code_id,
            'is_correct' => $isAllCorrect,
            'score'      => $points,
        ]);
    }
}