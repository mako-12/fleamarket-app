<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $payments = [
            ['name' => 'コンビニ支払い'],
            ['name' => 'カード支払い'],
        ];

        foreach ($payments as $payment) {
            DB::table('payments')->insert($payment,
            );
        }
    }
}
