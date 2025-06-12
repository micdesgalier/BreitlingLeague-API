<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuizActivityResultRequest extends FormRequest
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
     * Règles de validation pour mettre à jour un détail de résultat de quiz existant.
     *
     * @return array<string,string>
     */
    public function rules(): array
    {
        return [
            'score'                => 'sometimes|required|numeric|min:0',
            'correct_answer_count' => 'sometimes|required|integer|min:0',
            'activity_result_id'   => 'sometimes|required|integer|exists:activity_results,id',
        ];
    }
}