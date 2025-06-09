<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserAttemptQuestionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_attempt_id'   => 'required|integer|exists:user_attempts,id',
            'order'             => 'required|integer|min:0',
            'is_correct'        => 'required|boolean',
            'score'             => 'required|integer',
            'question_code_id'  => 'required|string|exists:questions,code_id',
            'combo_bonus_value' => 'required|integer',
        ];
    }
}