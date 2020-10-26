<?php

namespace App\Http\Resources;

use App\Http\Resources\User as UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Transferencia extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'value' => $this->value,
            'data_transferencia' => $this->data_transferencia_formatted,
            'payer' => new UserResource(User::find($this->payer)),
            'payee' => new UserResource(User::find($this->payee))
        ];
    }
}
