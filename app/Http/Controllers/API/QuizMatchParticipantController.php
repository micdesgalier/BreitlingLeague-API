<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\QuizMatchParticipant;
use App\Models\QuizMatch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class QuizMatchParticipantController extends Controller
{
    /**
     * Display a listing of participants.
     */
    public function index(): JsonResponse
    {
        // Charger les relations quizMatch et user si besoin
        $participants = QuizMatchParticipant::with(['quizMatch', 'user', 'answers'])->get();
        return response()->json($participants);
    }

    /**
     * Store a newly created participant in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'quiz_match_id'    => 'required|string|exists:quiz_matches,id',
            'user_id'          => 'required|integer|exists:users,id',
            'invitation_state' => 'required|string',
            'last_answer_date' => 'nullable|date',
            'score'            => 'nullable|integer',
            'points_bet'       => 'nullable|integer',
            'is_winner'        => 'nullable|boolean',
        ]);

        // Vérifier que le quiz_match existe
        $quizMatch = QuizMatch::find($data['quiz_match_id']);
        if (! $quizMatch) {
            return response()->json(['error' => 'Match introuvable.'], 422);
        }

        // Optionnel : vérifier qu’on n’a pas déjà ce participant pour ce match
        $exists = QuizMatchParticipant::where('quiz_match_id', $data['quiz_match_id'])
            ->where('user_id', $data['user_id'])
            ->exists();
        if ($exists) {
            return response()->json(['error' => 'Ce participant est déjà associé à ce match.'], 422);
        }

        // Générer un ID UUID si la PK n’est pas auto-incrément
        $data['id'] = (string) Str::uuid();

        $participant = QuizMatchParticipant::create($data);

        // Charger relations pour la réponse
        $participant->load(['quizMatch', 'user', 'answers']);

        return response()->json($participant, 201);
    }

    /**
     * Display the specified participant.
     */
    public function show(string $id): JsonResponse
    {
        $participant = QuizMatchParticipant::with(['quizMatch', 'user', 'answers'])
            ->findOrFail($id);

        return response()->json($participant);
    }

    /**
     * Update the specified participant in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $participant = QuizMatchParticipant::findOrFail($id);

        $data = $request->validate([
            // On n'autorise pas à changer quiz_match_id ou user_id par défaut
            'invitation_state' => 'sometimes|required|string',
            'last_answer_date' => 'sometimes|nullable|date',
            'score'            => 'sometimes|integer',
            'points_bet'       => 'sometimes|integer',
            'is_winner'        => 'sometimes|boolean',
        ]);

        $participant->update($data);

        $participant->load(['quizMatch', 'user', 'answers']);
        return response()->json($participant);
    }

    /**
     * Remove the specified participant from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $participant = QuizMatchParticipant::findOrFail($id);
        $participant->delete();
        return response()->json(null, 204);
    }
}