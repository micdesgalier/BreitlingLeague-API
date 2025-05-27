<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStageRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Ajuste selon tes règles d’accès
        return true;
    }

    public function rules(): array
    {
        return [
            'quiz_code_id'          => 'sometimes|required|integer|exists:quizzes,code_id',
            'order'                 => 'sometimes|required|integer|min:0',
            'number_of_time_to_use' => 'sometimes|required|integer|min:0',
        ];
    }
}