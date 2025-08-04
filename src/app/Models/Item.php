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

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function itemCategory()
    {
        return $this->belongsTo(ItemCategory::class);
    }

    public function itemCondition()
    {
        return $this->belongsTo(ItemCondition::class);
    }

    public function purchase()
    {
        return $this->hasOne(Purchase::class);
    }
}
