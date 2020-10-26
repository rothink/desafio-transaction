<?php

namespace App\Repositories;

use App\Helper\Number;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserRepository extends AbstractRepository
{
    protected $model;

    /**
     * UserRepository constructor.
     * @param User $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function fetchOnlyUser(int $id)
    {
        return $this->model->where(['id' => $id])->firstOrFail();
    }

    /**
     * @param int $id
     * @return array
     * @throws \Exception
     */
    public function fetchUser(int $id)
    {
        $user = $this->model->where(['id' => $id])->firstOrFail();
        if (!$user) {
            throw ValidationException::withMessages(['message' => ' Usuário não encontrado']);
        }
        $auth_user = $user->findOrFail($user->id);

        return [
            'user' => $user,
            'authenticated' => true
        ];
    }

    /**
     * @param string $username
     * @return User
     */
    public function findOrFailByUsername(string $username): User
    {
        return $this->model->where(['username' => $username])->firstOrFail();
    }

    /**
     * @param string $email
     * @return User
     */
    public function findOrFailByEmail(string $email): User
    {
        return $this->model->with(['empresaSistema'])->where(['email' => $email])->firstOrFail();
    }

    /**
     * @param $email
     * @return mixed
     */
    public function existByEmail($email)
    {
        return $this->model->where(['email' => $email])->exists();
    }

    /**
     * @param $cpf
     * @return mixed
     */
    public function existByCPF(string $cpf)
    {
        return $this->model->where(['cpf' => $cpf])->exists();
    }

    public function existByCNPJ(string $cnpj)
    {
        return $this->model->where(['cnpj' => $cnpj])->exists();
    }

    /**
     * Tenta validar usuário pelo token
     * @param Request $request
     * @return array
     * @throws \Exception
     */
    public function check(Request $request)
    {
        $id = $request->user()->id;
        return $this->fetchUser($id);
    }

    public function createExterno($data)
    {
        $data = $this->formatParams($data, true);
        return $this->model->forceCreate($data);
    }

    /**
     * IN
     * @param array $in
     * @return mixed
     */
    public function whereIn(array $in)
    {
        return $this->model->whereIn('id', $in)->get();
    }

    /**
     * Retorna em forma de lista para selecte
     * @return mixed
     */
    public function listToTransferencia($sortBy = 'name', $pluck = 'name'): array
    {
        return $this
            ->model
            ->all()
            ->sortBy($sortBy)
            ->pluck($pluck, 'id')
            ->all();
    }

    /**
     * @param $params
     * @param bool $actionByUser
     * @return array|mixed
     */
    public function formatParams($params, $actionByUser = false)
    {
        $formatted = [];

        if (isset($params['name'])) {
            $formatted['name'] = ucwords($params['name']);
        }

        if (isset($params['email'])) {
            $formatted['email'] = $params['email'];
        }

        if (isset($params['tipo_user_id'])) {
            $formatted['tipo_user_id'] = $params['tipo_user_id'];
        }

        if (isset($params['carteira'])) {
            $formatted['carteira'] = Number::formatCurrencyBr($params['carteira']);
        }

        if (isset($params['cpf'])) {
            $formatted['cpf'] = Number::getOnlyNumber($params['cpf']);
        }

        if (isset($params['cnpj'])) {
            $formatted['cnpj'] = Number::getOnlyNumber($params['cnpj']);
        }

        if ($actionByUser) {
            $formatted['password'] = bcrypt($params['password']);
        }

        return $formatted;
    }
}
