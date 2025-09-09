<?php

namespace Database\Seeders;

use App\Models\Profile;
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
        // Profile::factory()->count(2)->create();

        DB::table('profiles')->insert([
            [
                'id' => 1,
                'user_id' => 1,
                'address_id' => 1,
                'name' => 'michi',
                'profile_image' => '  item_image / kkrn_icon_user_4 . jpg ',


            ],
            [
                'id' => 2,
                'user_id' => 2,
                'address_id' => 2,
                'name' => 'mika',
                'profile_image' => '  item_image / kkrn_icon_user_4 . jpg ',
            ],
        ]);
    }
}
