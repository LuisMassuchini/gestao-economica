<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEconomicGroupRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Garante que o usuário está logado. Pode ter lógicas mais complexas aqui no futuro.
        return true;
    }

    public function rules(): array
    {
        return [
            // O nome é obrigatório, deve ser uma string e ter no máximo 255 caracteres.
            'name' => ['required', 'string', 'max:255'],
        ];
    }
}
