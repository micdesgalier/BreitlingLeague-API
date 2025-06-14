<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateChoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'media_id'         => 'nullable|integer|exists:media,id',
            'order'            => 'sometimes|required|integer|min:0',
            'is_correct'       => 'sometimes|required|boolean',
            'question_code_id' => 'sometimes|required|string|exists:questions,code_id',
        ];
    }
}