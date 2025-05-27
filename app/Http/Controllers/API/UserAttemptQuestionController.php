<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\UserAttemptQuestion;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserAttemptQuestionController extends Controller
{
    /**
     * Display a listing of the user attempt questions.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = UserAttemptQuestion::all();
        return response()->json($questions);
    }

    /**
     * Store a newly created user attempt question in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_attempt_id'   => 'required|integer|exists:user_attempts,id',
            'order'             => 'required|integer|min:0',
            'is_correct'        => 'required|boolean',
            'score'             => 'required|integer',
            'question_code_id'  => 'required|integer|exists:questions,code_id',
            'combo_bonus_value' => 'required|integer',
        ]);

        $question = UserAttemptQuestion::create($data);

        return response()->json($question, Response::HTTP_CREATED);
    }

    /**
     * Display the specified user attempt question.
     *
     * @param  \App\Models\UserAttemptQuestion  $userAttemptQuestion
     * @return \Illuminate\Http\Response
     */
    public function show(UserAttemptQuestion $userAttemptQuestion)
    {
        return response()->json($userAttemptQuestion);
    }

    /**
     * Update the specified user attempt question in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserAttemptQuestion  $userAttemptQuestion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserAttemptQuestion $userAttemptQuestion)
    {
        $data = $request->validate([
            'user_attempt_id'   => 'sometimes|required|integer|exists:user_attempts,id',
            'order'             => 'sometimes|required|integer|min:0',
            'is_correct'        => 'sometimes|required|boolean',
            'score'             => 'sometimes|required|integer',
            'question_code_id'  => 'sometimes|required|integer|exists:questions,code_id',
            'combo_bonus_value' => 'sometimes|required|integer',
        ]);

        $userAttemptQuestion->update($data);

        return response()->json($userAttemptQuestion);
    }

    /**
     * Remove the specified user attempt question from storage.
     *
     * @param  \App\Models\UserAttemptQuestion  $userAttemptQuestion
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserAttemptQuestion $userAttemptQuestion)
    {
        $userAttemptQuestion->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}