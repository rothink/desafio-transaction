<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransferenciaRequest;
use App\Http\Resources\Transferencia as TransferenciaResource;
use App\Services\TransferenciaService;

class TransferenciaController extends AbstractController
{
    protected $requestValidate = TransferenciaRequest::class;
    protected $resource = TransferenciaResource::class;

    public function __construct(TransferenciaService $service)
    {
        $this->service = $service;
    }
}
