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
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $items = QuizMatchQuestion::with(['quizMatch', 'question', 'answers'])->get();
        return response()->json($items);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuizMatchQuestionRequest $request): JsonResponse
    {
        $data = $request->validated();

        // Vérifier que le match existe
        $quizMatch = QuizMatch::find($data['quiz_match_id']);
        if (! $quizMatch) {
            return response()->json(['error' => 'QuizMatch introuvable.'], 422);
        }

        // Vérifier qu’on n’a pas déjà cette question pour ce match
        $exists = QuizMatchQuestion::where('quiz_match_id', $data['quiz_match_id'])
            ->where('question_code_id', $data['question_code_id'])
            ->exists();
        if ($exists) {
            return response()->json(['error' => 'Cette question est déjà associée à ce match.'], 422);
        }

        // Générer un ID UUID pour la PK si non auto-incrément
        $data['id'] = (string) Str::uuid();

        $item = QuizMatchQuestion::create($data);
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
    public function update(UpdateQuizMatchQuestionRequest $request, string $id): JsonResponse
    {
        $item = QuizMatchQuestion::findOrFail($id);

        $data = $request->validated();
        // Seule 'order' peut être modifié selon les règles
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