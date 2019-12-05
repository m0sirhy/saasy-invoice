<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    protected $fillable = [
        'client_id',
        'user_id',
        'credit_date',
        'amount',
        'balance',
        'completed'
    ];

    protected $dates = [
        'credit_date'
    ];

    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
