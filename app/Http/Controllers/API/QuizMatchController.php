<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuizMatchRequest;
use App\Http\Requests\UpdateQuizMatchRequest;
use App\Models\QuizMatch;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class QuizMatchController extends Controller
{
    /**
     * Display a listing of quiz matches.
     */
    public function index(): JsonResponse
    {
        $matches = QuizMatch::with(['quiz', 'participants', 'questions'])->get();
        return response()->json($matches);
    }

    /**
     * Store a newly created quiz match in storage.
     */
    public function store(StoreQuizMatchRequest $request): JsonResponse
    {
        $data = $request->validated();

        // Générer un ID UUID pour la PK si nécessaire
        $data['id'] = (string) Str::uuid();

        $quizMatch = QuizMatch::create($data);
        $quizMatch->load(['quiz', 'participants', 'questions']);

        return response()->json($quizMatch, 201);
    }

    /**
     * Display the specified quiz match.
     */
    public function show(QuizMatch $quizMatch): JsonResponse
    {
        $quizMatch->load(['quiz', 'participants', 'questions']);
        return response()->json($quizMatch);
    }

    /**
     * Update the specified quiz match in storage.
     */
    public function update(UpdateQuizMatchRequest $request, QuizMatch $quizMatch): JsonResponse
    {
        $data = $request->validated();

        $quizMatch->update($data);
        $quizMatch->load(['quiz', 'participants', 'questions']);

        return response()->json($quizMatch);
    }

    /**
     * Remove the specified quiz match from storage.
     */
    public function destroy(QuizMatch $quizMatch): JsonResponse
    {
        $quizMatch->delete();
        return response()->json(null, 204);
    }
}