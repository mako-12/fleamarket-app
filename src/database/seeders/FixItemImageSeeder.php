<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;

class FixItemImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = Item::where('item_image', 'like', 'storage/%')->get();

        foreach ($items as $item) {
            $item->item_image = str_replace('storage/', '', $item->item_image);
            $item->save();
        }
    }
}
