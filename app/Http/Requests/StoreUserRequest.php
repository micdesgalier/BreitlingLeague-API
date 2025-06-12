<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
     * Règles de validation pour créer un nouvel utilisateur.
     *
     * @return array<string,string>
     */
    public function rules(): array
    {
        return [
            'last_name'       => 'required|string|max:100',
            'first_name'      => 'required|string|max:100',
            'nickname'        => 'nullable|string|max:100',
            'is_active'       => 'required|boolean',
            'user_type'       => 'required|string|max:50',
            'onboarding_done' => 'required|boolean',
            'email'           => 'required|string|email|max:255|unique:users,email',
            'media'           => 'nullable|string|max:255',

            // Nouveaux champs boutique et pays
            'boutique'        => 'nullable|string|max:255',
            'pays'            => 'nullable|string|max:255',

            // Si vous gérez le mot de passe, décommentez ou ajustez la règle
            // 'password' => 'required|string|min:8|confirmed',
        ];
    }
}