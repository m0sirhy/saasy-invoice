<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceStatus extends Model
{
    protected $fillable = [
        'status'
    ];

    public function invoice()
    {
        return $this->hasMany('App\Invoice');
    }
}
