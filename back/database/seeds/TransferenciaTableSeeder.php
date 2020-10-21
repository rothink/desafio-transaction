<?php

use Illuminate\Database\Seeder;
use App\Models\Transferencia;

class TransferenciaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Transferencia::create([
            'value' => 200,
            'payer' => 1,
            'payee' => 2,
            'created_at' => \Carbon\Carbon::now()
        ]);

        Transferencia::create([
            'value' => 280,
            'payer' => 1,
            'payee' => 2,
            'created_at' => \Carbon\Carbon::now()
        ]);
    }
}
