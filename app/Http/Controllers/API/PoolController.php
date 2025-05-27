<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Pool;
use Illuminate\Http\Request;
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'code_id' => 'required|integer|unique:pools,code_id',
            'stage_code_id' => 'required|integer|exists:stages,code_id',
            'order' => 'required|integer|min:0',
            'number_of_question' => 'required|integer|min:0',
            'consecutive_correct_answer' => 'required|integer|min:0',
            'minimum_correct_question' => 'required|integer|min:0',
        ]);

        $pool = Pool::create($data);

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
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pool  $pool
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pool $pool)
    {
        $data = $request->validate([
            'stage_code_id' => 'sometimes|required|integer|exists:stages,code_id',
            'order' => 'sometimes|required|integer|min:0',
            'number_of_question' => 'sometimes|required|integer|min:0',
            'consecutive_correct_answer' => 'sometimes|required|integer|min:0',
            'minimum_correct_question' => 'sometimes|required|integer|min:0',
        ]);

        $pool->update($data);

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