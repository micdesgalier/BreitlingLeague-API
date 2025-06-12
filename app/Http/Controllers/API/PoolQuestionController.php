<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePoolQuestionRequest;
use App\Http\Requests\UpdatePoolQuestionRequest;
use App\Models\PoolQuestion;
use Illuminate\Http\Response;

class PoolQuestionController extends Controller
{
    /**
     * Retourne la liste de toutes les associations entre pools et questions.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $poolQuestions = PoolQuestion::all();
        return response()->json($poolQuestions, Response::HTTP_OK);
    }

    /**
     * Enregistre une nouvelle association entre une pool et une question.
     *
     * @param  StorePoolQuestionRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StorePoolQuestionRequest $request)
    {
        $poolQuestion = PoolQuestion::create($request->validated());

        return response()->json($poolQuestion, Response::HTTP_CREATED);
    }

    /**
     * Affiche une association spécifique entre une pool et une question.
     *
     * @param  int  $pool_code_id           ID de la pool
     * @param  int  $question_code_id       ID de la question
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($pool_code_id, $question_code_id)
    {
        $poolQuestion = PoolQuestion::where('pool_code_id', $pool_code_id)
            ->where('question_code_id', $question_code_id)
            ->firstOrFail();

        return response()->json($poolQuestion, Response::HTTP_OK);
    }

    /**
     * Met à jour une association spécifique entre une pool et une question.
     *
     * @param  UpdatePoolQuestionRequest  $request
     * @param  int  $pool_code_id         ID de la pool
     * @param  int  $question_code_id     ID de la question
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdatePoolQuestionRequest $request, $pool_code_id, $question_code_id)
    {
        $poolQuestion = PoolQuestion::where('pool_code_id', $pool_code_id)
            ->where('question_code_id', $question_code_id)
            ->firstOrFail();

        $poolQuestion->update($request->validated());

        return response()->json($poolQuestion, Response::HTTP_OK);
    }

    /**
     * Supprime une association entre une pool et une question.
     *
     * @param  int  $pool_code_id         ID de la pool
     * @param  int  $question_code_id     ID de la question
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($pool_code_id, $question_code_id)
    {
        $poolQuestion = PoolQuestion::where('pool_code_id', $pool_code_id)
            ->where('question_code_id', $question_code_id)
            ->firstOrFail();

        $poolQuestion->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}