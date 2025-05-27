<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Stage;
use Illuminate\Http\Request;
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'code_id' => 'required|integer|unique:stages,code_id',
            'quiz_code_id' => 'required|integer|exists:quizzes,code_id',
            'order' => 'required|integer|min:0',
            'number_of_time_to_use' => 'required|integer|min:0',
        ]);

        $stage = Stage::create($data);

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
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Stage  $stage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stage $stage)
    {
        $data = $request->validate([
            'quiz_code_id' => 'sometimes|required|integer|exists:quizzes,code_id',
            'order' => 'sometimes|required|integer|min:0',
            'number_of_time_to_use' => 'sometimes|required|integer|min:0',
        ]);

        $stage->update($data);

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