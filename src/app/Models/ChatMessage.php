<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'sender_profile_id',
        'message',
        'chat_image',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function senderProfile()
    {
        return $this->belongsTo(Profile::class, 'sender_profile_id');
    }
}
