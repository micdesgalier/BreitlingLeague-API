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
     * Display a listing of the stages.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stages = Stage::all();
        return response()->json($stages);
    }

    /**
     * Store a newly created stage in storage.
     *
     * @param  \App\Http\Requests\StoreStageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStageRequest $request)
    {
        $stage = Stage::create($request->validated());

        return response()->json($stage, Response::HTTP_CREATED);
    }

    /**
     * Display the specified stage.
     *
     * @param  \App\Models\Stage  $stage
     * @return \Illuminate\Http\Response
     */
    public function show(Stage $stage)
    {
        return response()->json($stage);
    }

    /**
     * Update the specified stage in storage.
     *
     * @param  \App\Http\Requests\UpdateStageRequest  $request
     * @param  \App\Models\Stage  $stage
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStageRequest $request, Stage $stage)
    {
        $stage->update($request->validated());

        return response()->json($stage);
    }

    /**
     * Remove the specified stage from storage.
     *
     * @param  \App\Models\Stage  $stage
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stage $stage)
    {
        $stage->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}