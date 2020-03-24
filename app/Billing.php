<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    protected $fillable = [
        'name',
        'monthly_fee',
        'monthly_min'
    ];

    public function billingItems()
    {
        return $this->hasMany('App\BillingItem');
    }
}
