<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserActivityGroupActivityResultRequest extends FormRequest
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
     * Règles de validation pour créer un nouveau UserActivityGroupActivityResult.
     *
     * @return array<string,string>
     */
    public function rules(): array
    {
        return [
            'user_id'                    => 'required|integer|exists:users,id',
            'activity_group_activity_id' => 'required|integer|exists:activity_group_activities,id',
            'is_completed'               => 'required|boolean',
            'completion_date'            => 'required|date',
            'score'                      => 'required|numeric|min:0',
            'score_percent'              => 'required|numeric|min:0|max:100',
            'has_improved_score'         => 'required|boolean',
        ];
    }
}