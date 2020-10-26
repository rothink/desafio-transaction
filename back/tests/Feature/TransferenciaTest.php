<?php

namespace Tests\Feature;

use Tests\TestCase;

class TransferenciaTest extends TestCase
{

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUsuarioNaoLogado(): void
    {
        $response = $this->get('/api/transaction');
        $response->assertStatus(302);
    }
}

