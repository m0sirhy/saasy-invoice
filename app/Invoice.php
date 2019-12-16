<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class Invoice extends Model
{
    use Uuids;

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

    protected $mapUuid = 'public_id';

    public function products()
    {
        return $this->hasManyThrough('App\Product', 'App\InvoiceItem');
    }

    public function items()
    {
        return $this->hasMany('App\InvoiceItem');
    }

    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    public function invoiceStatus()
    {
        return $this->belongsTo('App\InvoiceStatus');
    }
}
