<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoUser extends Model
{
    public $table = 'tipo_user';
    public $timestamps = false;

    /**
     * Constantes de tipos de usuários
     */
    const COMUM = 1;
    const LOJISTA = 2;
}
