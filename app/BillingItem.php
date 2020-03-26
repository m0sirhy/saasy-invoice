<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\BillingItem
 *
 * @property int $id
 * @property int $billing_id
 * @property int $product_id
 * @property string $alt_id
 * @property float $price_per
 * @property int $after_min
 * @property float $price_after
 * @property float $costs
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Billing $billing
 * @property-read \App\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BillingItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BillingItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BillingItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BillingItem whereAfterMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BillingItem whereAltId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BillingItem whereBillingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BillingItem whereCosts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BillingItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BillingItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BillingItem wherePriceAfter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BillingItem wherePricePer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BillingItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BillingItem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BillingItem extends Model
{
    protected $fillable = [
        'billing_id',
        'product_id',
        'alt_id',
        'price_per',
        'after_min',
        'price_after'
    ];

    public function billing()
    {
        return $this->belongsTo('App\Billing');
    }

    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
