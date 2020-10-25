<?php

namespace Tests\Unit;

use App\Models\TipoUser;
use App\Models\Transferencia;
use App\Models\User;
use App\Services\AutorizadorExternoService;
use App\Services\ExceptionsMessages\TransferenciaExceptionMessages;
use App\Services\TransferenciaService;
use App\Services\UserService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TransferenciaTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Caminho feliz do transferir
     * @throws \Exception
     */
    public function test_transferir(): void
    {
        $payload = $this->getPayload();

        $userAuth = $this->getPagador();
        $this->be($userAuth);

        $this
            ->mock(UserService::class)
            ->shouldReceive('getUserAuth')
            ->andReturn($userAuth)
            ->shouldReceive('find')
            ->andReturn($userAuth)
            ->shouldReceive('update')
            ->andReturnTrue();

        $this
            ->mock(TransferenciaService::class)
            ->shouldReceive('save')
            ->with($payload)
            ->andReturn(new Transferencia($payload));

        $transferencia = $this->save($payload);

        $this->assertEquals($transferencia->payer, $payload['payer']);
        $this->assertEquals($transferencia->payee, $payload['payee']);
        $this->assertEquals($transferencia->value, $payload['value']);
    }

    /**
     * @group test_transferir_saldo_insuficiente_exception
     * Exception de saldo insuficiente
     * @throws \Exception
     */
    public function test_transferir_saldo_insuficiente_exception(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage(TransferenciaExceptionMessages::$SALDO_INSUFICIENTE);

        $payload = $this->getPayload(9999999999);

        $userAuth = $this->getPagador();
        $this->be($userAuth);

        $this->save($payload);
    }

    /**
     * Exception de tentativa de transferencia de um valor zerado
     * @throws \Exception
     */
    public function test_transferir_valor_zero_exception(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage(TransferenciaExceptionMessages::$VALOR_MAIOR_QUE_ZERO_ERROR);

        $payload = $this->getPayload(0.00);

        $userAuth = $this->getPagador($payload['payer']);
        $this->be($userAuth);

        $this->save($payload);
    }

    /**
     * Exception de transferencia de usuario logado diferente do usuario pagador
     * @throws \Exception
     */
    public function test_transferir_usuario_logado_diferente_do_pagador_exception(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage(TransferenciaExceptionMessages::$USUARIO_PAGADOR_DIFERENTE_DO_USUARIO_LOGADO);

        $payload = $this->getPayload();
        $userAuth = $this->getOtherUser();
        $this->be($userAuth);

        $this->save($payload);
    }

    /**
     * Exception de tentativa de transferencia para o mesmo usuario
     * @throws \Exception
     */
    public function test_transferir_mesmo_usuario_exception(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage(TransferenciaExceptionMessages::$NAO_PODE_TRANSFERIR_PARA_VOCE_MESMO);

        $payload = $this->getPayload();

        $userAuth = $this->getPagador($payload['payer']);
        $this->be($userAuth);

        $payload['payee'] = $userAuth->id;

        $this->save($payload);
    }

    /**
     * Exception de transferencia usuario pagador sendo um lojista
     * @throws \Exception
     */
    public function test_transferir_usuario_pagador_eh_lojista_exception(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage(TransferenciaExceptionMessages::$LOJISTAS_NAO_FAZEM_TRANSFERENCIA);

        $payload = $this->getPayload();

        $userAuth = $this->getPagador();
        $this->be($userAuth);

        $userLojistaMock = new User();
        $userLojistaMock->tipo_user_id = TipoUser::LOJISTA;


        $this
            ->mock(UserService::class)
            ->shouldReceive('find')
            ->andReturn($userLojistaMock);

        $this->save($payload);
    }

    /**
     * Exception de nao autorizacao pelo servico externo
     * @throws \Exception
     */
    public function test_transferir_com_falha_servico_autorizacao_externa_exception():void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage(TransferenciaExceptionMessages::$TRANSFERENCIA_NAO_AUTORIZADA_POR_SERVICO_EXTERNO);

        /**
         * Mock de serviço externo
         */
        $this
            ->mock(AutorizadorExternoService::class)
            ->shouldReceive('finalizarTransferencia')
            ->andReturnFalse();

        $payload = $this->getPayload();
        $userAuth = $this->getPagador();
        $this->be($userAuth);
        $this->save($payload);
    }

    /**
     * Fnction generica de save
     * @param $payload
     * @return Transferencia|null
     */
    private function save($payload): ?Transferencia
    {
        $serviceTransferencia = app(TransferenciaService::class);
        return $serviceTransferencia->save($payload);
    }

    /**
     * Retorna um pagador do tipo de usuário comum
     * @return User
     */
    private function getPagador(): User
    {
        $pagador = [
            'id' => 1,
            'name' => 'Pagador',
            'email' => 'pagador@user.com',
            'tipo_user_id' => TipoUser::COMUM,
            'carteira' => 100.00
        ];
        return new User($pagador);
    }

    /**
     * Retorna um beneficiário do tipo lojista
     * @param string $email
     * @return User
     */
    private function getBeneficiario($email = 'beneficiario@user.com'): User
    {
        $beneficiario = [
            'id' => 2,
            'name' => 'Beneficiario',
            'email' => $email,
            'tipo_user_id' => TipoUser::LOJISTA,
            'carteira' => 10.000
        ];
        return new User($beneficiario);
    }

    /**
     * Busca um usuário diferente dos beneficiário e pagador
     * @return User
     */
    private function getOtherUser(): User
    {
        $anotherUser = [
            'id' => 3,
            'name' => 'Outro usuário',
            'email' => 'email@email.com',
            'tipo_user_id' => TipoUser::COMUM,
            'carteira' => 10.000
        ];
        return new User($anotherUser);
    }

    /**
     * Generic payload
     * @param float $value
     * @return array
     */
    private function getPayload($value = 100.00): array
    {
        return [
            'value' => $value,
            'payer' => $this->getPagador()->id,
            'payee' => $this->getBeneficiario()->id
        ];
    }
}
