<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePoolRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Ajuste selon ton système d’authentification
        return true;
    }

    public function rules(): array
    {
        return [
            'code_id'                    => 'required|integer|unique:pools,code_id',
            'stage_code_id'              => 'required|integer|exists:stages,code_id',
            'order'                      => 'required|integer|min:0',
            'number_of_question'         => 'required|integer|min:0',
            'consecutive_correct_answer' => 'required|integer|min:0',
            'minimum_correct_question'   => 'required|integer|min:0',
        ];
    }
}