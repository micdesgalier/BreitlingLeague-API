<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\QuizMatch;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class QuizMatchController extends Controller
{
    /**
     * Display a listing of quiz matches.
     */
    public function index(): JsonResponse
    {
        // Charger éventuellement les relations si nécessaire
        $matches = QuizMatch::with(['quiz', 'participants', 'questions'])->get();
        return response()->json($matches);
    }

    /**
     * Store a newly created quiz match in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'quiz_code_id' => 'required|string|exists:quizzes,code_id',
            'status'       => 'required|string',
            // si d'autres champs sont nécessaires, ajoutez-les ici
        ]);

        // Générer un ID de type string (UUID) pour la PK
        $data['id'] = (string) Str::uuid();
        // Laravel remplira automatiquement 'created_date' grâce à const CREATED_AT

        $quizMatch = QuizMatch::create($data);

        // Charger relations si besoin
        $quizMatch->load(['quiz', 'participants', 'questions']);

        return response()->json($quizMatch, 201);
    }

    /**
     * Display the specified quiz match.
     */
    public function show(QuizMatch $quizMatch): JsonResponse
    {
        // Charger relations pour renvoyer le détail complet
        $quizMatch->load(['quiz', 'participants', 'questions']);
        return response()->json($quizMatch);
    }

    /**
     * Update the specified quiz match in storage.
     */
    public function update(Request $request, QuizMatch $quizMatch): JsonResponse
    {
        $data = $request->validate([
            // On n'autorise que la mise à jour de status par exemple
            'status' => 'sometimes|required|string',
            // Vous pouvez ajouter d'autres champs modifiables ici
        ]);

        $quizMatch->update($data);

        $quizMatch->load(['quiz', 'participants', 'questions']);
        return response()->json($quizMatch);
    }

    /**
     * Remove the specified quiz match from storage.
     */
    public function destroy(QuizMatch $quizMatch): JsonResponse
    {
        $quizMatch->delete();
        return response()->json(null, 204);
    }
}