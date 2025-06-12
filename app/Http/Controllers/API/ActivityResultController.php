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
     * Retourne la liste complète des résultats d'activité.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $results = ActivityResult::all();

        return response()->json($results, Response::HTTP_OK);
    }

    /**
     * Crée et enregistre un nouveau résultat d'activité.
     *
     * @param  StoreActivityResultRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreActivityResultRequest $request)
    {
        $result = ActivityResult::create($request->validated());

        return response()->json($result, Response::HTTP_CREATED);
    }

    /**
     * Affiche les détails d’un résultat d’activité spécifique.
     *
     * @param  ActivityResult  $activityResult
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(ActivityResult $activityResult)
    {
        return response()->json($activityResult, Response::HTTP_OK);
    }

    /**
     * Met à jour les informations d’un résultat d’activité existant.
     *
     * @param  UpdateActivityResultRequest  $request
     * @param  ActivityResult               $activityResult
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateActivityResultRequest $request, ActivityResult $activityResult)
    {
        $activityResult->update($request->validated());

        return response()->json($activityResult, Response::HTTP_OK);
    }

    /**
     * Supprime définitivement un résultat d’activité.
     *
     * @param  ActivityResult  $activityResult
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(ActivityResult $activityResult)
    {
        $activityResult->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}