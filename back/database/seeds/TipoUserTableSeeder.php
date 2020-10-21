<?php

use Illuminate\Database\Seeder;
use App\Models\TipoUser;


class TipoUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoUser::create([
            'name'=>'Comum',
        ]);
        TipoUser::create([
            'name'=>'Lojista',
        ]);
    }
}
