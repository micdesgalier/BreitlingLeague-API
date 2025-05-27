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
     * Display a listing of the pool questions.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $poolQuestions = PoolQuestion::all();
        return response()->json($poolQuestions);
    }

    /**
     * Store a newly created pool question in storage.
     *
     * @param  \App\Http\Requests\StorePoolQuestionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePoolQuestionRequest $request)
    {
        $poolQuestion = PoolQuestion::create($request->validated());

        return response()->json($poolQuestion, Response::HTTP_CREATED);
    }

    /**
     * Display the specified pool question.
     *
     * @param  int  $pool_code_id
     * @param  int  $question_code_id
     * @return \Illuminate\Http\Response
     */
    public function show($pool_code_id, $question_code_id)
    {
        $poolQuestion = PoolQuestion::where('pool_code_id', $pool_code_id)
            ->where('question_code_id', $question_code_id)
            ->firstOrFail();

        return response()->json($poolQuestion);
    }

    /**
     * Update the specified pool question in storage.
     *
     * @param  \App\Http\Requests\UpdatePoolQuestionRequest  $request
     * @param  int  $pool_code_id
     * @param  int  $question_code_id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePoolQuestionRequest $request, $pool_code_id, $question_code_id)
    {
        $poolQuestion = PoolQuestion::where('pool_code_id', $pool_code_id)
            ->where('question_code_id', $question_code_id)
            ->firstOrFail();

        $poolQuestion->update($request->validated());

        return response()->json($poolQuestion);
    }

    /**
     * Remove the specified pool question from storage.
     *
     * @param  int  $pool_code_id
     * @param  int  $question_code_id
     * @return \Illuminate\Http\Response
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