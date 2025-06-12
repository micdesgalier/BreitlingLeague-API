<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Models\Question;
use Illuminate\Http\Response;

class QuestionController extends Controller
{
    /**
     * Retourne la liste de toutes les questions.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $questions = Question::all();
        return response()->json($questions, Response::HTTP_OK);
    }

    /**
     * Enregistre une nouvelle question dans la base de données.
     *
     * @param  StoreQuestionRequest  $request  Données validées de la requête
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreQuestionRequest $request)
    {
        $question = Question::create($request->validated());

        return response()->json($question, Response::HTTP_CREATED);
    }

    /**
     * Affiche une question spécifique.
     *
     * @param  Question  $question  Instance de la question récupérée par injection de dépendance
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Question $question)
    {
        return response()->json($question, Response::HTTP_OK);
    }

    /**
     * Met à jour une question existante avec de nouvelles données validées.
     *
     * @param  UpdateQuestionRequest  $request  Données validées de la requête
     * @param  Question  $question             Question à modifier
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateQuestionRequest $request, Question $question)
    {
        $question->update($request->validated());

        return response()->json($question, Response::HTTP_OK);
    }

    /**
     * Supprime une question de la base de données.
     *
     * @param  Question  $question  Question à supprimer
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Question $question)
    {
        $question->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}