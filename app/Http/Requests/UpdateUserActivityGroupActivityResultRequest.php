<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserActivityGroupActivityResultRequest extends FormRequest
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
     * Règles de validation pour mettre à jour un UserActivityGroupActivityResult existant.
     *
     * @return array<string,mixed>
     */
    public function rules(): array
    {
        return [
            'user_id'                    => 'sometimes|required|integer|exists:users,id',
            'activity_group_activity_id' => 'sometimes|required|integer|exists:activity_group_activities,id',
            'is_completed'               => 'sometimes|required|boolean',
            'completion_date'            => 'sometimes|required|date',
            'score'                      => 'sometimes|required|numeric|min:0',
            'score_percent'              => 'sometimes|required|numeric|min:0|max:100',
            'has_improved_score'         => 'sometimes|required|boolean',
        ];
    }
}