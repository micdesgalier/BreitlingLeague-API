<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateActivityResultRequest extends FormRequest
{
    /**
     * Détermine si l’utilisateur est autorisé à effectuer cette requête.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Règles de validation pour mettre à jour un résultat d’activité existant.
     *
     * @return array<string,string>
     */
    public function rules(): array
    {
        return [
            'duration' => 'sometimes|required|integer|min:0',
        ];
    }
}