<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends AbstractController
{
    protected $service;
    protected $requestValidate = UserRequest::class;

    /**
     * UserController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->service = $userService;
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function show(int $id)
    {
        return $this->ok($this->service->fetchUser($id));
    }

    /**
     * Cadastro externo de usuário
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function cadastrar(Request $request)
    {
        try {
            $user = $this->service->cadastrar($request->all());
            return $this->success('Cadastro efetuado com sucesso', ['user' => $user]);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * @param Request $request
     */
    public function recuperarSenha(Request $request)
    {

    }
}
