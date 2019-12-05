<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'client_id',
        'invoice_status_id',
        'public_id',
        'balance',
        'amount',
        'due_date',
        'invoice_date',
        'start_date',
        'end_date',
    ];

    public function status()
    {
    	return $this->belongsTo('App\InvoiceStatus');
    }

    public function products()
    {
        return $this->hasManyThrough('App\Product', 'App\InvoiceItem');
    }

    public function items()
    {
        return $this->hasMany('App\InvoiceItem');
    }
}
