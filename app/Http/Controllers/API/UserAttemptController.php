<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\UserAttempt;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserAttemptController extends Controller
{
    /**
     * Display a listing of user attempts.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attempts = UserAttempt::all();
        return response()->json($attempts);
    }

    /**
     * Store a newly created user attempt in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'quiz_code_id' => 'required|integer|exists:quizzes,code_id',
            'user_id' => 'required|integer|exists:users,id',
            'is_completed' => 'required|boolean',
            'duration' => 'nullable|integer|min:0',
            'score' => 'nullable|integer',
            'initial_score' => 'nullable|integer',
            'combo_bonus_score' => 'nullable|integer',
            'time_bonus_score' => 'nullable|integer',
        ]);

        $attempt = UserAttempt::create($data);

        return response()->json($attempt, Response::HTTP_CREATED);
    }

    /**
     * Display the specified user attempt.
     *
     * @param  \App\Models\UserAttempt  $userAttempt
     * @return \Illuminate\Http\Response
     */
    public function show(UserAttempt $userAttempt)
    {
        return response()->json($userAttempt);
    }

    /**
     * Update the specified user attempt in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserAttempt  $userAttempt
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserAttempt $userAttempt)
    {
        $data = $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'quiz_code_id' => 'sometimes|required|integer|exists:quizzes,code_id',
            'user_id' => 'sometimes|required|integer|exists:users,id',
            'is_completed' => 'sometimes|required|boolean',
            'duration' => 'nullable|integer|min:0',
            'score' => 'nullable|integer',
            'initial_score' => 'nullable|integer',
            'combo_bonus_score' => 'nullable|integer',
            'time_bonus_score' => 'nullable|integer',
        ]);

        $userAttempt->update($data);

        return response()->json($userAttempt);
    }

    /**
     * Remove the specified user attempt from storage.
     *
     * @param  \App\Models\UserAttempt  $userAttempt
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserAttempt $userAttempt)
    {
        $userAttempt->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}