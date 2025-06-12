<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePoolRequest;
use App\Http\Requests\UpdatePoolRequest;
use App\Models\Pool;
use Illuminate\Http\Response;

class PoolController extends Controller
{
    /**
     * Retourne la liste de toutes les pools.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $pools = Pool::all();
        return response()->json($pools, Response::HTTP_OK);
    }

    /**
     * Crée une nouvelle pool avec les données validées.
     *
     * @param  StorePoolRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StorePoolRequest $request)
    {
        $pool = Pool::create($request->validated());

        return response()->json($pool, Response::HTTP_CREATED);
    }

    /**
     * Affiche les détails d'une pool spécifique.
     *
     * @param  Pool  $pool
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Pool $pool)
    {
        return response()->json($pool, Response::HTTP_OK);
    }

    /**
     * Met à jour une pool existante avec les données fournies.
     *
     * @param  UpdatePoolRequest  $request
     * @param  Pool               $pool
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdatePoolRequest $request, Pool $pool)
    {
        $pool->update($request->validated());

        return response()->json($pool, Response::HTTP_OK);
    }

    /**
     * Supprime une pool de la base de données.
     *
     * @param  Pool  $pool
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Pool $pool)
    {
        $pool->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}