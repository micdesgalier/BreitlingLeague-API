<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuizMatchParticipantRequest;
use App\Http\Requests\UpdateQuizMatchParticipantRequest;
use App\Models\QuizMatchParticipant;
use App\Models\QuizMatch;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class QuizMatchParticipantController extends Controller
{
    /**
     * Display a listing of participants.
     */
    public function index(): JsonResponse
    {
        $participants = QuizMatchParticipant::with(['quizMatch', 'user', 'answers'])->get();
        return response()->json($participants);
    }

    /**
     * Store a newly created participant in storage.
     */
    public function store(StoreQuizMatchParticipantRequest $request): JsonResponse
    {
        $data = $request->validated();

        // Vérifier que le quiz_match existe
        $quizMatch = QuizMatch::find($data['quiz_match_id']);
        if (! $quizMatch) {
            return response()->json(['error' => 'Match introuvable.'], 422);
        }

        // Vérifier qu’on n’a pas déjà ce participant pour ce match
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
    public function update(UpdateQuizMatchParticipantRequest $request, string $id): JsonResponse
    {
        $participant = QuizMatchParticipant::findOrFail($id);

        $data = $request->validated();

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