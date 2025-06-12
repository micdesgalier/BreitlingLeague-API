<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Models\QuizMatch;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * Affiche la liste de tous les utilisateurs.
     *
     * GET /api/users
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $users = User::all();
        return response()->json([
            'success' => true,
            'data'    => $users,
        ], 200);
    }

    /**
     * Stocke un nouvel utilisateur en base.
     *
     * POST /api/users
     *
     * @param  StoreUserRequest  $request
     * @return JsonResponse
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        $user = User::create($request->validated());

        return response()->json([
            'success' => true,
            'data'    => $user,
        ], 201);
    }

    /**
     * Affiche un utilisateur spécifique.
     *
     * GET /api/users/{user}
     *
     * @param  User  $user   (Route Model Binding)
     * @return JsonResponse
     */
    public function show(User $user): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data'    => $user,
        ], 200);
    }

    /**
     * Met à jour un utilisateur existant.
     *
     * PUT/PATCH /api/users/{user}
     *
     * @param  UpdateUserRequest  $request
     * @param  User               $user    (Route Model Binding)
     * @return JsonResponse
     */
    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        $user->update($request->validated());

        return response()->json([
            'success' => true,
            'data'    => $user->fresh(),
        ], 200);
    }

    /**
     * Supprime un utilisateur.
     *
     * DELETE /api/users/{user}
     *
     * @param  User  $user    (Route Model Binding)
     * @return JsonResponse
     */
    public function destroy(User $user): JsonResponse
    {
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Utilisateur supprimé avec succès.',
        ], 200);
    }

    public function quizMatch(User $user): JsonResponse
    {
        // On peut récupérer directement les quizMatches via whereHas, pour charger les relations utiles.
        $matches = QuizMatch::whereHas('participants', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->with([
            // charger le quiz de base si utile
            'quiz',
            // charger tous les participants (et leurs users) pour chaque match
            'participants.user',
            // charger les questions du match + la question + ses choix
            'questions.question.choices',
            // charger nextTurnUser si la relation existe
            'nextTurnUser',
        ])->get();

        return response()->json([
            'success' => true,
            'data'    => $matches,
        ], 200);
    }

    public function ranking(): JsonResponse
    {
        // 1) Charger tous les users avec la somme des scores de leurs quizAttempts
        //    Le withSum crée un attribut quiz_attempts_sum_score.
        //    Note : selon la version de Laravel, l’attribut sera quiz_attempts_sum_score.
        $users = User::withSum('quizAttempts as total_score', 'score')
                     ->get();

        // 2) Ordonner par total_score décroissant. Si total_score null (pas de tentative), on traite comme 0.
        $users = $users->sortByDesc(function ($user) {
            // withSum alias 'total_score' : peut être null si aucun attempt ; on convertit en 0
            return $user->total_score ?? 0;
        })->values(); // reindexer la collection de 0...

        // 3) Calcul du rang (dense ranking : partagés en cas d’égalité)
        $ranked = [];
        $prevScore = null;
        $position = 0; // position dans la liste (1-based)
        $currentRank = 0;

        foreach ($users as $user) {
            $position++;
            $score = $user->total_score ?? 0;
            if ($prevScore === null || $score < $prevScore) {
                // nouveau score inférieur => nouveau rang = position
                $currentRank = $position;
                $prevScore = $score;
            }
            // else si $score == $prevScore, on garde $currentRank inchangé (même rang que précédent)
            // on peut extraire seulement les champs nécessaires pour la réponse
            $ranked[] = [
                'user' => [
                    'id'         => $user->id,
                    'last_name'  => $user->last_name,
                    'first_name' => $user->first_name,
                    'nickname'   => $user->nickname,
                    'email'      => $user->email,
                    'media'      => $user->media,
                    'group'      => $user->group ?? null,
                    'country'    => $user->country ?? null,
                    // Ajoutez d’autres champs que vous souhaitez exposer
                ],
                'total_score' => $score,
                'rank'        => $currentRank,
            ];
        }

        return response()->json([
            'success' => true,
            'data'    => $ranked,
        ], 200);
    }
}