<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
     * Règles de validation pour mettre à jour un utilisateur existant.
     *
     * @return array<string,mixed>
     */
    public function rules(): array
    {
        // On récupère l’ID de l’utilisateur à mettre à jour via le Route Model Binding
        $user = $this->route('user');
        $userId = $user ? $user->id : null;

        return [
            'last_name'       => 'sometimes|required|string|max:100',
            'first_name'      => 'sometimes|required|string|max:100',
            'nickname'        => 'sometimes|nullable|string|max:100',
            'is_active'       => 'sometimes|required|boolean',
            'user_type'       => 'sometimes|required|string|max:50',
            'onboarding_done' => 'sometimes|required|boolean',
            'email'           => [
                'sometimes',
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($userId),
            ],
            'media'           => 'sometimes|nullable|string|max:255',

            // Nouveaux champs boutique et pays
            'boutique'        => 'sometimes|nullable|string|max:255',
            'pays'            => 'sometimes|nullable|string|max:255',
        ];
    }
}