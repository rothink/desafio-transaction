<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\TipoUser;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Cria por default um usuário comum
         */
        User::create([
            'name'=>'Usuário comum',
            'email'=>'comum@user.com',
            'password'=> bcrypt('123456'),
            'tipo_user_id' => TipoUser::COMUM,
            'created_at' => \Carbon\Carbon::now(),
            'carteira' => '10000.00'
        ]);

        /**
         * Cria por default um usuário do tipo lojista
         */
        User::create([
            'name'=>'Lojista user',
            'email'=>'lojista@user.com',
            'password'=> bcrypt('123456'),
            'tipo_user_id' => TipoUser::LOJISTA,
            'created_at' => \Carbon\Carbon::now(),
            'carteira' => '10000.00'
        ]);

        /**
         * Criação de 25 usuários aleatórios
         */
        factory(User::class, 25)->create();
    }
}
