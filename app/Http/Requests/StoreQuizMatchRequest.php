<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuizMatchRequest extends FormRequest
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
     * Règles de validation pour créer un QuizMatch.
     *
     * @return array<string,mixed>
     */
    public function rules(): array
    {
        return [
            // Le quiz associé doit exister dans la table quizzes, PK code_id
            'quiz_code_id' => 'required|string|exists:quizzes,code_id',

            // Statut du match
            'status'       => 'required|string|max:50',
        ];
    }
}