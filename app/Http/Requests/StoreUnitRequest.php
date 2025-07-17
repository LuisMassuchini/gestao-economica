<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUnitRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'trading_name' => ['required', 'string', 'max:255'],
            'company_name' => ['required', 'string', 'max:255'],
            // O CNPJ é obrigatório e deve ser único na tabela 'units'.
            // Usamos Rule::unique para ignorar o CNPJ da unidade atual ao editar.
            'cnpj' => ['required', 'string', 'max:18', Rule::unique('units')->ignore($this->unit)],
            'flag_id' => ['required', 'exists:flags,id'],
        ];
    }
}
