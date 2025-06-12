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
     * Retourne la liste complète des quiz existants.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $quizzes = Quiz::all();
        return response()->json($quizzes);
    }

    /**
     * Crée un nouveau quiz à partir des données validées.
     *
     * @param  StoreQuizRequest  $request  Requête contenant les données du quiz
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuizRequest $request)
    {
        $quiz = Quiz::create($request->validated());
        return response()->json($quiz, Response::HTTP_CREATED);
    }

    /**
     * Affiche un quiz spécifique avec ses relations imbriquées :
     * Stages → Pools → Questions → Choices, chacun trié de manière logique.
     *
     * @param  Quiz  $quiz  Le quiz à afficher
     * @return \Illuminate\Http\Response
     */
    public function show(Quiz $quiz)
    {
        $quiz->load([
            'stages' => function($query) {
                $query->orderBy('order'); // Tri des stages par ordre
            },
            'stages.pools' => function($query) {
                $query->orderBy('order'); // Tri des pools dans chaque stage
            },
            'stages.pools.questions' => function($query) {
                $query->orderBy('label'); // Tri des questions par libellé
            },
            'stages.pools.questions.choices' => function($query) {
                $query->orderBy('order'); // Tri des choix de réponse
            },
        ]);

        return response()->json($quiz);
    }

    /**
     * Met à jour les informations d’un quiz existant.
     *
     * @param  UpdateQuizRequest  $request  Requête contenant les nouvelles données du quiz
     * @param  Quiz  $quiz                  Le quiz à modifier
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateQuizRequest $request, Quiz $quiz)
    {
        $quiz->update($request->validated());
        return response()->json($quiz);
    }

    /**
     * Supprime un quiz existant de la base de données.
     *
     * @param  Quiz  $quiz  Le quiz à supprimer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}