<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'invoice_id',
        'client_id',
        'amount',
        'deleted_at',
        'payment_at',
        'refunbded',
        'auth_code'
    ];

    protected $dates = [
        'deleted_at',
        'payment_at'
    ];

    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    public function invoice()
    {
        return $this->belongsTo('App\Invoice');
    }
}
