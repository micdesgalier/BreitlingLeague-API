<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * Affiche la liste de tous les utilisateurs.
     *
     * GET /api/users
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $users = User::all();
        return response()->json([
            'success' => true,
            'data'    => $users,
        ], 200);
    }

    /**
     * Stocke un nouvel utilisateur en base.
     *
     * POST /api/users
     *
     * @param  StoreUserRequest  $request
     * @return JsonResponse
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        $user = User::create($request->validated());

        return response()->json([
            'success' => true,
            'data'    => $user,
        ], 201);
    }

    /**
     * Affiche un utilisateur spécifique.
     *
     * GET /api/users/{user}
     *
     * @param  User  $user   (Route Model Binding)
     * @return JsonResponse
     */
    public function show(User $user): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data'    => $user,
        ], 200);
    }

    /**
     * Met à jour un utilisateur existant.
     *
     * PUT/PATCH /api/users/{user}
     *
     * @param  UpdateUserRequest  $request
     * @param  User               $user    (Route Model Binding)
     * @return JsonResponse
     */
    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        $user->update($request->validated());

        return response()->json([
            'success' => true,
            'data'    => $user->fresh(),
        ], 200);
    }

    /**
     * Supprime un utilisateur.
     *
     * DELETE /api/users/{user}
     *
     * @param  User  $user    (Route Model Binding)
     * @return JsonResponse
     */
    public function destroy(User $user): JsonResponse
    {
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Utilisateur supprimé avec succès.',
        ], 200);
    }
}