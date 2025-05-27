<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PoolQuestion;
use Illuminate\Http\Request;
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'pool_code_id' => 'required|integer|exists:pools,code_id',
            'question_code_id' => 'required|integer|exists:questions,code_id',
            'order' => 'required|integer|min:0',
        ]);

        $poolQuestion = PoolQuestion::create($data);

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
        $poolQuestion = PoolQuestion::findOrFail([
            'pool_code_id' => $pool_code_id,
            'question_code_id' => $question_code_id,
        ]);
        return response()->json($poolQuestion);
    }

    /**
     * Update the specified pool question in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $pool_code_id
     * @param  int  $question_code_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $pool_code_id, $question_code_id)
    {
        $poolQuestion = PoolQuestion::findOrFail([
            'pool_code_id' => $pool_code_id,
            'question_code_id' => $question_code_id,
        ]);

        $data = $request->validate([
            'order' => 'sometimes|required|integer|min:0',
        ]);

        $poolQuestion->update($data);

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
        $poolQuestion = PoolQuestion::findOrFail([
            'pool_code_id' => $pool_code_id,
            'question_code_id' => $question_code_id,
        ]);

        $poolQuestion->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}