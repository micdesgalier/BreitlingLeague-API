<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserActivityGroupActivityRequest extends FormRequest
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
     * Règles de validation pour créer une nouvelle entrée UserActivityGroupActivity.
     *
     * @return array<string,string>
     */
    public function rules(): array
    {
        return [
            'start_date'                 => 'required|date',
            'end_date'                   => 'required|date|after_or_equal:start_date',
            'progression_score'          => 'required|numeric|min:0',
            'progression_score_percent'  => 'required|numeric|min:0|max:100',
            'external_id'                => 'required|integer',
            'user_id'                    => 'required|integer|exists:users,id',
            'activity_group_activity_id' => 'required|integer|exists:activity_group_activities,id',
            'activity_result_id'         => 'required|integer|exists:activity_results,id',
        ];
    }
}