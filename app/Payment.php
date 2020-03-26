<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Payment
 *
 * @property int $id
 * @property int $invoice_id
 * @property int $client_id
 * @property float $amount
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $payment_at
 * @property int $refunded
 * @property string|null $auth_code
 * @property string|null $payment_type
 * @property string|null $transaction_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Client $client
 * @property-read \App\Invoice $invoice
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payment newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Payment onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payment query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payment whereAuthCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payment whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payment whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payment wherePaymentAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payment wherePaymentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payment whereRefunded($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payment whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Payment withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Payment withoutTrashed()
 * @mixin \Eloquent
 */
class Payment extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'invoice_id',
        'client_id',
        'amount',
        'deleted_at',
        'payment_at',
        'refunded',
        'auth_code',
        'payment_type',
        'transaction_id',
        'id'
    ];

    protected $dates = [
        'deleted_at',
        'payment_at'
    ];

    const TYPES = [
        0 => 'Cash',
        1 => 'Check',
        2 => 'Site Credit',
        3 => 'Credit Card',
        4 => 'ACH'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
