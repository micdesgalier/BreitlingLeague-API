<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\UserActivityGroupActivity;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserActivityGroupActivityController extends Controller
{
    /**
     * Affiche tous les enregistrements.
     */
    public function index()
    {
        $items = UserActivityGroupActivity::all();
        return response()->json($items, Response::HTTP_OK);
    }

    /**
     * Stocke un nouvel enregistrement.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'start_date'                  => 'required|date',
            'end_date'                    => 'nullable|date|after_or_equal:start_date',
            'progression_score'           => 'nullable|numeric',
            'progression_score_percent'   => 'nullable|numeric|min:0|max:100',
            'external_id'                 => 'nullable|integer',
            'user_id'                     => 'required|integer|exists:users,id',
            'activity_group_activity_id'  => 'required|integer|exists:activity_group_activities,id',
            'activity_result_id'          => 'nullable|integer|exists:activity_results,id',
        ]);

        $item = UserActivityGroupActivity::create($data);

        return response()->json($item, Response::HTTP_CREATED);
    }

    /**
     * Affiche un enregistrement spécifique.
     */
    public function show(UserActivityGroupActivity $userActivityGroupActivity)
    {
        return response()->json($userActivityGroupActivity, Response::HTTP_OK);
    }

    /**
     * Met à jour un enregistrement existant.
     */
    public function update(Request $request, UserActivityGroupActivity $userActivityGroupActivity)
    {
        $data = $request->validate([
            'start_date'                  => 'sometimes|date',
            'end_date'                    => 'sometimes|nullable|date|after_or_equal:start_date',
            'progression_score'           => 'sometimes|numeric',
            'progression_score_percent'   => 'sometimes|numeric|min:0|max:100',
            'external_id'                 => 'sometimes|integer',
            'user_id'                     => 'sometimes|integer|exists:users,id',
            'activity_group_activity_id'  => 'sometimes|integer|exists:activity_group_activities,id',
            'activity_result_id'          => 'sometimes|integer|exists:activity_results,id',
        ]);

        $userActivityGroupActivity->update($data);

        return response()->json($userActivityGroupActivity, Response::HTTP_OK);
    }

    /**
     * Supprime un enregistrement.
     */
    public function destroy(UserActivityGroupActivity $userActivityGroupActivity)
    {
        $userActivityGroupActivity->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}