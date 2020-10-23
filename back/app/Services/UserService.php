<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserService extends AbstractService
{
    /**
     * @var UserRepository
     */
    protected $repository;

    protected $roleRepository;

    public function __construct(
        UserRepository $userRepository
    )
    {
        $this->repository = $userRepository;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getUserAuth()
    {
        return Auth::user();
//        return $this->fetchUser($user->getAuthIdentifier());
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
        DB::beginTransaction();
        $this->validadeOnInsert($params);
        $user = $this->repository->create($params);
        DB::commit();
        return $user;
    }

    /**
     * @return mixed
     */
    public function preRequisite()
    {
        $arr['sexo'] = generateSelectOption(['M' => 'Masculino', 'F' => 'Feminino']);
        return $arr;
    }

    /**
     * @param $params
     * @throws \Exception
     */
    public function validadeOnInsert($params)
    {
        if ($this->repository->existByEmail($params['email'])) {
            $validator = Validator::make([], []);
            $validator->errors()->add('email', 'E-mail já cadastrado');
            throw new ValidationException($validator);
        }

        if (isset($params['cpf'])) {
            if ($this->repository->existByCPF($params['cpf'])) {
                $validator = Validator::make([], []);
                $validator->errors()->add('cpf', 'CPF já cadastrado');
                throw new ValidationException($validator);
            }
        }

        if (isset($params['username'])) {
            $this->checkIfExistByUsername($params['username']);
        }
    }

    /**
     * Função que verifica se já existe um outro usuário pelo USERNAME
     * @param $username
     * @param array $id
     * @throws ValidationException
     */
    public function checkIfExistByUsername($username, $id = [])
    {
        if ($this->repository->existByUsername($username, $id)) {
            $validator = Validator::make([], []);
            $validator->errors()->add('username', 'Username já cadastrado');
            throw new ValidationException($validator);
        }
    }

    /**
     * @param $id
     * @param $params
     * @throws \Exception
     */
    public function validadeOnUpdate($id, $params)
    {
        if (isset($params['username'])) {
            $this->checkIfExistByUsername($params['username'], [$id]);
        }
    }

    /**
     * @param $id
     * @throws \Exception
     */
    public function validadeOnDelete($id)
    {
        if (\Auth::user()->id == $id) {
            throw new \Exception('Você não pode excluir seu próprio usuário');
        }
    }

    /**
     * @param $params
     * @return \App\User|\Illuminate\Database\Eloquent\Model|mixed
     * @throws \Exception
     */
    public function loginFacebook($params)
    {
        if (!$this->repository->existByEmail($params['email'])) {
            $params = $this->formatParamsLoginFacebook($params);
            $user = $this->save($params);
        }
        $user = $this->repository->findOrFailByEmail($params['email']);
        return $user;
    }

    /**
     * @param $params
     * @return mixed
     */
    public function formatParamsLoginFacebook($params)
    {
        if (isset($params['sexo'])) {
            if ($params['sexo'] == 'male') {
                $params['sexo'] = 'M';
            }
            if ($params['sexo'] == 'female') {
                $params['sexo'] = 'F';
            }
        }

        if (isset($params['birthday']) && !empty($params['birthday'])) {
            $params['birthday'] = Carbon::createFromFormat('m/d/Y', $params['birthday'])->toDateString();
        }

        $params['username'] = strtolower(strstr($params['email'], '@', true));

        return $params;
    }

    /**
     * Find by username
     * @param string $username
     * @return array
     * @throws \Exception
     */
    public function findByUsername(string $username)
    {
        $user = $this->repository->findOrFailByUsername($username);
        return $this->fetchUser($user->id);
    }

    /**
     * @param $id
     * @throws \Exception
     */
    public function verificarCadastroCompletoUser($id)
    {
        $user = $this->find($id);
        if ($user->isEmpresario()) {
            if (empty($user->cpf) || empty($user->sexo)) {
                throw new \Exception('Cadastro incompleto! Por favor, complete seu cadastro');
            }
        }
    }


    public function cadastrar($params)
    {
        if ($this->repository->existByEmail($params['email'])) {
            throw new \Exception('O E-mail se encontra em nossa base de dados');
        } else {
            return $this->repository->createExterno($params);
        }


    }


}
