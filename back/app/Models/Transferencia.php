<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Transferencia extends Model
{
    public $table = 'transferencia';
    public $timestamps = true;
    protected $fillable = ['payer', 'payee', 'value'];
    protected $appends = [
        'data_transferencia_formatted'
    ];

    /**
     * Por default, o próprio sistema lista apenas transfências
     * em que o usuário logado faz parte
     * Sendo o que enviou, ou o que recebeu $
     * @param $queryBuilder
     * @return mixed
     */
    public function scopeQuery(Builder $queryBuilder)
    {
        $queryBuilder->where('payer', auth()->user()->id);
        $queryBuilder->orWhere('payee', auth()->user()->id);

        return $queryBuilder;
    }

    /**
     * Retorna os valores do BENEFICIÁRIO
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payee()
    {
        return $this->belongsTo(User::class, 'payee', 'id');
    }

    /**
     * Retorna os valores do PAGADOR
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payer()
    {
        return $this->belongsTo(User::class, 'payer', 'id');
    }

    /**
     * Retorna a data formatada
     * @return string
     */
    public function getDataTransferenciaFormattedAttribute()
    {
        return Carbon::createFromTimeStamp(strtotime($this->created_at))->format('d/m/Y  H:m:s');
    }
}
