<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'subscription_id',
        'provider_id',
        'provider_user_id',
        'provider_transaction_id',
        'payed',
        'payment_amount',
        'payment_time',
    ];
}
