<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuizRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type'                      => 'sometimes|required|string|max:255',
            'label_translation_code_id' => 'nullable|integer|exists:label_translations,code_id',
            'shuffle_type'              => 'sometimes|required|string|max:255',
            'shuffle_scope'             => 'sometimes|required|string|max:255',
            'draw_type'                 => 'sometimes|required|string|max:255',
            'max_user_attempt'          => 'sometimes|required|integer|min:0',
            'is_unlimited'              => 'sometimes|required|boolean',
            'duration'                  => 'sometimes|required|integer|min:0',
            'question_duration'         => 'sometimes|required|integer|min:0',
            'correct_choice_points'     => 'sometimes|required|integer',
            'wrong_choice_points'       => 'sometimes|required|integer',
        ];
    }
}