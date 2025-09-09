<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'address_id',
        'profile_image',
        'name',
        'user_id',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }

    public function favoriteItems()
    {
        return $this->belongsToMany(Item::class, 'favorites', 'profile_id', 'item_id')->withTimestamps();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
