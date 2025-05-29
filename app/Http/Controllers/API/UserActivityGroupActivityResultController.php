<?php

namespace App\Http\Controllers;

use App\Models\UserActivityGroupActivityResult;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserActivityGroupActivityResultController extends Controller
{
    /**
     * Affiche la liste de tous les résultats.
     */
    public function index()
    {
        $results = UserActivityGroupActivityResult::all();
        return response()->json($results, Response::HTTP_OK);
    }

    /**
     * Stocke un nouveau résultat.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id'                        => 'required|integer|exists:users,id',
            'activity_group_activity_id'     => 'required|integer|exists:user_activity_group_activities,id',
            'is_completed'                   => 'required|boolean',
            'completion_date'                => 'nullable|date',
            'score'                          => 'nullable|numeric',
            'score_percent'                  => 'nullable|numeric',
            'has_improved_score'             => 'required|boolean',
        ]);

        $result = UserActivityGroupActivityResult::create($data);

        return response()->json($result, Response::HTTP_CREATED);
    }

    /**
     * Affiche un résultat spécifique.
     */
    public function show(UserActivityGroupActivityResult $userActivityGroupActivityResult)
    {
        return response()->json($userActivityGroupActivityResult, Response::HTTP_OK);
    }

    /**
     * Met à jour un résultat existant.
     */
    public function update(Request $request, UserActivityGroupActivityResult $userActivityGroupActivityResult)
    {
        $data = $request->validate([
            'user_id'                        => 'sometimes|integer|exists:users,id',
            'activity_group_activity_id'     => 'sometimes|integer|exists:user_activity_group_activities,id',
            'is_completed'                   => 'sometimes|boolean',
            'completion_date'                => 'sometimes|date|nullable',
            'score'                          => 'sometimes|numeric|nullable',
            'score_percent'                  => 'sometimes|numeric|nullable',
            'has_improved_score'             => 'sometimes|boolean',
        ]);

        $userActivityGroupActivityResult->update($data);

        return response()->json($userActivityGroupActivityResult, Response::HTTP_OK);
    }

    /**
     * Supprime un résultat.
     */
    public function destroy(UserActivityGroupActivityResult $userActivityGroupActivityResult)
    {
        $userActivityGroupActivityResult->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}