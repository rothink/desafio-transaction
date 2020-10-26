<?php

namespace Tests\Unit;

use App\Models\TipoUser;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\ExceptionsMessages\UserExceptionMessages;
use App\Services\UserService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Teste de colunas
     */
    public function test_if_user_columns_is_correct(): void
    {
        $user = new User();
        $columnsExpected = [
            'name',
            'email',
            'cpf',
            'cnpj',
            'password',
            'carteira',
            'tipo_user_id'
        ];
        $arrayCompared = array_diff($columnsExpected, $user->getFillable());
        $this->assertEmpty($arrayCompared);
    }

    /**
     * Teste de criacao de user
     */
    public function test_create_user()
    {
        $name = 'Rodrigo';
        $user = factory(User::class)->create([
            'name' => $name,
        ]);
        $this->assertEquals($name, $user->name);
    }

    /**
     * Cadastro de usuário externo caminho felizz
     */
    public function test_cadastrar_usuario_externo(): void
    {
        $user = $this->getUser();

        $this
            ->mock(UserRepository::class)
            ->shouldReceive('existByEmail')
            ->andReturnFalse()
            ->shouldReceive('existByCPF')
            ->andReturnFalse()
            ->shouldReceive('createExterno')
            ->andReturn(new User($user->toArray()));

        $userSaved = $this->save($user->toArray());

        $this->assertTrue($userSaved instanceof User);
        $this->assertEquals($userSaved->name, $user->name);
        $this->assertEquals($userSaved->email, $user->email);
        $this->assertEquals($userSaved->cpf, $user->cpf);
        $this->assertEquals($userSaved->tipo_user_id, $user->tipo_user_id);
    }

    /**
     * Exception com email já existente
     */
    public function test_cadastrar_email_ja_existe_exception(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage(UserExceptionMessages::$EMAIL_JA_CADASTRADO_NO_SISTEMA);

        $user = $this->getUser();

        $this
            ->mock(UserRepository::class)
            ->shouldReceive('existByEmail')
            ->andReturnTrue();

        $this->save($user->toArray());
    }

    /**
     * Exception cpf já cadastrado
     */
    public function test_cadastrar_cpf_ja_existe_exception(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage(UserExceptionMessages::$CPF_JA_CADASTRADO_NO_SISTEMA);

        $user = $this->getUser();

        $this
            ->mock(UserRepository::class)
            ->shouldReceive('existByEmail')
            ->andReturnFalse()
            ->shouldReceive('existByCPF')
            ->andReturnTrue();;

        $this->save($user->toArray());
    }

    /**
     * Exception com CNPJ já cadastrado
     */
    public function test_cadastrar_cnpj_ja_existe_exception(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage(UserExceptionMessages::$CNPJ_JA_CADASTRADO_NO_SISTEMA);

        $user = $this->getUser(true);

        $this
            ->mock(UserRepository::class)
            ->shouldReceive('existByEmail')
            ->andReturnFalse()
            ->shouldReceive('existByCNPJ')
            ->andReturnTrue();;

        $this->save($user->toArray());
    }

    /**
     * Generic user
     * @param false $tipoUserLojista
     * @return User
     */
    public function getUser($tipoUserLojista = false)
    {
        $user = [
            'name' => 'Rodrigo',
            'email' => 'rodrigoluz@live.com',
            'cpf' => '025.999.777-25',
            'tipo_user_id' => TipoUser::COMUM
        ];
        if ($tipoUserLojista) {
            unset($user['cpf']);
            $user['cnpj'] = '226.588.389/0001-21';
            $user['tipo_user_id'] = TipoUser::LOJISTA;
        }
        return new User($user);
    }

    /**
     * Generic user
     * @param $user
     * @return mixed
     * @throws \Exception
     */
    public function save($user)
    {
        $userService = app(UserService::class);
        return $userService->cadastroExterno($user);
    }
}
