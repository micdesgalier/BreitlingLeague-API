<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuizMatchAnswerRequest extends FormRequest
{
    /**
     * Détermine si l’utilisateur est autorisé à effectuer cette requête.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // Par défaut autorisé, modifiez si besoin
        return true;
    }

    /**
     * Règles de validation pour mettre à jour une réponse QuizMatchAnswer existante.
     *
     * @return array<string,mixed>
     */
    public function rules(): array
    {
        return [
            // On n’autorise pas la modification de la liaison au match/question/participant
            'quiz_match_id'             => 'prohibited',
            'quiz_match_participant_id' => 'prohibited',
            'quiz_match_question_id'    => 'prohibited',

            // On peut changer le choix, la correction ou la date de réponse
            'choice_code_id'            => 'sometimes|required|string|exists:choices,code_id',
            'is_correct'                => 'sometimes|required|boolean',
            'answer_date'               => 'sometimes|required|date',
        ];
    }
}