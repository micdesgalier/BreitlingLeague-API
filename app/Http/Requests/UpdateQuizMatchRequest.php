<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuizMatchRequest extends FormRequest
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
     * Règles de validation pour mettre à jour un QuizMatch existant.
     *
     * @return array<string,mixed>
     */
    public function rules(): array
    {
        return [
            // On n’autorise en général qu’une mise à jour du statut,
            // mais on peut ajouter d’autres champs modifiables.
            'status' => 'sometimes|required|string|max:50',
        ];
    }
}