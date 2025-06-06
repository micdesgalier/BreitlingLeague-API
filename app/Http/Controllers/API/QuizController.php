<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuizRequest;
use App\Http\Requests\UpdateQuizRequest;
use App\Models\Quiz;
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
     * @param  \App\Http\Requests\StoreQuizRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuizRequest $request)
    {
        $quiz = Quiz::create($request->validated());

        return response()->json($quiz, Response::HTTP_CREATED);
    }

    /**
     * Display the specified quiz, chargé avec ses Stages → Pools → Questions → Choices.
     *
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function show(Quiz $quiz)
    {
        $quiz->load([
            'stages' => function($query) {
                $query->orderBy('order');
            },
            'stages.pools' => function($query) {
                $query->orderBy('order');
            },
            'stages.pools.questions' => function($query) {
                $query->orderBy('label');
            },
            'stages.pools.questions.choices' => function($query) {
                $query->orderBy('order');
            },
        ]);

        return response()->json($quiz);
    }

    /**
     * Update the specified quiz in storage.
     *
     * @param  \App\Http\Requests\UpdateQuizRequest  $request
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateQuizRequest $request, Quiz $quiz)
    {
        $quiz->update($request->validated());

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