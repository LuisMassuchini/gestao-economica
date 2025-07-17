<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFlagRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            // Validação crucial: o ID do grupo econômico é obrigatório
            // e deve existir na coluna 'id' da tabela 'economic_groups'.
            'economic_group_id' => ['required', 'exists:economic_groups,id'],
        ];
    }
}
