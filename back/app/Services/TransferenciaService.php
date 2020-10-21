<?php

namespace App\Services;

use App\Helper\Number;
use App\Models\TipoUser;
use App\Repositories\TransferenciaRepository;
use App\Services\ExceptionsMessages\TransferenciaExceptionMessages;
use Illuminate\Support\Facades\Auth;

class TransferenciaService extends AbstractService
{
    protected $repository;
    protected $userService;
    protected $with = ['payee', 'payer'];

    public function __construct(TransferenciaRepository $repository, UserService $userService)
    {
        $this->repository = $repository;
        $this->userService = $userService;
    }

    /**
     * Antes de salvar, é importante fazer validações
     * Uma bem importante, é saber se o usuário que está logado
     * é o mesmo informado como pagador!
     * @param array $data
     * @return array|void
     * @throws \Exception
     */
    public function beforeSave(array $data)
    {
        $this->verificaSeValorTransferidoEhMaiorQueZero($data);
        $this->verificaSeUsuarioLogadoCondizComParametros($data);
        $this->verificaSeTransferenciaSaoEntreUsuariosDiferentes($data);
        $this->verificarSeUsuarioPagadorNaoEhLojista($data);
        $this->verificarSeUsuarioPagadorTemSaldo($data);
        return $data;
    }

    /**
     * Após salvar, ainda na mesma transação
     * faz a atualização da carteira dos usuários
     * @param $entity
     * @param $params
     */
    public function afterSave($entity, $params)
    {
        /**
         * Atualiza a carteira do payer
         */
        $this->atualizaCarteiraDoPagador($entity, $params);
        /*
         * Atualiza a carteira do payee
         */
        $this->atualizaCarteiraDoBeneficiario($entity, $params);
    }

    /**
     * Busca os préRequisitos para poder fazer uma transferência
     * ou seja: o usuário!
     * @return mixed
     */
    public function preRequisite()
    {
        $arr['users'] = generateSelectOption(
            $this->userService->getRepository()->list()
        );
        return $arr;
    }

    private function atualizaCarteiraDoPagador($entity, $params)
    {
        $idUsuarioPagador = $params['payer'];
        $valorTransferencia = $params['value'];
        $userPagador = $this->userService->find($idUsuarioPagador);
        $userPagador->carteira -= $valorTransferencia;
        $this->userService->update($idUsuarioPagador, $userPagador);
    }

    private function verificarSeUsuarioPagadorNaoEhLojista($params)
    {
        $idUsuarioPagador = $params['payer'];
        $userPagador = $this->userService->find($idUsuarioPagador);
        if ($userPagador->tipo_user_id === TipoUser::LOJISTA) {
            throw new \Exception(TransferenciaExceptionMessages::$LOJISTAS_NAO_FAZEM_TRANSFERENCIA);
        }
    }

    private function atualizaCarteiraDoBeneficiario($entity, $params)
    {
        $idUsuarioBeneficiario = $params['payee'];
        $valorTransferencia = $params['value'];
        $userBeneficiario = $this->userService->find($idUsuarioBeneficiario);
        $userBeneficiario->carteira += $valorTransferencia;
        $this->userService->update($idUsuarioBeneficiario, $userBeneficiario);
    }

    private function verificarSeUsuarioPagadorTemSaldo($data)
    {
        $carteiraUsuarioLogado = Auth::user()->carteira;
        $valorTransferencia = $data['value'];
        if ($carteiraUsuarioLogado < $valorTransferencia) {
            throw new \Exception(TransferenciaExceptionMessages::$SALDO_INSUFICIENTE);
        }
    }

    private function verificaSeTransferenciaSaoEntreUsuariosDiferentes($data)
    {
        $payer = $data['payer'];
        $payee = $data['payee'];

        if ($payee == $payer) {
            throw new \Exception(TransferenciaExceptionMessages::$NAO_PODE_TRANSFERIR_PARA_VOCE_MESMO);
        }
    }

    private function verificaSeValorTransferidoEhMaiorQueZero($data)
    {
        $valor = Number::formatCurrencyBr($data['value']);
        if ($valor == "0.00") {
            throw new \Exception(TransferenciaExceptionMessages::$VALOR_MAIOR_QUE_ZERO_ERROR);
        }
    }

    private function verificaSeUsuarioLogadoCondizComParametros($data)
    {
        $idUserLogado = Auth::user()->id;
        if ($data['payer'] !== $idUserLogado) {
            throw new \Exception(TransferenciaExceptionMessages::$USUARIO_PAGADOR_DIFERENTE_DO_USUARIO_LOGADO);
        }
    }
}
