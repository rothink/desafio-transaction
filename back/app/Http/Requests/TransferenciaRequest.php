<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferenciaRequest extends FormRequest
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
            'value' => 'required',
            'payer' => 'required',
            'payee' => 'required',
        ];
    }

    /**
     * Translate fields with user friendly name.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'value' => 'Valor',
            'payer' => 'Pagador',
            'payee' => 'Beneficiário'
        ];
    }
}
