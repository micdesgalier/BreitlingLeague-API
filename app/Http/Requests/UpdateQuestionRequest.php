<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuestionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'label'                      => 'nullable|integer|exists:label_translations,code_id',
            'is_active'                  => 'sometimes|required|boolean',
            'media_id'                   => 'nullable|string|max:500',
            'type'                       => 'sometimes|required|string|max:255',
            'is_choice_shuffle'          => 'sometimes|required|boolean',
            'correct_value'              => 'sometimes|required|string',
        ];
    }
}