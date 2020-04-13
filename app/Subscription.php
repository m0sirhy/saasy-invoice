<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Subscription
 *
 * @property int $id
 * @property string $client_id
 * @property int $billing_type_id
 * @property \Illuminate\Support\Carbon|null $last_invoice_date
 * @property int|null $last_invoice_id
 * @property \Illuminate\Support\Carbon $next_invoice_date
 * @property int $total_invoices
 * @property float $total_billed
 * @property float $total_payed
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Client $client
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Invoice[] $invoice
 * @property-read int|null $invoice_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscription newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscription newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscription query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscription whereBillingTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscription whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscription whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscription whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscription whereLastInvoiceDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscription whereLastInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscription whereNextInvoiceDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscription whereTotalBilled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscription whereTotalInvoices($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscription whereTotalPayed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscription whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Subscription extends Model
{
    protected $fillable = [
        'client_id',
        'billing_type_id',
        'last_invoice_date',
        'last_invoice_id',
        'next_invoice_date',
        'total_invoices',
        'total_billed',
        'total_payed'
    ];
    protected $dates = [
        'last_invoice_date',
        'next_invoice_date'
    ];

    public function invoice()
    {
        return $this->hasMany(Invoice::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
