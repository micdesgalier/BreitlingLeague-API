<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserAttemptRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'start_date'         => 'nullable|date',
            'end_date'           => 'nullable|date|after_or_equal:start_date',
            'quiz_code_id'       => 'sometimes|required|string|exists:quizzes,code_id',
            'user_id'            => 'sometimes|required|integer|exists:users,id',
            'is_completed'       => 'sometimes|required|boolean',
            'duration'           => 'nullable|integer|min:0',
            'score'              => 'nullable|integer',
            'initial_score'      => 'nullable|integer',
            'combo_bonus_score'  => 'nullable|integer',
            'time_bonus_score'   => 'nullable|integer',
        ];
    }
}