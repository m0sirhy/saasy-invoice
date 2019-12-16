<?php

namespace App\Traits;
use Illuminate\Support\Str;

trait Uuids
{
    protected static function bootUuids()
    {
        static::creating(function ($model) {
            $col = $model->mapUuid;
            $model->$col = (string) Str::uuid();
        });
    }
}
