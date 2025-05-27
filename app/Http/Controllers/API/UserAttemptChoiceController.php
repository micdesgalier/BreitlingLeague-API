<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserAttemptChoiceRequest;
use App\Http\Requests\UpdateUserAttemptChoiceRequest;
use App\Models\UserAttemptChoice;
use Illuminate\Http\Response;

class UserAttemptChoiceController extends Controller
{
    /**
     * Display a listing of user attempt choices.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $choices = UserAttemptChoice::all();
        return response()->json($choices);
    }

    /**
     * Store a newly created user attempt choice in storage.
     *
     * @param  \App\Http\Requests\StoreUserAttemptChoiceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserAttemptChoiceRequest $request)
    {
        $choice = UserAttemptChoice::create($request->validated());

        return response()->json($choice, Response::HTTP_CREATED);
    }

    /**
     * Display the specified user attempt choice.
     *
     * @param  \App\Models\UserAttemptChoice  $userAttemptChoice
     * @return \Illuminate\Http\Response
     */
    public function show(UserAttemptChoice $userAttemptChoice)
    {
        return response()->json($userAttemptChoice);
    }

    /**
     * Update the specified user attempt choice in storage.
     *
     * @param  \App\Http\Requests\UpdateUserAttemptChoiceRequest  $request
     * @param  \App\Models\UserAttemptChoice  $userAttemptChoice
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserAttemptChoiceRequest $request, UserAttemptChoice $userAttemptChoice)
    {
        $userAttemptChoice->update($request->validated());

        return response()->json($userAttemptChoice);
    }

    /**
     * Remove the specified user attempt choice from storage.
     *
     * @param  \App\Models\UserAttemptChoice  $userAttemptChoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserAttemptChoice $userAttemptChoice)
    {
        $userAttemptChoice->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}