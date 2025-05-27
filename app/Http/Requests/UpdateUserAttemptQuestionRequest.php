<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserAttemptQuestionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_attempt_id'   => 'sometimes|required|integer|exists:user_attempts,id',
            'order'             => 'sometimes|required|integer|min:0',
            'is_correct'        => 'sometimes|required|boolean',
            'score'             => 'sometimes|required|integer',
            'question_code_id'  => 'sometimes|required|integer|exists:questions,code_id',
            'combo_bonus_value' => 'sometimes|required|integer',
        ];
    }
}