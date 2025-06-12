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
     * Récupérer la liste complète des participants avec leurs relations.
     */
    public function index(): JsonResponse
    {
        $participants = QuizMatchParticipant::with(['quizMatch', 'user', 'answers'])->get();
        return response()->json($participants);
    }

    /**
     * Créer un nouveau participant dans un match.
     */
    public function store(StoreQuizMatchParticipantRequest $request): JsonResponse
    {
        $data = $request->validated();

        // Vérifier que le match existe avant d’ajouter un participant
        $quizMatch = QuizMatch::find($data['quiz_match_id']);
        if (! $quizMatch) {
            return response()->json(['error' => 'Match introuvable.'], 422);
        }

        // Empêcher la création d’un doublon de participant pour ce match
        $exists = QuizMatchParticipant::where('quiz_match_id', $data['quiz_match_id'])
            ->where('user_id', $data['user_id'])
            ->exists();
        if ($exists) {
            return response()->json(['error' => 'Ce participant est déjà associé à ce match.'], 422);
        }

        // Générer un UUID pour l’ID si nécessaire
        $data['id'] = (string) Str::uuid();

        // Création du participant
        $participant = QuizMatchParticipant::create($data);

        // Charger les relations pour la réponse JSON
        $participant->load(['quizMatch', 'user', 'answers']);

        return response()->json($participant, 201);
    }

    /**
     * Afficher un participant spécifique avec ses relations.
     */
    public function show(string $id): JsonResponse
    {
        $participant = QuizMatchParticipant::with(['quizMatch', 'user', 'answers'])
            ->findOrFail($id);

        return response()->json($participant);
    }

    /**
     * Mettre à jour un participant existant.
     */
    public function update(UpdateQuizMatchParticipantRequest $request, string $id): JsonResponse
    {
        $participant = QuizMatchParticipant::findOrFail($id);

        $data = $request->validated();

        // Mise à jour des données du participant
        $participant->update($data);

        // Recharger les relations pour la réponse à jour
        $participant->load(['quizMatch', 'user', 'answers']);
        return response()->json($participant);
    }

    /**
     * Supprimer un participant.
     */
    public function destroy(string $id): JsonResponse
    {
        $participant = QuizMatchParticipant::findOrFail($id);
        $participant->delete();

        // Réponse 204 No Content pour indiquer la suppression réussie
        return response()->json(null, 204);
    }
}