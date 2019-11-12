<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentGatewaySetting extends Model
{
    protected $fillable = [
        'payment_gateway_id',
        'username',
        'key',
        'public_key',
        'test_mode'
    ];
}
