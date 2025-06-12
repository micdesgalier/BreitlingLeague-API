<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuizMatchAnswerRequest;
use App\Http\Requests\UpdateQuizMatchAnswerRequest;
use App\Models\QuizMatchAnswer;
use App\Models\QuizMatch;
use App\Models\QuizMatchParticipant;
use App\Models\QuizMatchQuestion;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class QuizMatchAnswerController extends Controller
{
    /**
     * Retourne la liste complète des réponses aux quiz match,
     * avec leurs relations associées (match, participant, question, choix).
     */
    public function index(): JsonResponse
    {
        $answers = QuizMatchAnswer::with([
            'quizMatch',
            'participant',
            'question',
            'choice'
        ])->get();

        return response()->json($answers);
    }

    /**
     * Crée une nouvelle réponse pour un quiz match.
     * Vérifie que la question et le participant appartiennent bien au même match.
     */
    public function store(StoreQuizMatchAnswerRequest $request): JsonResponse
    {
        $data = $request->validated();

        // Vérification que la question appartient au match indiqué
        $question = QuizMatchQuestion::find($data['quiz_match_question_id']);
        if (!$question || $question->quiz_match_id !== $data['quiz_match_id']) {
            return response()->json([
                'error' => 'La question n’appartient pas au match indiqué.'
            ], 422);
        }

        // Vérification que le participant appartient au match indiqué
        $participant = QuizMatchParticipant::find($data['quiz_match_participant_id']);
        if (!$participant || $participant->quiz_match_id !== $data['quiz_match_id']) {
            return response()->json([
                'error' => 'Le participant n’appartient pas au match indiqué.'
            ], 422);
        }

        // Génère un UUID comme identifiant si la clé primaire n’est pas auto-incrémentée
        $data['id'] = (string) Str::uuid();

        // Création de la réponse et chargement des relations pour la réponse JSON
        $answer = QuizMatchAnswer::create($data);
        $answer->load(['quizMatch', 'participant', 'question', 'choice']);

        return response()->json($answer, 201);
    }

    /**
     * Affiche une réponse spécifique identifiée par son ID,
     * avec ses relations associées chargées.
     */
    public function show(string $id): JsonResponse
    {
        $answer = QuizMatchAnswer::with([
            'quizMatch',
            'participant',
            'question',
            'choice'
        ])->findOrFail($id);

        return response()->json($answer);
    }

    /**
     * Met à jour une réponse existante à partir des données validées.
     */
    public function update(UpdateQuizMatchAnswerRequest $request, string $id): JsonResponse
    {
        $answer = QuizMatchAnswer::findOrFail($id);

        $data = $request->validated();

        $answer->update($data);

        // Recharge les relations pour la réponse mise à jour
        $answer->load(['quizMatch', 'participant', 'question', 'choice']);

        return response()->json($answer);
    }

    /**
     * Supprime une réponse identifiée par son ID.
     */
    public function destroy(string $id): JsonResponse
    {
        $answer = QuizMatchAnswer::findOrFail($id);
        $answer->delete();

        return response()->json(null, 204);
    }
}