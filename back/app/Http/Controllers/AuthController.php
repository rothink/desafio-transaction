<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $request;
    protected $userRepository;
    protected $module = 'user';

    /**
     * AuthController constructor.
     * @param Request $request
     * @param UserRepository $user
     */
    public function __construct(Request $request, UserRepository $user)
    {
        $this->request = $request;
        $this->userRepository = $user;
    }

    /**
     * Busca o usuario logado
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function me(Request $request)
    {
        return $this->ok($this->userRepository->check($request));
    }
}
