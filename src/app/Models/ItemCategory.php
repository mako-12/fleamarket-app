<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemCategory extends Model
{
    use HasFactory;


    public function items()
    {
        return $this->belongsToMany(Item::class, 'item_category_item', 'item_category_id', 'item_id');
    }
}
