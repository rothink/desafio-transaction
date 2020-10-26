<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransferenciaRequest;
use App\Http\Resources\Transferencia as TransferenciaResource;
use App\Services\TransferenciaService;
use Illuminate\Http\Request;

class TransferenciaController extends AbstractController
{
    protected $requestValidate = TransferenciaRequest::class;
    protected $resource = TransferenciaResource::class;

    public function __construct(TransferenciaService $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Get(
     * path="/api/transaction",
     * summary="Listagem de Transferências",
     * description="Listagem de transferências entre usuários",
     * operationId="transaction/get",
     * tags={"transaction"},
     * security={ {"bearer": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIzIiwianRpIjoiZWNhZmNiOWY3ZDc2MGUxMmMwNjhkNmE4YjE5MGNlOGE0MjYzYmFlMjUzZDUzY2VhZjM0Nzk5YmViODc0NDNmZTQ1MTIwNzJiMWRkYmRmZGYiLCJpYXQiOjE2MDM2MDU1NDUsIm5iZiI6MTYwMzYwNTU0NSwiZXhwIjoxNjAzNjkxOTQ1LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.vLS4wGT7TS4b_CySPN_QQ_JyZXk2vWl8j3ksAoxes5lLwaveKF3t63lXl9AaGACp0x9HUMlHffkXLpL061Q70JzAdKd3MXhbx_4xe2H3YLabSnNqGyAjKcm_rvXcj-LQsWDcxvoRf-aWHEKiPEfSNr-7UwBZ_82UDaVVYBfH_MVbqgdM4j3DAQuDpv3OAJceMcLcXMafr2A4O65uXbosc3rlZPTFmmzQX58xY3PAn0lUoSxlh36rXMEnJY47ul0A60_knZ7WYfuqFA7Z0CnKQCpFaM_9bIgKEtRwYyYj09hLAWm7n6WBllyos10OSxsIfUUsOCb_LJFb5jDbZ2OkjO0B5SEjqV2ojRTeCn4e9mnlCDd33KeRFkUv9GNyXELNp0mnfpDJH-fFyzpsQvrrTvXDs7cfp42ColexuZcsggS9nA3PLYJunbEFo9vI9h3ECVu8zNRcGC8oTNuKdzf0PJp-YUp7j_Xu819mkaBkRAiMh-M7NFPM1JzNZ0gw3vwP-6ptacMww_yiMFCe_zzlk6iBWpIjavUhGgAeHJAdXs69AW1caAQBN8c5_ebiuJ1SUfu1dmeH85zOr1TUfZV90harEVnTh0J66HxqWnKZJEBXY4eCYinRHn8pgE6adCUjkTq_Rdik6bX5wnfNoYVmzzJJ8QX2EhErfU4fANWz6vU" }},
     *  @OA\Response(
     *      response=200,
     *      description="Success",
     *  )
     * )
     */
    public function index(Request $request)
    {
        return parent::index($request);
    }

    /**
     * @OA\Post(
     *      path="/api/transaction",
     *      summary="Realizar transferência",
     *      description="Realização de transfência",
     *      operationId="transaction/store",
     *      tags={"transaction"},
     *      security={ {"bearer": {} }},
     *      @OA\RequestBody(
     *          required=true,
     *          description="Parâmetros necessários para realizar a transferência entre usuários",
     *          @OA\JsonContent(
     *              required={"value","payer", "payee"},
     *              @OA\Property(
     *                  property="value",
     *                  type="integer",
     *                  format="integer",
     *                  example="10.000",
     *                  description="Valor da transferência"
     *              ),
     *              @OA\Property(
     *                  property="payer",
     *                  type="integer",
     *                  format="integer",
     *                  example="1",
     *                  description="User pagador"
     *              ),
     *              @OA\Property(
     *                  property="payee",
     *                  type="integer",
     *                  format="integer",
     *                  example="2",
     *                  description="User beneficiário"
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *      )
     *  )
     */
    public function store(Request $request)
    {
        return parent::store($request);
    }

    /**
     * @OA\Get(
     *      path="/api/transaction/pre-requisite",
     *      summary="Pré requisitos de uma transferência",
     *      description="Pré requisitos para realizar uma transferencia: Listagem de usuários do sistema",
     *      operationId="transaction/pre-requisite",
     *      tags={"transaction"},
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
