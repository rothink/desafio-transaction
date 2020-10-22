<?php

namespace App\Services;

use App\Models\User;

class NotificacaoExternaService extends AbstractService
{
    protected $url;
    const NOTIFICACAO_ENVIADA = 'Enviado';

    public function __construct()
    {
        $this->url = env('APP_SERVICO_NOTIFICACAO_USUARIO');
    }

    /**
     * Dispara o serviço de notificacao de usuario
     * @param User $userPagador
     * @param User $userBeneficiario
     * @return bool
     */
    public function notificarUsuario(User $userPagador, User $userBeneficiario): bool
    {
        $messageBodyEmailNotification = "O usuário $userPagador->name, pagou o usuário $userBeneficiario->name";
        return $this->makeRequestExterna($this->url, self::NOTIFICACAO_ENVIADA);
    }
}
