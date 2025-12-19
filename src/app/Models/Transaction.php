<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'buyer_profile_id',
        'seller_profile_id',
        'payment_method',
        'status',
        'completed_at',
    ];

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

    public const PURCHASE_COMPLETE = 0;
    public const TRANSACTION_COMPLETE = 1;
    public const EVALUATED_COMPLETE = 2;

    // public function getStatusNameAttribute(): string
    // {
    //     return match ($this->status) {
    //         self::PURCHASE_COMPLETE => '購入完了',
    //         self::TRANSACTION_COMPLETE => '取引完了',
    //         self::EVALUATED_COMPLETE => '評価済み',
    //         default => '不明',
    //     };
    // }

    public const STATUSES = [
        self::PURCHASE_COMPLETE => '購入完了',
        self::TRANSACTION_COMPLETE => '取引完了',
        self::EVALUATED_COMPLETE => '評価済み',
    ];

    public function getStatusNameAttribute(): string
    {
        return self::STATUSES[$this->status] ?? '不明';
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function buyerProfile()
    {
        return $this->belongsTo(Profile::class, 'buyer_profile_id');
    }

    public function sellerProfile()
    {
        return $this->belongsTo(Profile::class, 'seller_profile_id');
    }

    public function chatMessages()
    {
        return $this->hasMany(ChatMessage::class);
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class)
            ->whereColumn('evaluator_profile_id', 'seller_profile_id');
    }
}
