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

    public function client()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
