<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreActivityResultRequest;
use App\Http\Requests\UpdateActivityResultRequest;
use App\Models\ActivityResult;
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
    public function store(StoreActivityResultRequest $request)
    {
        $result = ActivityResult::create($request->validated());
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
    public function update(UpdateActivityResultRequest $request, ActivityResult $activityResult)
    {
        $activityResult->update($request->validated());
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