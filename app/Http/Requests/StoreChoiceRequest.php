<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreChoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code_id'          => 'required|string|unique:choices,code_id',
            'media_id'         => 'nullable|integer|exists:media,id',
            'order'            => 'required|integer|min:0',
            'is_correct'       => 'required|boolean',
            'question_code_id' => 'required|string|exists:questions,code_id',
        ];
    }
}