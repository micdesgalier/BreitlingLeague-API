<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateChoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Ajuste selon ta logique d'authentification/autorisation
        return true;
    }

    public function rules(): array
    {
        return [
            'media_id'         => 'nullable|integer|exists:media,id',
            'order'            => 'sometimes|required|integer|min:0',
            'is_correct'       => 'sometimes|required|boolean',
            'question_code_id' => 'sometimes|required|integer|exists:questions,code_id',
        ];
    }
}