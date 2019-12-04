<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
    	'client_id',
    	'billing_type_id',
    	'last_invoice_date',
    	'last_invoice_id',
    	'next_invoice_date',
    	'total_invoices',
    	'total_billed',
    	'total_payed'
    ];

    public function invoice()
    {
        return $this->hasMany('App\Invoice');
    }
}
