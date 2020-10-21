<?php

namespace App\Services;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;


class AutorizadorExternoService
{
    protected $url;
    const TRANSACAO_AUTORIZADA = 'Autorizado';

    public function __construct()
    {
        $this->url = env('APP_SERVICO_AUTORIZADOR_EXTERNO');
    }

    /**
     * Consulta algum serviço externo
     * para o OK da finalizacao da transferencia
     * @return bool
     */
    public function finalizarTransferencia(): bool
    {
        $response = Http::get($this->url);
        return
            $response->status() === Response::HTTP_OK &&
            $response->json()['message'] == self::TRANSACAO_AUTORIZADA;
    }
}
