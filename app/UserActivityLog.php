<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserActivityLog extends Model
{
    protected $fillable = [
    	'user_id',
    	'message',
    	'invoice_id'
    ];
}
