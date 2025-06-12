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
     * Retourne la liste de toutes les questions associées aux tentatives utilisateur.
     */
    public function index()
    {
        $questions = UserAttemptQuestion::all();
        return response()->json($questions);
    }

    /**
     * Crée une nouvelle question pour une tentative utilisateur.
     */
    public function store(StoreUserAttemptQuestionRequest $request)
    {
        $question = UserAttemptQuestion::create($request->validated());

        return response()->json($question, Response::HTTP_CREATED);
    }

    /**
     * Affiche une question spécifique liée à une tentative utilisateur.
     */
    public function show(UserAttemptQuestion $userAttemptQuestion)
    {
        return response()->json($userAttemptQuestion);
    }

    /**
     * Met à jour une question liée à une tentative utilisateur.
     */
    public function update(UpdateUserAttemptQuestionRequest $request, UserAttemptQuestion $userAttemptQuestion)
    {
        $userAttemptQuestion->update($request->validated());

        return response()->json($userAttemptQuestion);
    }

    /**
     * Supprime une question liée à une tentative utilisateur.
     */
    public function destroy(UserAttemptQuestion $userAttemptQuestion)
    {
        $userAttemptQuestion->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}