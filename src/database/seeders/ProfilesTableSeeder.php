<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('profiles')->insert([
            [
                'id' => 1,
                'user_id' => 1,
                'address_id' => 1,
                'name' => 'ユーザー１',
                'profile_image' => 'profile_image/kkrn_icon_user_4.png',


            ],
            [
                'id' => 2,
                'user_id' => 2,
                'address_id' => 2,
                'name' => 'ユーザー２',
                'profile_image' => 'profile_image/kkrn_icon_user_4.png',
            ],
            [
                'id' => 3,
                'user_id' => 3,
                'address_id' => 3,
                'name' => 'ユーザー３',
                'profile_image' => 'profile_image/kkrn_icon_user_4.png',
            ]
        ]);
    }
}
