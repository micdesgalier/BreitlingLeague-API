<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreActivityResultRequest extends FormRequest
{
    /**
     * Détermine si l’utilisateur est autorisé à effectuer cette requête.
     * Ajustez selon votre logique d’authentification/autorisation.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Règles de validation pour créer un nouveau résultat d’activité.
     *
     * @return array<string,string>
     */
    public function rules(): array
    {
        return [
            'duration' => 'required|integer|min:0',
        ];
    }
}