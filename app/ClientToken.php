<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientToken extends Model
{
    protected $fillable = [
        'client_id',
        'token'
    ];
}
