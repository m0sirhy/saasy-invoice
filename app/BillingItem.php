<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BillingItem extends Model
{
    protected $fillable = [
    	'billing_id',
    	'product_id',
    	'alt_id',
    	'price_per',
    	'after_min',
    	'price_after'
    ];

    public function billing()
    {
        return $this->belongsTo('App\Billing');
    }

    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
