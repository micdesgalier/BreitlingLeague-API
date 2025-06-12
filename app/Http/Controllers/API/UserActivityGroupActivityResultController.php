<?php 

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserActivityGroupActivityResultRequest;
use App\Http\Requests\UpdateUserActivityGroupActivityResultRequest;
use App\Models\UserActivityGroupActivityResult;
use Illuminate\Http\Response;

class UserActivityGroupActivityResultController extends Controller
{
    /**
     * Retourne tous les résultats enregistrés.
     */
    public function index()
    {
        $results = UserActivityGroupActivityResult::all();
        return response()->json($results, Response::HTTP_OK);
    }

    /**
     * Crée un nouveau résultat avec les données validées.
     */
    public function store(StoreUserActivityGroupActivityResultRequest $request)
    {
        $result = UserActivityGroupActivityResult::create($request->validated());

        return response()->json($result, Response::HTTP_CREATED);
    }

    /**
     * Retourne un résultat spécifique.
     */
    public function show(UserActivityGroupActivityResult $userActivityGroupActivityResult)
    {
        return response()->json($userActivityGroupActivityResult, Response::HTTP_OK);
    }

    /**
     * Met à jour un résultat existant avec les données validées.
     */
    public function update(UpdateUserActivityGroupActivityResultRequest $request, UserActivityGroupActivityResult $userActivityGroupActivityResult)
    {
        $userActivityGroupActivityResult->update($request->validated());

        return response()->json($userActivityGroupActivityResult, Response::HTTP_OK);
    }

    /**
     * Supprime un résultat donné.
     */
    public function destroy(UserActivityGroupActivityResult $userActivityGroupActivityResult)
    {
        $userActivityGroupActivityResult->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}