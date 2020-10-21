<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|unique',
            'tipo_user_id' => 'required',
            'cpf' => '',
            'cnpj' => '',
        ];
    }

    /**
     * Translate fields with user friendly name.
     *
     * @return array
     */
    public function attributes(){
        return  [
            'name' => 'Nome',
            'email' => 'E-mail',
            'tipo_user_id' => 'Tipo de usuário',
            'cpf' => 'CPF',
            'cnpj' => 'CNPJ'
        ];
    }
}
