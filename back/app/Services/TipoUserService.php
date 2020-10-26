<?php

namespace App\Services;

use App\Repositories\TipoUserRepository;

class TipoUserService extends AbstractService
{
    /**
     * @var TipoUserRepository
     */
    protected $repository;

    public function __construct(
        TipoUserRepository $repository
    )
    {
        $this->repository = $repository;
    }
}
