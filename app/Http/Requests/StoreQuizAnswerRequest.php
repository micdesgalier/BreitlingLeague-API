<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuizAnswerRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Ici on autorise toujours, car la logique d'utilisateur est gérée dans le controller
        return true;
    }

    public function rules(): array
    {
        return [
            // Vous pouvez, si besoin, passer en body un user_id pour tests :
            'user_id'           => 'sometimes|integer|exists:users,id',

            // Les choix sélectionnés pour la question (une ou plusieurs)
            'selected_choices'  => 'required|array|min:1',
            'selected_choices.*'=> 'string|exists:choices,code_id',

            // Position/order facultatif
            'order'             => 'sometimes|integer|min:0',
        ];
    }
}