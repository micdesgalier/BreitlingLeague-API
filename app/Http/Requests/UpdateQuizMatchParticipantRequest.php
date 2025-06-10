<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuizMatchParticipantRequest extends FormRequest
{
    /**
     * Détermine si l’utilisateur est autorisé à effectuer cette requête.
     * Ajustez selon votre logique (auth, rôles, etc.).
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // Pour l’instant on autorise toujours. Changez si nécessaire.
        return true;
    }

    /**
     * Règles de validation pour mettre à jour un QuizMatchParticipant existant.
     *
     * @return array<string,mixed>
     */
    public function rules(): array
    {
        return [
            // Normalement on ne change pas quiz_match_id ou user_id,
            // mais si besoin, vous pouvez autoriser leur modification en retirant 'prohibited'.
            'quiz_match_id'    => 'prohibited',
            'user_id'          => 'prohibited',

            'invitation_state' => 'sometimes|required|string|max:50',
            'last_answer_date' => 'sometimes|nullable|date',
            'score'            => 'sometimes|integer|min:0',
            'points_bet'       => 'sometimes|integer|min:0',
            'is_winner'        => 'sometimes|boolean',
        ];
    }
}