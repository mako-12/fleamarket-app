<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_code',
        'address',
        'building',
    ];

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
}
