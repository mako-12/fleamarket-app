<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PurchasesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('purchases')->insert([
            [
                'profile_id' => 1,
                'item_id' => 1,
                'payment_method' => 'コンビニ払い',

            ],
            [
                'profile_id' => 2,
                'item_id' => 2,
                'payment_method' => 'カード支払い',
            ],
        ]);
    }
}
