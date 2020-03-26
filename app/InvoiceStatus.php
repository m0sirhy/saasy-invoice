<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\InvoiceStatus
 *
 * @property int $id
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Invoice[] $invoice
 * @property-read int|null $invoice_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InvoiceStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InvoiceStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InvoiceStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InvoiceStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InvoiceStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InvoiceStatus whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InvoiceStatus whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class InvoiceStatus extends Model
{
    protected $fillable = [
        'status'
    ];

    public function invoice()
    {
        return $this->hasMany('App\Invoice');
    }
}
