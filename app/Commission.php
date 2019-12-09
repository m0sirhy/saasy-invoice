<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    protected $fillable = [
        'user_id',
        'invoice_id',
        'amount',
        'paid_date',
        'paid',
        'notes'
    ];

    protected $dates = [
        'paid_date'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
