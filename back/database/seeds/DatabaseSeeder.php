<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(TipoUserTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(OauthClientsSeeder::class);
        $this->call(TransferenciaTableSeeder::class);
    }
}
