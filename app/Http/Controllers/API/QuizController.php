<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class QuizController extends Controller
{
    /**
     * Display a listing of the quizzes.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $quizzes = Quiz::all();
        return response()->json($quizzes);
    }

    /**
     * Store a newly created quiz in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'code_id' => 'required|integer|unique:quizzes,code_id',
            'type' => 'required|string|max:255',
            'label_translation_code_id' => 'nullable|integer|exists:label_translations,code_id',
            'shuffle_type' => 'required|string|max:255',
            'shuffle_scope' => 'required|string|max:255',
            'draw_type' => 'required|string|max:255',
            'max_user_attempt' => 'required|integer|min:0',
            'is_unlimited' => 'required|boolean',
            'duration' => 'required|integer|min:0',
            'question_duration' => 'required|integer|min:0',
            'correct_choice_points' => 'required|integer',
            'wrong_choice_points' => 'required|integer',
        ]);

        $quiz = Quiz::create($data);

        return response()->json($quiz, Response::HTTP_CREATED);
    }

    /**
     * Display the specified quiz.
     *
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function show(Quiz $quiz)
    {
        return response()->json($quiz);
    }

    /**
     * Update the specified quiz in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Quiz $quiz)
    {
        $data = $request->validate([
            'type' => 'sometimes|required|string|max:255',
            'label_translation_code_id' => 'nullable|integer|exists:label_translations,code_id',
            'shuffle_type' => 'sometimes|required|string|max:255',
            'shuffle_scope' => 'sometimes|required|string|max:255',
            'draw_type' => 'sometimes|required|string|max:255',
            'max_user_attempt' => 'sometimes|required|integer|min:0',
            'is_unlimited' => 'sometimes|required|boolean',
            'duration' => 'sometimes|required|integer|min:0',
            'question_duration' => 'sometimes|required|integer|min:0',
            'correct_choice_points' => 'sometimes|required|integer',
            'wrong_choice_points' => 'sometimes|required|integer',
        ]);

        $quiz->update($data);

        return response()->json($quiz);
    }

    /**
     * Remove the specified quiz from storage.
     *
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}