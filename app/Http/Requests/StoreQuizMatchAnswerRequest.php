<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuizMatchAnswerRequest extends FormRequest
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
     * Règles de validation pour créer une réponse de QuizMatchAnswer.
     *
     * @return array<string,mixed>
     */
    public function rules(): array
    {
        return [
            'quiz_match_id'             => 'required|string|exists:quiz_matches,id',
            'quiz_match_participant_id' => 'required|string|exists:quiz_match_participants,id',
            'quiz_match_question_id'    => 'required|string|exists:quiz_match_questions,id',
            'choice_code_id'            => 'required|string|exists:choices,code_id',
            'is_correct'                => 'required|boolean',
            'answer_date'               => 'required|date',
        ];
    }
}