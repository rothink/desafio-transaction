<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransferenciaRequest;
use App\Services\TransferenciaService;

class TransferenciaController extends AbstractController
{
    protected $requestValidate = TransferenciaRequest::class;

    public function __construct(TransferenciaService $service)
    {
        $this->service = $service;
    }
}
