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
     * Display a listing of the resource.
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
     * Store a newly created resource in storage.
     */
    public function store(StoreQuizMatchAnswerRequest $request): JsonResponse
    {
        $data = $request->validated();

        // Vérifier cohérence : question et participant appartiennent au même match
        $question = QuizMatchQuestion::find($data['quiz_match_question_id']);
        if (!$question || $question->quiz_match_id !== $data['quiz_match_id']) {
            return response()->json([
                'error' => 'La question n’appartient pas au match indiqué.'
            ], 422);
        }
        $participant = QuizMatchParticipant::find($data['quiz_match_participant_id']);
        if (!$participant || $participant->quiz_match_id !== $data['quiz_match_id']) {
            return response()->json([
                'error' => 'Le participant n’appartient pas au match indiqué.'
            ], 422);
        }

        // Générer un ID string si la PK n’est pas auto-incrément
        $data['id'] = (string) Str::uuid();

        $answer = QuizMatchAnswer::create($data);
        $answer->load(['quizMatch', 'participant', 'question', 'choice']);

        return response()->json($answer, 201);
    }

    /**
     * Display the specified resource.
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
     * Update the specified resource in storage.
     */
    public function update(UpdateQuizMatchAnswerRequest $request, string $id): JsonResponse
    {
        $answer = QuizMatchAnswer::findOrFail($id);

        $data = $request->validated();

        $answer->update($data);
        $answer->load(['quizMatch', 'participant', 'question', 'choice']);

        return response()->json($answer);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $answer = QuizMatchAnswer::findOrFail($id);
        $answer->delete();
        return response()->json(null, 204);
    }
}