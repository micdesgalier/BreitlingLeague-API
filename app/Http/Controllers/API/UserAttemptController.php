<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserAttemptRequest;
use App\Http\Requests\UpdateUserAttemptRequest;
use App\Models\UserAttempt;
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
     * @param  \App\Http\Requests\StoreUserAttemptRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserAttemptRequest $request)
    {
        $attempt = UserAttempt::create($request->validated());

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
     * @param  \App\Http\Requests\UpdateUserAttemptRequest  $request
     * @param  \App\Models\UserAttempt  $userAttempt
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserAttemptRequest $request, UserAttempt $userAttempt)
    {
        $userAttempt->update($request->validated());

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