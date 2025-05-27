<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserAttemptQuestionRequest;
use App\Http\Requests\UpdateUserAttemptQuestionRequest;
use App\Models\UserAttemptQuestion;
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
     * @param  \App\Http\Requests\StoreUserAttemptQuestionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserAttemptQuestionRequest $request)
    {
        $question = UserAttemptQuestion::create($request->validated());

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
     * @param  \App\Http\Requests\UpdateUserAttemptQuestionRequest  $request
     * @param  \App\Models\UserAttemptQuestion  $userAttemptQuestion
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserAttemptQuestionRequest $request, UserAttemptQuestion $userAttemptQuestion)
    {
        $userAttemptQuestion->update($request->validated());

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