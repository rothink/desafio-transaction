<?php

namespace App\Services;

use App\Helper\Number;
use App\Models\TipoUser;
use App\Repositories\UserRepository;
use App\Services\ExceptionsMessages\UserExceptionMessages;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserService extends AbstractService
{
    /**
     * @var UserRepository
     */
    protected $repository;

    protected $tipoUserService;

    public function __construct(
        UserRepository $userRepository,
        TipoUserService $tipoUserService
    )
    {
        $this->repository = $userRepository;
        $this->tipoUserService = $tipoUserService;
    }

    /**
     * @return \Illuminate\Contracts\Auth\Authenticatable|mixed|null
     */
    public function getUserAuth()
    {
        return Auth::user();
    }

    /**
     * @param int $id
     * @return array
     * @throws \Exception
     */
    public function fetchUser(int $id)
    {
        return $this->repository->fetchUser($id);
    }

    /**
     * @param string $email
     * @return \App\User
     */
    public function findByEmail(string $email)
    {
        return $this->repository->findOrFailByEmail($email);
    }

    /**
     * @param array $params
     * @param bool $actionByUser
     * @return \Illuminate\Database\Eloquent\Model|mixed
     * @throws \Exception
     */
    public function save($params, $actionByUser = false)
    {
        $this->validateOnInsert($params);
        $user = $this->repository->create($params);
        return $user;
    }

    /**
     * @return mixed
     */
    public function preRequisite()
    {
        $arr['tipo_user'] = generateSelectOption($this->tipoUserService->getRepository()->list());
        return $arr;
    }

    /**
     * @param array $params
     * @return bool|void
     * @throws ValidationException
     */
    public function validateOnInsert(array $params)
    {
        if ($this->repository->existByEmail($params['email'])) {
            throw new \Exception(UserExceptionMessages::$EMAIL_JA_CADASTRADO_NO_SISTEMA);
        }

        if($params['tipo_user_id'] === TipoUser::COMUM) {
            if ($this->repository->existByCPF(Number::getOnlyNumber($params['cpf']))) {
                throw new \Exception(UserExceptionMessages::$CPF_JA_CADASTRADO_NO_SISTEMA);
            }
        }

        if($params['tipo_user_id'] === TipoUser::LOJISTA) {
            if ($this->repository->existByCNPJ(Number::getOnlyNumber($params['cnpj']))) {
                throw new \Exception(UserExceptionMessages::$CNPJ_JA_CADASTRADO_NO_SISTEMA);
            }
        }
    }

    /**
     * Cadastro externo
     * @param array $params
     * @return mixed
     * @throws \Exception
     */
    public function cadastroExterno(array $params)
    {
        $this->validateOnInsert($params);
        return $this->repository->createExterno($params);
    }
}
