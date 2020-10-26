<?php

namespace Tests\Feature;

use App\Models\TipoUser;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUsuarioNaoLogado(): void
    {
        $response = $this->get('/api/user');
        $response->assertStatus(302);
    }

    /**
     * Cadastro de usuario externo
     */
    public function testCadastrarUsuarioExterno(): void
    {
        $user = [
            'name' => 'Rodrigo',
            'email' => 'rodrigoluz@live.com',
            'tipo_user_id' => TipoUser::COMUM,
            'cpf' => '12365478996',
            'password' => bcrypt('123456')
        ];

        $response = $this->json('POST', '/api/user/cadastro-externo', $user);

        $response
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJson([
                'status' => 'success',
                'message' => 'Operação realizada com com sucesso',
                'user' => is_array($user)
            ])
            ->assertJsonPath('user.name', $user['name'])
            ->assertJsonPath('user.email', $user['email'])
            ->assertJsonPath('user.tipo_user_id', $user['tipo_user_id'])
            ->assertJsonPath('user.cpf', $user['cpf']);
    }
}
