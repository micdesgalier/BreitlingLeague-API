<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
     * Règles de validation pour mettre à jour un utilisateur existant.
     *
     * @return array<string,mixed>
     */
    public function rules(): array
    {
        // On récupère l’ID de l’utilisateur à mettre à jour via le Route Model Binding
        $userId = $this->route('user')->id;

        return [
            'last_name'              => 'sometimes|required|string|max:100',
            'first_name'             => 'sometimes|required|string|max:100',
            'nickname'               => 'nullable|string|max:100',
            'is_active'              => 'sometimes|required|boolean',
            'user_type'              => 'sometimes|required|string|max:50',
            'onboarding_done'        => 'sometimes|required|boolean',
            'fk_registration_key_id' => 'nullable|integer|exists:registration_keys,id',
            'email'                  => [
                'sometimes',
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($userId),
            ],
            // Si vous gérez le changement de mot de passe, décommentez :
            // 'password' => 'sometimes|required|string|min:8|confirmed',
        ];
    }
}