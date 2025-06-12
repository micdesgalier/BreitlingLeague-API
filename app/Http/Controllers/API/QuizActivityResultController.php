<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuizActivityResultRequest;
use App\Http\Requests\UpdateQuizActivityResultRequest;
use App\Models\QuizActivityResult;
use Illuminate\Http\Response;

class QuizActivityResultController extends Controller
{
    /**
     * Retourne la liste complète des résultats de quiz.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $results = QuizActivityResult::all();
        return response()->json($results, Response::HTTP_OK);
    }

    /**
     * Enregistre un nouveau résultat de quiz à partir des données validées.
     *
     * @param  StoreQuizActivityResultRequest  $request  Requête contenant les données du résultat
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreQuizActivityResultRequest $request)
    {
        $result = QuizActivityResult::create($request->validated());
        return response()->json($result, Response::HTTP_CREATED);
    }

    /**
     * Affiche un résultat de quiz spécifique.
     *
     * @param  QuizActivityResult  $quizActivityResult  Résultat à afficher
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(QuizActivityResult $quizActivityResult)
    {
        return response()->json($quizActivityResult, Response::HTTP_OK);
    }

    /**
     * Met à jour un résultat de quiz existant avec de nouvelles données validées.
     *
     * @param  UpdateQuizActivityResultRequest  $request  Requête contenant les données à mettre à jour
     * @param  QuizActivityResult  $quizActivityResult   Résultat à modifier
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateQuizActivityResultRequest $request, QuizActivityResult $quizActivityResult)
    {
        $quizActivityResult->update($request->validated());
        return response()->json($quizActivityResult, Response::HTTP_OK);
    }

    /**
     * Supprime un résultat de quiz de la base de données.
     *
     * @param  QuizActivityResult  $quizActivityResult  Résultat à supprimer
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(QuizActivityResult $quizActivityResult)
    {
        $quizActivityResult->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}