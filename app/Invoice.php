<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;
use App\Events\InvoiceCreated;
use App\Events\InvoiceUpdated;

/**
 * App\Invoice
 *
 * @property int $id
 * @property int $client_id
 * @property int $invoice_status_id
 * @property string $public_id
 * @property float $balance
 * @property float $amount
 * @property string|null $due_date
 * @property \Illuminate\Support\Carbon|null $invoice_date
 * @property string|null $start_date
 * @property string|null $end_date
 * @property string|null $public_notes
 * @property string|null $private_notes
 * @property int|null $invoice_number
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $queue
 * @property-read \App\Client $client
 * @property-read \App\InvoiceStatus $invoiceStatus
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\InvoiceItem[] $items
 * @property-read int|null $items_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Product[] $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereInvoiceDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereInvoiceNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereInvoiceStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice wherePrivateNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice wherePublicId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice wherePublicNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereQueue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Invoice extends Model
{
    use Uuids;

    protected $fillable = [
        'id',
        'client_id',
        'invoice_status_id',
        'public_id',
        'balance',
        'amount',
        'due_date',
        'invoice_date',
        'start_date',
        'end_date',
        'private_notes',
        'public_notes',
        'queue'
    ];

    protected $dates = [
        'due_dates',
        'invoice_date'
    ];

    protected $mapUuid = 'public_id';

    public function products()
    {
        return $this->hasManyThrough('App\Product', 'App\InvoiceItem');
    }

    public function items()
    {
        return $this->hasMany('App\InvoiceItem');
    }

    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    public function invoiceStatus()
    {
        return $this->belongsTo('App\InvoiceStatus');
    }
}
