<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuizActivityResultRequest;
use App\Http\Requests\UpdateQuizActivityResultRequest;
use App\Models\QuizActivityResult;
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
    public function store(StoreQuizActivityResultRequest $request)
    {
        $result = QuizActivityResult::create($request->validated());
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
    public function update(UpdateQuizActivityResultRequest $request, QuizActivityResult $quizActivityResult)
    {
        $quizActivityResult->update($request->validated());
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