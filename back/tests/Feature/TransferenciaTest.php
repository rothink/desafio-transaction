<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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

