<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Credit
 *
 * @property int $id
 * @property int $client_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon $credit_date
 * @property float $amount
 * @property float $balance
 * @property int $completed
 * @property string $private_notes
 * @property string $public_notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Client $client
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Credit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Credit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Credit query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Credit whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Credit whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Credit whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Credit whereCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Credit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Credit whereCreditDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Credit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Credit whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Credit whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Credit whereUserId($value)
 * @mixin \Eloquent
 */
class Credit extends Model
{
    protected $fillable = [
        'client_id',
        'user_id',
        'credit_date',
        'amount',
        'balance',
        'completed',
        'private_notes',
        'public_notes',
        'id'
    ];

    protected $dates = [
        'credit_date'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
