<?php

namespace App\Http\Resources;

use App\Http\Resources\TipoUser as TipoUserResource;
use App\Models\TipoUser;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        $arrayUser = [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'carteira' => $this->carteira,
            'tipo_user' => new TipoUserResource(TipoUser::find($this->tipo_user_id))
        ];

        if ($this->tipo_user_id === TipoUser::COMUM) {
            $arrayUser['cpf'] = $this->cpf;
        }

        if ($this->tipo_user_id === TipoUser::LOJISTA) {
            $arrayUser['cnpj'] = $this->cnpj;
        }

        return $arrayUser;
    }
}
