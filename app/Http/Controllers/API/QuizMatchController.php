<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\QuizMatch;
use App\Models\QuizMatchParticipant;
use App\Models\QuizMatchQuestion;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\QuizMatchAnswer;
use App\Http\Requests\StoreQuizMatchRequest;
use App\Http\Requests\UpdateQuizMatchRequest;

class QuizMatchController extends Controller
{
    /**
     * Récupérer la liste de tous les matchs avec leurs relations principales.
     */
    public function index(): JsonResponse
    {
        // Charger les relations pour que le front ait toutes les infos nécessaires
        $matches = QuizMatch::with(['quiz', 'participants', 'questions', 'nextTurnUser'])->get();
        return response()->json($matches);
    }

    /**
     * Créer un nouveau match (optionnel si on utilise startMatch pour créer un duel).
     */
    public function store(StoreQuizMatchRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['id'] = (string) Str::uuid();
        // Création du match sans initialiser next_turn_user_id ici (fait dans startMatch)
        $quizMatch = QuizMatch::create($data);
        $quizMatch->load(['quiz', 'participants', 'questions', 'nextTurnUser']);
        return response()->json($quizMatch, 201);
    }

    /**
     * Afficher un match spécifique avec ses relations.
     */
    public function show(QuizMatch $quizMatch): JsonResponse
    {
        $quizMatch->load(['quiz', 'participants', 'questions', 'nextTurnUser']);
        return response()->json($quizMatch);
    }

    /**
     * Mettre à jour un match existant.
     */
    public function update(UpdateQuizMatchRequest $request, QuizMatch $quizMatch): JsonResponse
    {
        $data = $request->validated();
        $quizMatch->update($data);
        $quizMatch->load(['quiz', 'participants', 'questions', 'nextTurnUser']);
        return response()->json($quizMatch);
    }

    /**
     * Supprimer un match.
     */
    public function destroy(QuizMatch $quizMatch): JsonResponse
    {
        $quizMatch->delete();
        return response()->json(null, 204);
    }

    /**
     * Démarrer un match entre 2 utilisateurs, en récupérant les questions via
     * Quiz → stages → pools → poolQuestions → question.
     * Le front fournit user_ids et quiz_code_id.
     * On choisit au hasard l’un des deux participants pour débuter : next_turn_user_id.
     */
    public function startMatch(Request $request): JsonResponse
    {
        // 1. Validation : on attend quiz_code_id + participants (array de 2 entrées {user_id, points_bet})
        $request->validate([
            'quiz_code_id'  => 'required|string|exists:quizzes,code_id',
            'participants'  => 'required|array|size:2',
            'participants.*.user_id'   => 'required|integer|exists:users,id',
            'participants.*.points_bet'=> 'required|integer|min:0',
        ]);

        $quizCode    = $request->input('quiz_code_id');
        $partsInput  = $request->input('participants'); // tableau de 2 éléments

        // 2. Charger le Quiz et ses relations imbriquées pour récupérer les questions
        $quiz = Quiz::with(['stages.pools.poolQuestions.question'])
            ->where('code_id', $quizCode)
            ->first();
        if (!$quiz) {
            return response()->json(['error' => 'Quiz introuvable'], 404);
        }

        // 3. Construire la liste unique de codes de question
        $questionCodes = [];
        foreach ($quiz->stages as $stage) {
            foreach ($stage->pools as $pool) {
                foreach ($pool->poolQuestions as $poolQuestion) {
                    $question = $poolQuestion->question;
                    if ($question) {
                        $code = $question->code_id;
                        if (!in_array($code, $questionCodes, true)) {
                            $questionCodes[] = $code;
                        }
                    }
                }
            }
        }
        if (empty($questionCodes)) {
            return response()->json(['error' => 'Aucune question trouvée pour ce quiz'], 400);
        }

        // 4. Extraire les user_ids pour le tirage du 1er tour
        $userIds = array_column($partsInput, 'user_id');
        // Choix aléatoire du participant qui commence
        $firstTurnUserId = $userIds[array_rand($userIds)];

        // 5. Créer le QuizMatch avec next_turn_user_id et status 'in_progress'
        $quizMatchId = (string) Str::uuid();
        $quizMatch = QuizMatch::create([
            'id'                => $quizMatchId,
            'quiz_code_id'      => $quizCode,
            'status'            => 'in_progress',
            'created_date'      => now(),
            'next_turn_user_id' => $firstTurnUserId,
        ]);

        // 6. Créer les participants avec leur points_bet respectif
        foreach ($partsInput as $part) {
            // On est sûr que part['user_id'] et part['points_bet'] existent et validés
            QuizMatchParticipant::create([
                'id'                => (string) Str::uuid(),
                'quiz_match_id'     => $quizMatchId,
                'user_id'           => $part['user_id'],
                'invitation_state'  => 'accepted', // ou 'pending' selon la logique métier
                'score'             => 0,
                'points_bet'        => $part['points_bet'],
                'is_winner'         => false,
                // last_answer_date reste null
            ]);
        }

        // 7. Créer les QuizMatchQuestion selon les codes collectés
        $order = 1;
        foreach ($questionCodes as $questionCode) {
            QuizMatchQuestion::create([
                'id'               => (string) Str::uuid(),
                'quiz_match_id'    => $quizMatchId,
                'question_code_id' => $questionCode,
                'order'            => $order++,
            ]);
        }

        // 8. Retour
        return response()->json([
            'id'                 => $quizMatchId,
            'first_turn_user_id' => $firstTurnUserId,
        ], 201);
    }

    /**
     * Afficher un match détaillé avec participants, questions, choix, et info du joueur actif.
     */
    public function detailedShow(string $id): JsonResponse
    {
        $quizMatch = QuizMatch::with([
            'participants.user',
            'questions.question.choices',
            'nextTurnUser', // pour inclure info de l'utilisateur dont c'est le tour
        ])->find($id);

        if (!$quizMatch) {
            return response()->json(['error' => 'QuizMatch not found'], 404);
        }

        return response()->json($quizMatch);
    }

    /**
     * Enregistrer la réponse d’un participant à une question et gérer le tour suivant.
     */
    public function answerQuestion(Request $request, QuizMatch $quizMatch, string $questionCode): JsonResponse
    {
        // Validation du body
        $request->validate([
            'user_id'        => 'required|integer|exists:users,id',
            'choice_code_id' => 'required|string|exists:choices,code_id',
        ]);

        $userId = $request->input('user_id');
        $choiceCode = $request->input('choice_code_id');

        // Charger participants, questions, quiz pour points, etc.
        $quizMatch->load(['participants', 'questions.question.choices', 'quiz']);

        // 1. Vérifier que le quizMatch est en cours
        /*if ($quizMatch->status !== 'in_progress') {
            return response()->json(['error' => 'Match non en cours'], 400);
        }*/

        // 2. Vérifier que c’est bien le tour de cet utilisateur
        if ($quizMatch->next_turn_user_id !== $userId) {
            return response()->json([
                'error'                     => 'Ce n\'est pas votre tour',
                'expected_next_turn_user_id'=> $quizMatch->next_turn_user_id,
                'provided_user_id'          => $userId,
            ], 403);
        }

        // 3. Vérifier que l’utilisateur est participant du match
        $participant = $quizMatch->participants->firstWhere('user_id', $userId);
        if (!$participant) {
            return response()->json(['error' => 'Utilisateur non participant au match'], 403);
        }

        // 4. Trouver la QuizMatchQuestion correspondante pour question_code_id = $questionCode
        $mqQuestion = $quizMatch->questions->firstWhere('question_code_id', $questionCode);
        if (!$mqQuestion) {
            return response()->json(['error' => 'Question non trouvée dans ce match'], 404);
        }

        // 5. Vérifier que le participant n’a pas déjà répondu à cette question
        $already = $participant->answers()
            ->where('quiz_match_question_id', $mqQuestion->id)
            ->exists();
        if ($already) {
            return response()->json(['error' => 'Vous avez déjà répondu à cette question'], 400);
        }

        // 6. Vérifier que le choix fourni appartient bien à la question
        $question = $mqQuestion->question;
        if (!$question) {
            return response()->json(['error' => 'Impossible de charger la question liée'], 500);
        }
        $choice = $question->choices->firstWhere('code_id', $choiceCode);
        if (!$choice) {
            return response()->json(['error' => 'Choix invalide pour cette question'], 400);
        }

        // 7. Déterminer si correct
        $isCorrect = (bool) $choice->is_correct;

        // 8. Enregistrer la réponse
        QuizMatchAnswer::create([
            'id'                        => (string) Str::uuid(),
            'quiz_match_id'             => $quizMatch->id,
            'quiz_match_participant_id' => $participant->id,
            'quiz_match_question_id'    => $mqQuestion->id,
            'choice_code_id'            => $choiceCode,
            'is_correct'                => $isCorrect,
            'answer_date'               => now(),
        ]);

        // 9. Mettre à jour le score du participant
        $points = 1000;
        $participant->increment('score', $points);
        $participant->update(['last_answer_date' => now()]);

        // 10. Déterminer l’autre participant pour passer le tour
        $otherParticipant = $quizMatch->participants
            ->first(fn($p) => $p->user_id !== $userId);
        if (!$otherParticipant) {
            // Cas étrange où il n’y a pas d’autre participant
            return response()->json(['error' => 'Impossible de trouver l’adversaire'], 500);
        }

        // 11. Mettre à jour next_turn_user_id pour l’autre participant
        $quizMatch->update([
            'next_turn_user_id' => $otherParticipant->user_id,
        ]);

        // 12. Réponse JSON
        return response()->json([
            'message'           => 'Réponse enregistrée',
            'is_correct'        => $isCorrect,
            'points_awarded'    => $points,
            'participant_score' => $participant->score, // score après incrément
            'next_turn_user_id' => $otherParticipant->user_id,
        ], 200);
    }

    /**
     * Enregistrer la fin d'un quiz
     */
    public function endQuizMatch(QuizMatch $quizMatch): JsonResponse
    {
        // Charger participants et leur user pour retour détaillé
        $quizMatch->load('participants.user');

        // On suppose un duel à 2 participants. Si vous voulez gérer plus, adapter la logique.
        $participants = $quizMatch->participants;

        if ($participants->count() < 2) {
            return response()->json([
                'error' => 'Nombre de participants insuffisant pour terminer le match'
            ], 400);
        }

        // On prend exactement deux participants pour comparaison.
        $p1 = $participants->get(0);
        $p2 = $participants->get(1);

        $score1 = $p1->score;
        $score2 = $p2->score;

        // Comparer les scores
        if ($score1 === $score2) {
            // Égalité
            $quizMatch->status = 'completed';
            $quizMatch->save();

            // Mettre is_winner à false pour les deux participants
            $p1->is_winner = false;
            $p2->is_winner = false;
            $p1->save();
            $p2->save();

            // Retour JSON incluant points_bet
            return response()->json([
                'participants' => [
                    [
                        'id'         => $p1->id,
                        'user_id'    => $p1->user_id,
                        'score'      => $score1,
                        'points_bet' => $p1->points_bet,
                        'is_winner'  => false,
                        'user'       => $p1->user, // eager-loaded
                    ],
                    [
                        'id'         => $p2->id,
                        'user_id'    => $p2->user_id,
                        'score'      => $score2,
                        'points_bet' => $p2->points_bet,
                        'is_winner'  => false,
                        'user'       => $p2->user,
                    ],
                ],
                'result' => 'tie',
                'status' => $quizMatch->status,
            ], 200);
        }

        // Déterminer le gagnant et le perdant
        if ($score1 > $score2) {
            $winner = $p1;
            $loser  = $p2;
        } else {
            $winner = $p2;
            $loser  = $p1;
        }

        // Mettre à jour is_winner
        $winner->is_winner = true;
        $loser->is_winner  = false;
        $winner->save();
        $loser->save();

        // Mettre à jour status du match et clear next_turn_user_id
        $quizMatch->status = 'completed';
        $quizMatch->next_turn_user_id = null;
        $quizMatch->save();

        // Construire la réponse JSON, en incluant points_bet
        $responseParticipants = [
            [
                'id'         => $p1->id,
                'user_id'    => $p1->user_id,
                'score'      => $score1,
                'points_bet' => $p1->points_bet,
                'is_winner'  => ($winner->id === $p1->id),
                'user'       => $p1->user,
            ],
            [
                'id'         => $p2->id,
                'user_id'    => $p2->user_id,
                'score'      => $score2,
                'points_bet' => $p2->points_bet,
                'is_winner'  => ($winner->id === $p2->id),
                'user'       => $p2->user,
            ],
        ];

        $responseWinner = [
            'user_id'    => $winner->user_id,
            'score'      => $winner->score,
            'points_bet' => $winner->points_bet,
            'user'       => $winner->user,
        ];

        return response()->json([
            'participants' => $responseParticipants,
            'winner'       => $responseWinner,
            'status'       => $quizMatch->status,
        ], 200);
    }
}