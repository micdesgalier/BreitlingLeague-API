<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreChoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Ajuste selon ta logique d'authentification/autorisation
        return true;
    }

    public function rules(): array
    {
        return [
            'code_id'          => 'required|integer|unique:choices,code_id',
            'media_id'         => 'nullable|integer|exists:media,id',
            'order'            => 'required|integer|min:0',
            'is_correct'       => 'required|boolean',
            'question_code_id' => 'required|integer|exists:questions,code_id',
        ];
    }
}