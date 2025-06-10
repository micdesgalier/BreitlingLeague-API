<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuizMatchQuestionRequest extends FormRequest
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
     * Règles de validation pour mettre à jour un QuizMatchQuestion existant.
     *
     * @return array<string,mixed>
     */
    public function rules(): array
    {
        return [
            // On n’autorise pas à modifier quiz_match_id ou question_code_id après création
            'quiz_match_id'    => 'prohibited',
            'question_code_id' => 'prohibited',

            // On peut modifier l’ordre si besoin
            'order'            => 'sometimes|required|integer|min:0',
        ];
    }
}