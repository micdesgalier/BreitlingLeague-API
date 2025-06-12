<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePoolRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'stage_code_id'              => 'sometimes|required|integer|exists:stages,code_id',
            'order'                      => 'sometimes|required|integer|min:0',
            'number_of_question'         => 'sometimes|required|integer|min:0',
            'consecutive_correct_answer' => 'sometimes|required|integer|min:0',
            'minimum_correct_question'   => 'sometimes|required|integer|min:0',
        ];
    }
}