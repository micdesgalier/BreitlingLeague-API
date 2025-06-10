<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuizMatchQuestionRequest extends FormRequest
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
     * Règles de validation pour créer un QuizMatchQuestion.
     *
     * @return array<string,mixed>
     */
    public function rules(): array
    {
        return [
            // Le match doit exister
            'quiz_match_id'    => 'required|string|exists:quiz_matches,id',

            // La question doit exister dans questions (clé primaire code_id)
            'question_code_id' => 'required|string|exists:questions,code_id',

            // Ordre dans le match
            'order'            => 'required|integer|min:0',
        ];
    }
}