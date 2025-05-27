<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuizRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Autorise tous les utilisateurs pour l’instant,
        // ou ajoute ici ta logique (policies, rôles…)
        return true;
    }

    public function rules(): array
    {
        return [
            'code_id'                   => 'required|integer|unique:quizzes,code_id',
            'type'                      => 'required|string|max:255',
            'label_translation_code_id' => 'nullable|integer|exists:label_translations,code_id',
            'shuffle_type'              => 'required|string|max:255',
            'shuffle_scope'             => 'required|string|max:255',
            'draw_type'                 => 'required|string|max:255',
            'max_user_attempt'          => 'required|integer|min:0',
            'is_unlimited'              => 'required|boolean',
            'duration'                  => 'required|integer|min:0',
            'question_duration'         => 'required|integer|min:0',
            'correct_choice_points'     => 'required|integer',
            'wrong_choice_points'       => 'required|integer',
        ];
    }
}