<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserAttemptChoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_attempt_question_id' => 'required|integer|exists:user_attempts,id',
            'choice_code_id'  => 'required|string|exists:choices,code_id',
            'is_selected'     => 'required|boolean',
            'is_correct'      => 'required|boolean',
        ];
    }
}