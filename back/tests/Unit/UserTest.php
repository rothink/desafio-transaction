<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    public function test_if_user_columns_is_correct()
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

    public function test_create_user()
    {
        $name = 'Rodrigo';
        $user = factory(User::class)->create([
            'name' => $name,
        ]);
        $this->assertEquals($name, $user->name);
    }
}
