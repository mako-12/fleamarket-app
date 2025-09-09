<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'item_id',
        'payment_method',
    ];


    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }


    const METHOD_CONVENIENCE = 1;
    const METHOD_CARD = 2;

    public static $methods = [
        self::METHOD_CONVENIENCE => 'コンビニ支払い',
        self::METHOD_CARD => 'カード支払い',
    ];

    public function getPaymentMethodLabelAttribute()
    {
        return self::$methods[$this->payment_method] ?? '不明';
    }
}
