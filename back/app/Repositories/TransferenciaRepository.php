<?php


namespace App\Repositories;

use App\Helper\Number;
use App\Models\Transferencia;

class TransferenciaRepository extends AbstractRepository
{
    protected $model;

    public function all($params = null, $with = [])
    {
        return $this->model->with($with)->orderBy('created_at', 'desc')->query($params)->get();
    }

    public function __construct(Transferencia $model)
    {
        $this->model = $model;
    }

    public function formatParams($params)
    {
        $formatted = [];

        if (isset($params['value'])) {
            $formatted['value'] = Number::formatCurrencyBr($params['value']);
        }

        if (isset($params['payer'])) {
            $formatted['payer'] = $params['payer'];
        }

        if (isset($params['payee'])) {
            $formatted['payee'] = $params['payee'];
        }

        return $formatted;
    }
}
