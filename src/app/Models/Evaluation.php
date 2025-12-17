<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'evaluator_profile_id',
        'evaluated_profile_id',
        'rating',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function evaluator()
    {
        return $this->belongsTo(Profile::class, 'evaluator_profile_id');
    }

    public function evaluated()
    {
        return $this->belongsTo(Profile::class, 'evaluated_profile_id');
    }
}
