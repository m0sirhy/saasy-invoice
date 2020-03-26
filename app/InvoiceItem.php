<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\InvoiceItem
 *
 * @property int $id
 * @property string $name
 * @property int $product_id
 * @property int $invoice_id
 * @property int $quantity
 * @property string $description
 * @property float $unit_price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InvoiceItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InvoiceItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InvoiceItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InvoiceItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InvoiceItem whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InvoiceItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InvoiceItem whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InvoiceItem whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InvoiceItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InvoiceItem whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InvoiceItem whereUnitPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InvoiceItem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class InvoiceItem extends Model
{
    protected $fillable = [
        'invoice_id',
        'product_id',
        'quantity',
        'description',
        'unit_price',
        'name'
    ];
}
