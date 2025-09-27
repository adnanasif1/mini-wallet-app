<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{

    protected $fillable = [
        'sender_id','receiver_id','amount','commission_fee','currency'
    ];

    public function getAmountAttribute($value)
    {
        return number_format($value / 100, 2, '.', '');
    }

    public function getCommissionFeeAttribute($value)
    {
        return number_format($value / 100, 2, '.', '');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
