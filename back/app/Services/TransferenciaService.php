<?php

namespace App\Services;

use App\Helper\Number;
use App\Models\TipoUser;
use App\Repositories\TransferenciaRepository;
use App\Services\ExceptionsMessages\TransferenciaExceptionMessages;
use Illuminate\Support\Facades\Auth;

class TransferenciaService extends AbstractService
{
    /**
     * Repository do proprio service Transferencia
     * @var TransferenciaRepository
     */
    protected $repository;

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @var AutorizadorExternoService
     */
    protected $autorizadorExternoService;

    /**
     * @var string[]
     */
    protected $with = ['payee', 'payer'];

    public function __construct(
        TransferenciaRepository $repository,
        UserService $userService,
        AutorizadorExternoService $autorizadorExternoService
    )
    {
        $this->repository = $repository;
        $this->userService = $userService;
        $this->autorizadorExternoService = $autorizadorExternoService;
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
     * @param array $params
     * @throws \Exception
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

        /**
         * Verificação se serviço externo AUTORIZA a transação.
         */
        $this->consultarServicoAutorizadorExterno();
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

    /**
     * Funcao que busca o servico autorizador externo
     * existente para finalizacao de uma transacao entre usuarios
     * @throws \Exception
     */
    private function consultarServicoAutorizadorExterno()
    {
        if (!$this->autorizadorExternoService->finalizarTransferencia()) {
            throw new \Exception(
                TransferenciaExceptionMessages::$TRANSFERENCIA_NAO_AUTORIZADA_POR_SERVICO_EXTERNO
            );
        }
    }

    /**
     * Funcao existente para atualizar a carteira do pagador
     * Sempre diminuindo o valor da carteira
     * @param $entity
     * @param $params
     * @throws \Exception
     */
    private function atualizaCarteiraDoPagador($entity, $params)
    {
        $idUsuarioPagador = $params['payer'];
        $valorTransferencia = $params['value'];
        $userPagador = $this->userService->find($idUsuarioPagador);
        $userPagador->carteira -= $valorTransferencia;
        $this->userService->update($idUsuarioPagador, $userPagador);
    }

    /**
     * Validaçao de regra de negocio
     * que diz que apenas usuarios
     * fazem transferencia no sistema
     * @param $params
     * @throws \Exception
     */
    private function verificarSeUsuarioPagadorNaoEhLojista($params)
    {
        $idUsuarioPagador = $params['payer'];
        $userPagador = $this->userService->find($idUsuarioPagador);
        if ($userPagador->tipo_user_id === TipoUser::LOJISTA) {
            throw new \Exception(TransferenciaExceptionMessages::$LOJISTAS_NAO_FAZEM_TRANSFERENCIA);
        }
    }

    /**
     * Atualizacao da carteira do beneficiario
     * @param $entity
     * @param $params
     * @throws \Exception
     */
    private function atualizaCarteiraDoBeneficiario($entity, $params)
    {
        $idUsuarioBeneficiario = $params['payee'];
        $valorTransferencia = $params['value'];
        $userBeneficiario = $this->userService->find($idUsuarioBeneficiario);
        $userBeneficiario->carteira += $valorTransferencia;
        $this->userService->update($idUsuarioBeneficiario, $userBeneficiario);
    }

    /**
     * Antes de transferir,
     * e importante saber se o usuario em questao
     * possui saldo suficiente na sua carteira.
     * @param $data
     * @throws \Exception
     */
    private function verificarSeUsuarioPagadorTemSaldo($data)
    {
        $carteiraUsuarioLogado = Auth::user()->carteira;
        $valorTransferencia = $data['value'];
        if ($carteiraUsuarioLogado < $valorTransferencia) {
            throw new \Exception(TransferenciaExceptionMessages::$SALDO_INSUFICIENTE);
        }
    }

    /**
     * Um usuario nao pode transferir dinheiro
     * para si mesmo!
     * @param $data
     * @throws \Exception
     */
    private function verificaSeTransferenciaSaoEntreUsuariosDiferentes($data)
    {
        $payer = $data['payer'];
        $payee = $data['payee'];

        if ($payee == $payer) {
            throw new \Exception(TransferenciaExceptionMessages::$NAO_PODE_TRANSFERIR_PARA_VOCE_MESMO);
        }
    }

    /**
     * Verifica se a transferencia
     * e maior que ZERO
     * @param $data
     * @throws \Exception
     */
    private function verificaSeValorTransferidoEhMaiorQueZero($data)
    {
        $valor = Number::formatCurrencyBr($data['value']);
        if ($valor == "0.00") {
            throw new \Exception(TransferenciaExceptionMessages::$VALOR_MAIOR_QUE_ZERO_ERROR);
        }
    }

    /**
     * Por seguranca, existe essa verificaçao pelo token
     * que garente que o usuario que esta logado,
     * e exatamente o usuario que esta pagando alguem.
     * @param $data
     * @throws \Exception
     */
    private function verificaSeUsuarioLogadoCondizComParametros($data)
    {
        $idUserLogado = Auth::user()->id;
        if ($data['payer'] !== $idUserLogado) {
            throw new \Exception(TransferenciaExceptionMessages::$USUARIO_PAGADOR_DIFERENTE_DO_USUARIO_LOGADO);
        }
    }
}
