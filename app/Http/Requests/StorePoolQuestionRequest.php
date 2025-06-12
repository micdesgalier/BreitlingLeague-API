<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePoolQuestionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'pool_code_id'     => 'required|integer|exists:pools,code_id',
            'question_code_id' => 'required|integer|exists:questions,code_id',
            'order'            => 'required|integer|min:0',
        ];
    }
}