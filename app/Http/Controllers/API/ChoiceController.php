<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Choice;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ChoiceController extends Controller
{
    /**
     * Display a listing of the choices.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $choices = Choice::all();
        return response()->json($choices);
    }

    /**
     * Store a newly created choice in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'code_id' => 'required|integer|unique:choices,code_id',
            'media_id' => 'nullable|integer|exists:media,id',
            'order' => 'required|integer|min:0',
            'is_correct' => 'required|boolean',
            'question_code_id' => 'required|integer|exists:questions,code_id',
        ]);

        $choice = Choice::create($data);

        return response()->json($choice, Response::HTTP_CREATED);
    }

    /**
     * Display the specified choice.
     *
     * @param  \App\Models\Choice  $choice
     * @return \Illuminate\Http\Response
     */
    public function show(Choice $choice)
    {
        return response()->json($choice);
    }

    /**
     * Update the specified choice in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Choice  $choice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Choice $choice)
    {
        $data = $request->validate([
            'media_id' => 'nullable|integer|exists:media,id',
            'order' => 'sometimes|required|integer|min:0',
            'is_correct' => 'sometimes|required|boolean',
            'question_code_id' => 'sometimes|required|integer|exists:questions,code_id',
        ]);

        $choice->update($data);

        return response()->json($choice);
    }

    /**
     * Remove the specified choice from storage.
     *
     * @param  \App\Models\Choice  $choice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Choice $choice)
    {
        $choice->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}