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
     * Récupère et retourne toutes les réponses d'essais utilisateurs.
     */
    public function index()
    {
        $choices = UserAttemptChoice::all();
        return response()->json($choices);
    }

    /**
     * Enregistre une nouvelle réponse d'essai utilisateur validée.
     */
    public function store(StoreUserAttemptChoiceRequest $request)
    {
        $choice = UserAttemptChoice::create($request->validated());

        return response()->json($choice, Response::HTTP_CREATED);
    }

    /**
     * Affiche une réponse d'essai utilisateur spécifique.
     */
    public function show(UserAttemptChoice $userAttemptChoice)
    {
        return response()->json($userAttemptChoice);
    }

    /**
     * Met à jour une réponse d'essai utilisateur avec les données validées.
     */
    public function update(UpdateUserAttemptChoiceRequest $request, UserAttemptChoice $userAttemptChoice)
    {
        $userAttemptChoice->update($request->validated());

        return response()->json($userAttemptChoice);
    }

    /**
     * Supprime une réponse d'essai utilisateur donnée.
     */
    public function destroy(UserAttemptChoice $userAttemptChoice)
    {
        $userAttemptChoice->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
