<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePoolQuestionRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Ajuste selon ta logique d’auth
        return true;
    }

    public function rules(): array
    {
        return [
            'order' => 'sometimes|required|integer|min:0',
        ];
    }
}