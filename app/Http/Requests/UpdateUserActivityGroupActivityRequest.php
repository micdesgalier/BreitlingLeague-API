<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserActivityGroupActivityRequest extends FormRequest
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
     * Règles de validation pour mettre à jour une entrée UserActivityGroupActivity existante.
     *
     * @return array<string,mixed>
     */
    public function rules(): array
    {
        return [
            'start_date'                 => 'sometimes|required|date',
            'end_date'                   => 'sometimes|required|date|after_or_equal:start_date',
            'progression_score'          => 'sometimes|required|numeric|min:0',
            'progression_score_percent'  => 'sometimes|required|numeric|min:0|max:100',
            'external_id'                => 'sometimes|required|integer',
            'user_id'                    => 'sometimes|required|integer|exists:users,id',
            'activity_group_activity_id' => 'sometimes|required|integer|exists:activity_group_activities,id',
            'activity_result_id'         => 'sometimes|required|integer|exists:activity_results,id',
        ];
    }
}