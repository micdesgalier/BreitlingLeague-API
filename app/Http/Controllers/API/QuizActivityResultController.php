<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\QuizActivityResult;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class QuizActivityResultController extends Controller
{
    /**
     * Affiche tous les résultats de quiz.
     */
    public function index()
    {
        $results = QuizActivityResult::all();
        return response()->json($results, Response::HTTP_OK);
    }

    /**
     * Stocke un nouveau résultat de quiz.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'score'                 => 'required|numeric|min:0',
            'correct_answer_count'  => 'required|integer|min:0',
            'activity_result_id'    => 'required|integer|exists:activity_results,id',
        ]);

        $result = QuizActivityResult::create($data);

        return response()->json($result, Response::HTTP_CREATED);
    }

    /**
     * Affiche un résultat de quiz spécifique.
     */
    public function show(QuizActivityResult $quizActivityResult)
    {
        return response()->json($quizActivityResult, Response::HTTP_OK);
    }

    /**
     * Met à jour un résultat de quiz existant.
     */
    public function update(Request $request, QuizActivityResult $quizActivityResult)
    {
        $data = $request->validate([
            'score'                 => 'sometimes|numeric|min:0',
            'correct_answer_count'  => 'sometimes|integer|min:0',
            'activity_result_id'    => 'sometimes|integer|exists:activity_results,id',
        ]);

        $quizActivityResult->update($data);

        return response()->json($quizActivityResult, Response::HTTP_OK);
    }

    /**
     * Supprime un résultat de quiz.
     */
    public function destroy(QuizActivityResult $quizActivityResult)
    {
        $quizActivityResult->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}