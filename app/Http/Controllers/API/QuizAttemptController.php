<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StartQuizRequest;
use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\User;
use App\Models\UserAttempt;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class QuizAttemptController extends Controller
{
    /**
     * Sélectionne un quiz, crée la tentative pour l’utilisateur donné, renvoie quiz_id et attempt_id.
     */
    public function startRandom(StartQuizRequest $request): JsonResponse
    {
        $user = User::find($request->input('user_id'));
        if (! $user) {
            return response()->json(['error' => 'Utilisateur introuvable'], 404);
        }

        $quiz = Quiz::inRandomOrder()->first();
        if (! $quiz) {
            return response()->json(['error' => 'Aucun quiz disponible'], 404);
        }

        $existing = UserAttempt::where('user_id', $user->id)
            ->where('quiz_code_id', $quiz->code_id)
            ->where('is_completed', false)
            ->first();

        if ($existing) {
            $attempt = $existing;

            // ⚠️ Assure la cohérence avec le quiz lié
            $quiz = Quiz::where('code_id', $existing->quiz_code_id)->first();
        } else {
            DB::transaction(function () use ($user, $quiz, &$attempt) {
                $attempt = UserAttempt::create([
                    'user_id'           => $user->id,
                    'quiz_code_id'      => $quiz->code_id,
                    'is_completed'      => false,
                    'start_date'        => now(),
                    'end_date'          => null,
                    'duration'          => 0,
                    'score'             => 0,
                    'initial_score'     => 0,
                    'combo_bonus_score' => 0,
                    'time_bonus_score'  => 0,
                ]);
            });
        }

        return response()->json([
            'quiz_id'    => $quiz?->code_id,
            'attempt_id' => $attempt->id,
            'start_date' => $attempt->start_date,
        ], 201);
    }

    public function endQuiz(string $quiz_id, Request $request): JsonResponse
    {
        $attemptId = $request->input('attempt_id');
        if (!$attemptId) {
            return response()->json(['error' => 'Le champ attempt_id est requis.'], 400);
        }

        $attempt = UserAttempt::find($attemptId);
        if (!$attempt) {
            return response()->json(['error' => 'Tentative introuvable.'], 404);
        }

        if ($attempt->quiz_code_id !== $quiz_id) {
            return response()->json(['error' => 'Tentative invalide pour ce quiz.'], 400);
        }

        if ($attempt->is_completed) {
            return response()->json(['error' => 'Cette tentative est déjà terminée.'], 400);
        }

        // Mise à jour
        $attempt->update([
            'is_completed' => true,
            'end_date'     => now(),
        ]);

        return response()->json($attempt);
    }

}