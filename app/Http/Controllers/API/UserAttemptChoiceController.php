<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\UserAttemptChoice;
use Illuminate\Http\Request;
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_attempt_id' => 'required|integer|exists:user_attempts,id',
            'choice_code_id'  => 'required|integer|exists:choices,code_id',
            'is_selected'     => 'required|boolean',
            'is_correct'      => 'required|boolean',
        ]);

        $choice = UserAttemptChoice::create($data);

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
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserAttemptChoice  $userAttemptChoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserAttemptChoice $userAttemptChoice)
    {
        $data = $request->validate([
            'user_attempt_id' => 'sometimes|required|integer|exists:user_attempts,id',
            'choice_code_id'  => 'sometimes|required|integer|exists:choices,code_id',
            'is_selected'     => 'sometimes|required|boolean',
            'is_correct'      => 'sometimes|required|boolean',
        ]);

        $userAttemptChoice->update($data);

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