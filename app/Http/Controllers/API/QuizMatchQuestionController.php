<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\QuizMatchQuestion;
use App\Models\QuizMatch;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class QuizMatchQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        // Charger les relations si besoin (quizMatch et question, éventuellement answers)
        $items = QuizMatchQuestion::with(['quizMatch', 'question', 'answers'])->get();
        return response()->json($items);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'quiz_match_id'    => 'required|string|exists:quiz_matches,id',
            'question_code_id' => 'required|string|exists:questions,code_id',
            'order'            => 'required|integer|min:0',
        ]);

        // Vérifier que le match existe
        $quizMatch = QuizMatch::find($data['quiz_match_id']);
        if (! $quizMatch) {
            return response()->json(['error' => 'QuizMatch introuvable.'], 422);
        }

        // Optionnel : vérifier qu’on n’a pas déjà cette question pour ce match
        $exists = QuizMatchQuestion::where('quiz_match_id', $data['quiz_match_id'])
            ->where('question_code_id', $data['question_code_id'])
            ->exists();
        if ($exists) {
            return response()->json(['error' => 'Cette question est déjà associée à ce match.'], 422);
        }

        // Générer un ID UUID pour la PK si non auto-incrément
        $data['id'] = (string) Str::uuid();

        $item = QuizMatchQuestion::create($data);

        // Charger relations pour la réponse
        $item->load(['quizMatch', 'question', 'answers']);

        return response()->json($item, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $item = QuizMatchQuestion::with(['quizMatch', 'question', 'answers'])
            ->findOrFail($id);

        return response()->json($item);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $item = QuizMatchQuestion::findOrFail($id);

        $data = $request->validate([
            // On n'autorise généralement pas à changer quiz_match_id ni question_code_id
            'order' => 'sometimes|required|integer|min:0',
        ]);

        $item->update($data);

        $item->load(['quizMatch', 'question', 'answers']);
        return response()->json($item);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $item = QuizMatchQuestion::findOrFail($id);
        $item->delete();
        return response()->json(null, 204);
    }
}