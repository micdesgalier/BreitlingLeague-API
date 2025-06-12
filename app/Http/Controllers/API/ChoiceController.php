<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreChoiceRequest;
use App\Http\Requests\UpdateChoiceRequest;
use App\Models\Choice;
use Illuminate\Http\Response;

class ChoiceController extends Controller
{
    /**
     * Retourne la liste complète des choix.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $choices = Choice::all();
        return response()->json($choices, Response::HTTP_OK);
    }

    /**
     * Crée un nouveau choix à partir des données validées.
     *
     * @param  StoreChoiceRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreChoiceRequest $request)
    {
        $choice = Choice::create($request->validated());

        return response()->json($choice, Response::HTTP_CREATED);
    }

    /**
     * Retourne un choix spécifique.
     *
     * @param  Choice  $choice
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Choice $choice)
    {
        return response()->json($choice, Response::HTTP_OK);
    }

    /**
     * Met à jour les données d’un choix existant.
     *
     * @param  UpdateChoiceRequest  $request
     * @param  Choice               $choice
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateChoiceRequest $request, Choice $choice)
    {
        $choice->update($request->validated());

        return response()->json($choice, Response::HTTP_OK);
    }

    /**
     * Supprime un choix donné de la base de données.
     *
     * @param  Choice  $choice
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Choice $choice)
    {
        $choice->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}