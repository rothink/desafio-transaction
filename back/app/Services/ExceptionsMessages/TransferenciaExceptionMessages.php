<?php

namespace App\Services\ExceptionsMessages;

class TransferenciaExceptionMessages
{
    public static $VALOR_MAIOR_QUE_ZERO_ERROR = 'Você deve digitar um valor, maior que zero, para realizar uma transferência.';
    public static $USUARIO_PAGADOR_DIFERENTE_DO_USUARIO_LOGADO = 'Usuário pagador é diferente do usuário logado.';
    public static $NAO_PODE_TRANSFERIR_PARA_VOCE_MESMO = 'Você não pode transferir para você mesmo.';
    public static $LOJISTAS_NAO_FAZEM_TRANSFERENCIA = 'Lojistas não podem fazer transferências.';
    public static $SALDO_INSUFICIENTE = 'Saldo insuficiente para transferir';
    public static $TRANSFERENCIA_NAO_AUTORIZADA_POR_SERVICO_EXTERNO = 'Transferência não autorizada por serviço externo';
}
