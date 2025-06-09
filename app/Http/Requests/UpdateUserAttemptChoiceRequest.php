<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserAttemptChoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Ajuste selon ta logique d’auth
        return true;
    }

    public function rules(): array
    {
        return [
            'user_attempt_question_id' => 'sometimes|required|integer|exists:user_attempts,id',
            'choice_code_id'  => 'sometimes|required|string|exists:choices,code_id',
            'is_selected'     => 'sometimes|required|boolean',
            'is_correct'      => 'sometimes|required|boolean',
        ];
    }
}