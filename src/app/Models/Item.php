<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_category_id',
        'item_condition_id',
        'image',
        'name',
        'brand',
        'detail',
        'price',
    ];

    public function favoriteProfiles()
    {
        return $this->belongsToMany(Profile::class,'favorites','item_id','profile_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class,);
    }

    // public function favorites()
    // {
    //     return $this->hasMany(Favorite::class);
    // }

    public function itemCategories()
    {
        return $this->belongsToMany(ItemCategory::class, 'item_category_item', 'item_id', 'item_category_id');
    }

    public function itemCondition()
    {
        return $this->belongsTo(ItemCondition::class, 'item_condition_id');
    }

    public function purchases()
    {
        return $this->hasOne(Purchase::class);
    }
}
