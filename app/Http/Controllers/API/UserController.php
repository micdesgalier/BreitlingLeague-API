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
     * Récupère et renvoie tous les utilisateurs.
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
     * Crée un nouvel utilisateur à partir des données validées.
     *
     * @param StoreUserRequest $request
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
     * Affiche un utilisateur spécifique via Route Model Binding.
     *
     * @param User $user
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
     * Met à jour un utilisateur existant avec les données validées.
     *
     * @param UpdateUserRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        $user->update($request->validated());

        // Renvoie la version fraîchement mise à jour de l'utilisateur
        return response()->json([
            'success' => true,
            'data'    => $user->fresh(),
        ], 200);
    }

    /**
     * Supprime un utilisateur donné.
     *
     * @param User $user
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

    /**
     * Récupère tous les matchs de quiz où l'utilisateur est participant,
     * avec leurs relations utiles préchargées.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function quizMatch(User $user): JsonResponse
    {
        $matches = QuizMatch::whereHas('participants', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->with([
            'quiz',
            'participants.user',
            'questions.question.choices',
            'nextTurnUser',
        ])->get();

        return response()->json([
            'success' => true,
            'data'    => $matches,
        ], 200);
    }

    /**
     * Calcule le classement général des utilisateurs
     * selon la somme de leurs scores sur tous les quiz attempts.
     *
     * @return JsonResponse
     */
    public function ranking(): JsonResponse
    {
        // Charger tous les utilisateurs avec la somme de leurs scores (total_score)
        $users = User::withSum('quizAttempts as total_score', 'score')->get();

        // Trier par score décroissant (les scores nulls sont considérés comme 0)
        $users = $users->sortByDesc(fn($user) => $user->total_score ?? 0)->values();

        // Calcul du rang dense (égalité partage le même rang)
        $ranked = [];
        $prevScore = null;
        $position = 0;
        $currentRank = 0;

        foreach ($users as $user) {
            $position++;
            $score = $user->total_score ?? 0;
            if ($prevScore === null || $score < $prevScore) {
                $currentRank = $position;
                $prevScore = $score;
            }

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

    /**
     * Calcule le classement des utilisateurs d'un pays donné
     * selon la somme de leurs scores.
     *
     * @param string $country
     * @return JsonResponse
     */
    public function rankingByCountry(string $country): JsonResponse
    {
        // Charger les utilisateurs du pays (insensible à la casse) avec leur total_score
        $users = User::whereRaw('LOWER(country) = ?', [strtolower($country)])
            ->withSum('quizAttempts as total_score', 'score')
            ->get();

        // Trier par score décroissant
        $users = $users->sortByDesc(fn($user) => $user->total_score ?? 0)->values();

        // Calcul du rang dense (égalité partage le même rang)
        $ranked = [];
        $prevScore = null;
        $position = 0;
        $currentRank = 0;

        foreach ($users as $user) {
            $position++;
            $score = $user->total_score ?? 0;
            if ($prevScore === null || $score < $prevScore) {
                $currentRank = $position;
                $prevScore = $score;
            }

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
                ],
                'total_score' => $score,
                'rank'        => $currentRank,
            ];
        }

        return response()->json([
            'success' => true,
            'country' => $country,
            'data'    => $ranked,
        ], 200);
    }

    /**
     * Récupère tous les membres du groupe de l'utilisateur donné,
     * avec leur score total sur les quiz attempts.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function groupMembers(User $user): JsonResponse
    {
        $group = $user->group;

        if (empty($group)) {
            // Aucun groupe défini, on renvoie une réponse vide avec message
            return response()->json([
                'success' => true,
                'message' => 'Aucun groupe défini pour cet utilisateur.',
                'data'    => [],
            ], 200);
        }

        // Récupérer tous les utilisateurs du même groupe, avec leur total_score
        $usersInGroup = User::where('group', $group)
            ->withSum('quizAttempts as total_score', 'score')
            ->get();

        // Préparer la réponse avec les infos utilisateur + score
        $result = [];

        foreach ($usersInGroup as $u) {
            $result[] = [
                'id'          => $u->id,
                'last_name'   => $u->last_name,
                'first_name'  => $u->first_name,
                'nickname'    => $u->nickname,
                'email'       => $u->email,
                'media'       => $u->media,
                'group'       => $u->group,
                'country'     => $u->country,
                'total_score' => $u->total_score ?? 0,
            ];
        }

        return response()->json([
            'success' => true,
            'group'   => $group,
            'data'    => $result,
        ], 200);
    }
}