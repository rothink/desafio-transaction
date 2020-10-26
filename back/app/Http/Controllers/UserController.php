<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\User as UserResource;
use App\Services\UserService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends AbstractController
{
    protected $service;
    protected $requestValidate = UserRequest::class;
    protected $resource = UserResource::class;

    /**
     * UserController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->service = $userService;
    }

    /**
     * @OA\Get(
     *      path="/api/user",
     *      summary="Listagem de Usuários",
     *      description="Listagem de usuários do sistema",
     *      operationId="user/get",
     *      tags={"user"},
     *      security={ {"bearer": {} }},
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *      )
     *  )
     */
    public function index(Request $request)
    {
        return parent::index($request);
    }

    /**
     * @OA\Post(
     *      path="/api/user",
     *      summary="Cadastro de usuário",
     *      description="Cadastro externo de usuário",
     *      operationId="user/cadastro-externo",
     *      tags={"user"},
     *      security={ {"bearer": {} }},
     *      @OA\RequestBody(
     *          required=true,
     *          description="Parâmetros necessários para realizar o cadastro do usuário",
     *          @OA\JsonContent(
     *              required={"name","email", "tipo_user_id"},
     *              @OA\Property(
     *                  property="name",
     *                  type="string",
     *                  format="string",
     *                  example="Rodrigo",
     *                  description="Nome do usuário"
     *              ),
     *              @OA\Property(
     *                  property="email",
     *                  type="email",
     *                  format="email",
     *                  example="rodrigoluz@live.com",
     *                  description="E-mail do usuário"
     *              ),
     *              @OA\Property(
     *                  property="tipo_user_id",
     *                  type="integer",
     *                  format="integer",
     *                  example="1",
     *                  description="Tipo do usuário"
     *              ),
     *              @OA\Property(
     *                  property="cpf",
     *                  type="string",
     *                  format="string",
     *                  example="035.965.964-98",
     *                  description="Tipo do usuário comum"
     *              ),
     *              @OA\Property(
     *                  property="cnpj",
     *                  type="string",
     *                  format="string",
     *                  example="12.684.068/0001-58",
     *                  description="CNPJ do lojista"
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Success",
     *      )
     *  )
     */
    public function cadastroExterno(Request $request)
    {
        try {
            $user = $this->service->cadastroExterno($request->all());
            return $this->success($this->messageSuccessDefault, ['user' => $user], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * @OA\Get(
     *      path="/api/user/pre-requisite",
     *      summary="Pré requisitos do usuário",
     *      description="Pré requisitos para cadastrar um usuário novo no sistema",
     *      operationId="user/pre-requisite",
     *      tags={"user"},
     *      security={ {"bearer": {} }},
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *      )
     *  )
     */
    public function preRequisite($id = null)
    {
        return parent::preRequisite($id);
    }
}
