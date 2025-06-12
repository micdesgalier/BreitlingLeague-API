<?php 

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuizMatchQuestionRequest;
use App\Http\Requests\UpdateQuizMatchQuestionRequest;
use App\Models\QuizMatchQuestion;
use App\Models\QuizMatch;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class QuizMatchQuestionController extends Controller
{
    /**
     * Récupérer la liste de toutes les questions associées aux matchs de quiz,
     * avec leurs relations (match, question, réponses).
     */
    public function index(): JsonResponse
    {
        $items = QuizMatchQuestion::with(['quizMatch', 'question', 'answers'])->get();
        return response()->json($items);
    }

    /**
     * Créer une nouvelle question associée à un match de quiz.
     * Valide que le match existe et que la question n'est pas déjà liée à ce match.
     * Génère un UUID pour l'identifiant de la question.
     */
    public function store(StoreQuizMatchQuestionRequest $request): JsonResponse
    {
        $data = $request->validated();

        // Vérifier que le match de quiz existe
        $quizMatch = QuizMatch::find($data['quiz_match_id']);
        if (! $quizMatch) {
            return response()->json(['error' => 'QuizMatch introuvable.'], 422);
        }

        // Vérifier l'unicité de la question pour ce match
        $exists = QuizMatchQuestion::where('quiz_match_id', $data['quiz_match_id'])
            ->where('question_code_id', $data['question_code_id'])
            ->exists();
        if ($exists) {
            return response()->json(['error' => 'Cette question est déjà associée à ce match.'], 422);
        }

        // Générer un UUID pour la clé primaire
        $data['id'] = (string) Str::uuid();

        // Créer la nouvelle question liée au match
        $item = QuizMatchQuestion::create($data);

        // Charger les relations pour la réponse
        $item->load(['quizMatch', 'question', 'answers']);

        return response()->json($item, 201);
    }

    /**
     * Afficher une question spécifique d'un match de quiz,
     * avec ses relations associées.
     */
    public function show(string $id): JsonResponse
    {
        $item = QuizMatchQuestion::with(['quizMatch', 'question', 'answers'])
            ->findOrFail($id);

        return response()->json($item);
    }

    /**
     * Mettre à jour une question d'un match de quiz.
     * Seule la propriété 'order' est modifiable par la validation.
     */
    public function update(UpdateQuizMatchQuestionRequest $request, string $id): JsonResponse
    {
        $item = QuizMatchQuestion::findOrFail($id);

        $data = $request->validated();
        $item->update($data);

        $item->load(['quizMatch', 'question', 'answers']);
        return response()->json($item);
    }

    /**
     * Supprimer une question d'un match de quiz.
     */
    public function destroy(string $id): JsonResponse
    {
        $item = QuizMatchQuestion::findOrFail($id);
        $item->delete();

        // Retourner une réponse vide avec code 204 No Content
        return response()->json(null, 204);
    }
}