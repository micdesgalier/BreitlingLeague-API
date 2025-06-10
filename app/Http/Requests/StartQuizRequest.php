<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StartQuizRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Pas d’auth ici, on autorise la requête
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id'    => ['required','integer','exists:users,id'],
            // facultatif : filtres, ex. 'category_id' => ['nullable','integer','exists:categories,id'], etc.
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'Le champ user_id est requis.',
            'user_id.exists'   => 'L’utilisateur spécifié n’existe pas.',
        ];
    }
}