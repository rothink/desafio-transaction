<?php

namespace Tests\Unit;

use App\Models\TipoUser;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TipoUserTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_quantidade_tipo_user()
    {
        $tipoUsers = TipoUser::all();
        $this->assertEquals(2, count($tipoUsers));
    }

    /**
     * Test user comum
     */
    public function test_tipo_user_comum()
    {
        $tipoUserComum = TipoUser::where(['name'=>'Comum'])->get()->first();
        $this->assertEquals(TipoUser::COMUM, $tipoUserComum->id);
    }

    /**
     * Teste usuário lojista
     */
    public function test_tipo_user_lojista()
    {
        $tipoUserLojista = TipoUser::where(['name'=>'Lojista'])->get()->first();
        $this->assertEquals(TipoUser::LOJISTA, $tipoUserLojista->id);
    }
}
