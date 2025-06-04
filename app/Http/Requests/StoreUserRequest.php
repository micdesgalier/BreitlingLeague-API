<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Détermine si l’utilisateur est autorisé à effectuer cette requête.
     * Ajuste selon ta logique d’authentification/autorisation.
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
            'last_name'              => 'required|string|max:100',
            'first_name'             => 'required|string|max:100',
            'nickname'               => 'nullable|string|max:100',
            'is_active'              => 'required|boolean',
            'user_type'              => 'required|string|max:50',
            'onboarding_done'        => 'required|boolean',
            'fk_registration_key_id' => 'nullable|integer|exists:registration_keys,id',
            'email'                  => 'required|string|email|max:255|unique:users,email',
            // Si vous gérez le mot de passe, décommentez la ligne suivante :
            // 'password' => 'required|string|min:8|confirmed',
        ];
    }
}