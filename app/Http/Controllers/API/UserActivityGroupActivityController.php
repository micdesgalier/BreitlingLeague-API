<?php 

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserActivityGroupActivityRequest;
use App\Http\Requests\UpdateUserActivityGroupActivityRequest;
use App\Models\UserActivityGroupActivity;
use Illuminate\Http\Response;

class UserActivityGroupActivityController extends Controller
{
    /**
     * Retourne la liste de tous les enregistrements.
     */
    public function index()
    {
        $items = UserActivityGroupActivity::all();
        return response()->json($items, Response::HTTP_OK);
    }

    /**
     * Crée un nouvel enregistrement avec les données validées.
     * Retourne l’enregistrement créé.
     */
    public function store(StoreUserActivityGroupActivityRequest $request)
    {
        $item = UserActivityGroupActivity::create($request->validated());

        return response()->json($item, Response::HTTP_CREATED);
    }

    /**
     * Affiche un enregistrement précis.
     */
    public function show(UserActivityGroupActivity $userActivityGroupActivity)
    {
        return response()->json($userActivityGroupActivity, Response::HTTP_OK);
    }

    /**
     * Met à jour un enregistrement existant avec les données validées.
     * Retourne l’enregistrement mis à jour.
     */
    public function update(UpdateUserActivityGroupActivityRequest $request, UserActivityGroupActivity $userActivityGroupActivity)
    {
        $userActivityGroupActivity->update($request->validated());

        return response()->json($userActivityGroupActivity, Response::HTTP_OK);
    }

    /**
     * Supprime un enregistrement donné.
     */
    public function destroy(UserActivityGroupActivity $userActivityGroupActivity)
    {
        $userActivityGroupActivity->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}