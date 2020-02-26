<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use App\Traits\Uuids;

class Client extends Model implements AuthenticatableContract
{
    protected $guard = 'client';
    use Uuids, Authenticatable;
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
        'deleted_at',
        'invoice_key',
        'uuid'
    ];

    protected $mapUuid = 'uuid';

    public function credits()
    {
        return $this->hasMany('App\Credit');
    }

    public function invoices()
    {
        return $this->hasMany('App\Invoice');
    }

    public function payments()
    {
        return $this->hasMany('App\Payment');
    }

    public function clientToken()
    {
        return $this->hasOne('App\ClientToken');
    }
}
