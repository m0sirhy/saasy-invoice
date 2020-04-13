<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ClientToken
 *
 * @property int $id
 * @property int $client_id
 * @property string $token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClientToken newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClientToken newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClientToken query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClientToken whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClientToken whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClientToken whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClientToken whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClientToken whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Client $client
 */
class ClientToken extends Model
{
    protected $fillable = [
        'client_id',
        'token'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
