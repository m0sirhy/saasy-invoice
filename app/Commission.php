<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Commission
 *
 * @property int $id
 * @property int $user_id
 * @property int $invoice_id
 * @property float $amount
 * @property \Illuminate\Support\Carbon $paid_date
 * @property int $paid
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Commission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Commission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Commission query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Commission whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Commission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Commission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Commission whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Commission whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Commission wherePaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Commission wherePaidDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Commission whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Commission whereUserId($value)
 * @mixin \Eloquent
 */
class Commission extends Model
{
    protected $fillable = [
        'user_id',
        'invoice_id',
        'amount',
        'paid_date',
        'paid',
        'notes'
    ];

    protected $dates = [
        'paid_date'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
