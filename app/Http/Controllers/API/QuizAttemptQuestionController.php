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
     * Point d'entrée pour enregistrer la réponse d'un utilisateur à une question de quiz.
     * Valide la tentative, puis délègue l'enregistrement à la méthode store().
     *
     * @param  Quiz  $quiz                      Le quiz concerné
     * @param  Question  $question              La question concernée
     * @param  StoreQuizAnswerRequest  $request Requête contenant l'ID de tentative et les choix sélectionnés
     * @return JsonResponse
     */
    public function storeOrStart(
        Quiz $quiz,
        Question $question,
        StoreQuizAnswerRequest $request
    ): JsonResponse {
        $attemptId = $request->input('attempt_id');

        if (! $attemptId) {
            return response()->json(['error' => 'Le champ attempt_id est requis.'], 400);
        }

        $attempt = UserAttempt::find($attemptId);

        if (! $attempt) {
            return response()->json(['error' => 'Tentative introuvable.'], 404);
        }

        if ($attempt->is_completed) {
            return response()->json(['error' => 'Cette tentative est déjà terminée.'], 400);
        }

        if ($attempt->quiz_code_id !== $quiz->code_id) {
            return response()->json(['error' => 'Tentative invalide pour ce quiz.'], 400);
        }

        try {
            return $this->store($quiz, $attempt, $question, $request);
        } catch (\Throwable $e) {
            \Log::error('Erreur lors de l\'enregistrement de la réponse : ' . $e->getMessage());
            \Log::error('Trace : ' . $e->getTraceAsString());

            return response()->json([
                'error'   => 'Impossible d\'enregistrer la réponse.',
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ], 500);
        }
    }

    /**
     * Enregistre la réponse à une question pour une tentative utilisateur donnée.
     * Calcule si la réponse est correcte et met à jour le score de la tentative.
     *
     * @param  Quiz  $quiz
     * @param  UserAttempt  $attempt
     * @param  Question  $question
     * @param  StoreQuizAnswerRequest  $request
     * @return JsonResponse
     */
    public function store(
        Quiz $quiz,
        UserAttempt $attempt,
        Question $question,
        StoreQuizAnswerRequest $request
    ): JsonResponse {
        // Vérification finale de la cohérence (sécurité supplémentaire)
        abort_unless($attempt->quiz_code_id === $quiz->code_id, 404);

        // Création ou récupération d’un enregistrement de réponse utilisateur à cette question
        $uaq = $attempt->userAttemptQuestions()->firstOrCreate(
            ['question_code_id' => $question->code_id],
            [
                'order'             => $request->input('order', 0),
                'is_correct'        => false,
                'score'             => 0,
                'combo_bonus_value' => 0,
            ]
        );

        // Suppression des choix précédemment enregistrés pour cette question
        $uaq->userAttemptChoices()->delete();

        $selected     = $request->input('selected_choices', []);
        $isAllCorrect = true;

        // Parcours des choix sélectionnés pour les enregistrer et vérifier leur validité
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

        // Détermination du score à attribuer pour cette réponse
        $points = $isAllCorrect
            ? ($quiz->correct_choice_points ?? 1)
            : ($quiz->wrong_choice_points   ?? 0);

        // Mise à jour de l’état de la réponse à la question
        $uaq->update([
            'is_correct' => $isAllCorrect,
            'score'      => $points,
        ]);

        // Mise à jour du score total de la tentative utilisateur
        $totalScore = $attempt->userAttemptQuestions()->sum('score');
        $attempt->update(['score' => $totalScore]);

        // Retourne les informations sur la réponse enregistrée
        return response()->json([
            'attempt_id' => $attempt->id,
            'question'   => $question->code_id,
            'is_correct' => $isAllCorrect,
            'score'      => $points,
        ]);
    }
}