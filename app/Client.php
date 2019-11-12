<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'name',
        'email',
        'address',
        'address2',
        'city',
        'state',
        'zipcode',
        'balance',
        'total_paid',
        'crm_id',
        'terms_accepted_at',
        'deleted_at'
    ];
}
