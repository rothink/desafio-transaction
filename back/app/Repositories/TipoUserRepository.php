<?php


namespace App\Repositories;

use App\Models\TipoUser;

class TipoUserRepository extends AbstractRepository
{
    protected $model;

    public function __construct(TipoUser $model)
    {
        $this->model = $model;
    }
}
