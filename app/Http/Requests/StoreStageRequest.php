<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStageRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Ajuste selon tes règles d’accès (policies, rôles…)
        return true;
    }

    public function rules(): array
    {
        return [
            'code_id'               => 'required|integer|unique:stages,code_id',
            'quiz_code_id'          => 'required|integer|exists:quizzes,code_id',
            'order'                 => 'required|integer|min:0',
            'number_of_time_to_use' => 'required|integer|min:0',
        ];
    }
}