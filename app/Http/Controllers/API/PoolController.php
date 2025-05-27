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
     * Display a listing of pools.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pools = Pool::all();
        return response()->json($pools);
    }

    /**
     * Store a newly created pool in storage.
     *
     * @param  \App\Http\Requests\StorePoolRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePoolRequest $request)
    {
        $pool = Pool::create($request->validated());

        return response()->json($pool, Response::HTTP_CREATED);
    }

    /**
     * Display the specified pool.
     *
     * @param  \App\Models\Pool  $pool
     * @return \Illuminate\Http\Response
     */
    public function show(Pool $pool)
    {
        return response()->json($pool);
    }

    /**
     * Update the specified pool in storage.
     *
     * @param  \App\Http\Requests\UpdatePoolRequest  $request
     * @param  \App\Models\Pool  $pool
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePoolRequest $request, Pool $pool)
    {
        $pool->update($request->validated());

        return response()->json($pool);
    }

    /**
     * Remove the specified pool from storage.
     *
     * @param  \App\Models\Pool  $pool
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pool $pool)
    {
        $pool->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}