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
     * @param  \App\Http\Requests\StoreChoiceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreChoiceRequest $request)
    {
        $choice = Choice::create($request->validated());

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
     * @param  \App\Http\Requests\UpdateChoiceRequest  $request
     * @param  \App\Models\Choice  $choice
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateChoiceRequest $request, Choice $choice)
    {
        $choice->update($request->validated());

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