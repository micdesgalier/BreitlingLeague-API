<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuestionRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Ajuste selon ta logique d’auth
        return true;
    }

    public function rules(): array
    {
        return [
            'label_translation_code_id'  => 'nullable|integer|exists:label_translations,code_id',
            'is_active'                  => 'sometimes|required|boolean',
            'media_id'                   => 'nullable|integer|exists:media,id',
            'type'                       => 'sometimes|required|string|max:255',
            'is_choice_shuffle'          => 'sometimes|required|boolean',
            'correct_value'              => 'sometimes|required|string',
        ];
    }
}