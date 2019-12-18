<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class Client extends Model
{
    use Uuids;
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
        'invoice_key'
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
}
