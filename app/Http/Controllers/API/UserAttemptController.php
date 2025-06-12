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
     * Retourne la liste de toutes les tentatives utilisateur.
     */
    public function index()
    {
        $attempts = UserAttempt::all();
        return response()->json($attempts);
    }

    /**
     * Crée une nouvelle tentative utilisateur à partir des données validées.
     */
    public function store(StoreUserAttemptRequest $request)
    {
        $attempt = UserAttempt::create($request->validated());

        return response()->json($attempt, Response::HTTP_CREATED);
    }

    /**
     * Affiche une tentative utilisateur spécifique.
     */
    public function show(UserAttempt $userAttempt)
    {
        return response()->json($userAttempt);
    }

    /**
     * Met à jour une tentative utilisateur avec les données validées.
     */
    public function update(UpdateUserAttemptRequest $request, UserAttempt $userAttempt)
    {
        $userAttempt->update($request->validated());

        return response()->json($userAttempt);
    }

    /**
     * Supprime une tentative utilisateur donnée.
     */
    public function destroy(UserAttempt $userAttempt)
    {
        $userAttempt->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}