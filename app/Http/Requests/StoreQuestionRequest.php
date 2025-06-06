<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Ajuste selon ta logique d’auth (ex. vérifier un rôle)
        return true;
    }

    public function rules(): array
    {
        return [
            'code_id'                    => 'required|string|unique:questions,code_id',
            'label'                      => 'nullable|string|max:500',
            'is_active'                  => 'required|boolean',
            'media_id'                   => 'nullable|integer|exists:media,id',
            'type'                       => 'required|string|max:255',
            'is_choice_shuffle'          => 'required|boolean',
            'correct_value'              => 'required|string',
        ];
    }
}