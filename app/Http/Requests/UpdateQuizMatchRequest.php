<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuizMatchRequest extends FormRequest
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
     * Règles de validation pour mettre à jour un QuizMatch existant.
     *
     * @return array<string,mixed>
     */
    public function rules(): array
    {
        return [
            'status' => 'sometimes|required|string|max:50',
        ];
    }
}