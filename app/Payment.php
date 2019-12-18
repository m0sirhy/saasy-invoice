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
        'refunded',
        'auth_code',
        'payment_type'
    ];

    protected $dates = [
        'deleted_at'
    ];

    const TYPES = [
        0 => 'Cash',
        1 => 'Check',
        2 => 'Site Credit',
        3 => 'Credit Card'
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
