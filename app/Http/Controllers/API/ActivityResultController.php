<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ActivityResult;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ActivityResultController extends Controller
{
    /**
     * Affiche tous les résultats d'activité.
     */
    public function index()
    {
        $results = ActivityResult::all();
        return response()->json($results, Response::HTTP_OK);
    }

    /**
     * Stocke un nouveau résultat d'activité.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'duration' => 'required|integer|min:0',
        ]);

        $result = ActivityResult::create($data);

        return response()->json($result, Response::HTTP_CREATED);
    }

    /**
     * Affiche un résultat spécifique.
     */
    public function show(ActivityResult $activityResult)
    {
        return response()->json($activityResult, Response::HTTP_OK);
    }

    /**
     * Met à jour un résultat existant.
     */
    public function update(Request $request, ActivityResult $activityResult)
    {
        $data = $request->validate([
            'duration' => 'sometimes|integer|min:0',
        ]);

        $activityResult->update($data);

        return response()->json($activityResult, Response::HTTP_OK);
    }

    /**
     * Supprime un résultat d'activité.
     */
    public function destroy(ActivityResult $activityResult)
    {
        $activityResult->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}