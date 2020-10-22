<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\TipoUser as TipoUserResource;
use App\Models\TipoUser;
use Illuminate\Http\Request;

class User extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'carteira' => $this->carteira,
            'tipo_user' => new TipoUserResource(TipoUser::find($this->tipo_user_id))
        ];
    }
}
