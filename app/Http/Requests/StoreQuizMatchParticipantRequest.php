<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuizMatchParticipantRequest extends FormRequest
{
    /**
     * Détermine si l’utilisateur est autorisé à effectuer cette requête.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // Pour l’instant on autorise toujours. 
        return true;
    }

    /**
     * Règles de validation pour créer un QuizMatchParticipant.
     *
     * @return array<string,mixed>
     */
    public function rules(): array
    {
        return [
            // Le match doit exister
            'quiz_match_id'    => 'required|string|exists:quiz_matches,id',

            // L’utilisateur doit exister
            'user_id'          => 'required|integer|exists:users,id',

            // État de l’invitation : chaîne, ajustez la longueur ou liste si besoin
            'invitation_state' => 'required|string|max:50',

            // Date de dernière réponse (facultatif)
            'last_answer_date' => 'nullable|date',

            // Score initial ou courant (facultatif, par défaut 0)
            'score'            => 'nullable|integer|min:0',

            // Paris de points (facultatif)
            'points_bet'       => 'nullable|integer|min:0',

            // Indique si gagnant (facultatif)
            'is_winner'        => 'nullable|boolean',
        ];
    }
}