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

        $userAuth = $this->findUserById($payload['payer']);
        $this->be($userAuth);

        $transferencia = $this->save($payload);

        $this->assertEquals($transferencia->payer, $payload['payer']);
        $this->assertEquals($transferencia->payee, $payload['payee']);
        $this->assertEquals($transferencia->value, $payload['value']);
    }

    /**
     * Exception de saldo insuficiente
     * @throws \Exception
     */
    public function test_transferir_saldo_insuficiente_exception(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage(TransferenciaExceptionMessages::$SALDO_INSUFICIENTE);

        $payload = $this->getPayload(9999999999);

        $userAuth = $this->findUserById($payload['payer']);
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

        $userAuth = $this->findUserById($payload['payer']);
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
        $userAuth = $this->findUserById($payload['payee']);
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

        $userAuth = $this->findUserById($payload['payer']);
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

        $payload['payer'] = $this->getBeneficiario('beneficiario2@user.com')->id;

        $userAuth = $this->findUserById($payload['payer']);
        $this->be($userAuth);

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

        $userAuth = $this->findUserById($payload['payer']);
        $this->be($userAuth);
        $this->save($payload);
    }

    /**
     * Retorna o usuario pelo ID
     * @param $id
     * @return User
     * @throws \Exception
     */
    private function findUserById($id): User
    {
        $userService = app(UserService::class);
        return $userService->find($id);
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
            'name' => 'Pagador',
            'email' => 'pagador@user.com',
            'tipo_user_id' => TipoUser::COMUM
        ];
        return factory(User::class)->create($pagador);
    }

    /**
     * Retorna um beneficiário do tipo lojista
     * @param string $email
     * @return User
     */
    private function getBeneficiario($email = 'beneficiario@user.com'): User
    {
        $beneficiario = [
            'name' => 'Beneficiario',
            'email' => $email,
            'tipo_user_id' => TipoUser::LOJISTA
        ];
        return factory(User::class)->create($beneficiario);
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
