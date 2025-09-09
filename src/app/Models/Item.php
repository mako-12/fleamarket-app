<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_condition_id',
        'image',
        'name',
        'brand',
        'detail',
        'price',
        'profile_id',
        'item_image',
    ];

    public function favoriteBy()
    {
        return $this->belongsToMany(Profile::class, 'favorites', 'item_id', 'profile_id')->withTimestamps();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class,);
    }

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

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
