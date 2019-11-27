<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company',
        'website',
        'email',
        'phone',
        'address',
        'address2',
        'city',
        'state',
        'zipcode',
        'country'
    ];
}
