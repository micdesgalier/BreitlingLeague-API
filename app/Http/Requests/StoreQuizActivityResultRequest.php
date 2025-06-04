<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuizActivityResultRequest extends FormRequest
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
     * Règles de validation pour créer un nouveau détail de résultat de quiz.
     *
     * @return array<string,string>
     */
    public function rules(): array
    {
        return [
            'score'                => 'required|numeric|min:0',
            'correct_answer_count' => 'required|integer|min:0',
            'activity_result_id'   => 'required|integer|exists:activity_results,id',
        ];
    }
}