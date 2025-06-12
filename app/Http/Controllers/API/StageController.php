<?php 

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStageRequest;
use App\Http\Requests\UpdateStageRequest;
use App\Models\Stage;
use Illuminate\Http\Response;

class StageController extends Controller
{
    /**
     * Récupérer et retourner tous les stages.
     */
    public function index()
    {
        $stages = Stage::all();
        return response()->json($stages);
    }

    /**
     * Créer un nouveau stage avec les données validées.
     * Retourne le stage créé avec le code 201.
     */
    public function store(StoreStageRequest $request)
    {
        $stage = Stage::create($request->validated());

        return response()->json($stage, Response::HTTP_CREATED);
    }

    /**
     * Retourner les informations d’un stage spécifique.
     */
    public function show(Stage $stage)
    {
        return response()->json($stage);
    }

    /**
     * Mettre à jour un stage avec les données validées.
     * Retourne le stage mis à jour.
     */
    public function update(UpdateStageRequest $request, Stage $stage)
    {
        $stage->update($request->validated());

        return response()->json($stage);
    }

    /**
     * Supprimer un stage.
     * Retourne une réponse sans contenu (204).
     */
    public function destroy(Stage $stage)
    {
        $stage->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}