<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class QuestionController extends Controller
{
    /**
     * Display a listing of the questions.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::all();
        return response()->json($questions);
    }

    /**
     * Store a newly created question in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'code_id' => 'required|integer|unique:questions,code_id',
            'label_translation_code_id' => 'nullable|integer|exists:label_translations,code_id',
            'is_active' => 'required|boolean',
            'media_id' => 'nullable|integer|exists:media,id',
            'type' => 'required|string|max:255',
            'is_choice_shuffle' => 'required|boolean',
            'correct_value' => 'required|string',
        ]);

        $question = Question::create($data);

        return response()->json($question, Response::HTTP_CREATED);
    }

    /**
     * Display the specified question.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        return response()->json($question);
    }

    /**
     * Update the specified question in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        $data = $request->validate([
            'label_translation_code_id' => 'nullable|integer|exists:label_translations,code_id',
            'is_active' => 'sometimes|required|boolean',
            'media_id' => 'nullable|integer|exists:media,id',
            'type' => 'sometimes|required|string|max:255',
            'is_choice_shuffle' => 'sometimes|required|boolean',
            'correct_value' => 'sometimes|required|string',
        ]);

        $question->update($data);

        return response()->json($question);
    }

    /**
     * Remove the specified question from storage.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        $question->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}