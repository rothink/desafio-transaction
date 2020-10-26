<?php

namespace Tests\Unit;

use App\Models\TipoUser;
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
    public function testQuantidadeTipoUser(): void
    {
        $tipoUsers = TipoUser::all();
        $this->assertEquals(2, count($tipoUsers));
    }

    /**
     * Test user comum
     */
    public function testTipoUserComum(): void
    {
        $tipoUserComum = TipoUser::where(['name' => 'Comum'])->get()->first();
        $this->assertEquals(TipoUser::COMUM, $tipoUserComum->id);
    }

    /**
     * Teste usuário lojista
     */
    public function testTipoUserLojista(): void
    {
        $tipoUserLojista = TipoUser::where(['name' => 'Lojista'])->get()->first();
        $this->assertEquals(TipoUser::LOJISTA, $tipoUserLojista->id);
    }
}
