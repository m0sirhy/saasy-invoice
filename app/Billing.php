<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Billing
 *
 * @property int $id
 * @property string $name
 * @property float $monthly_fee
 * @property float $monthly_min
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\BillingItem[] $billingItems
 * @property-read int|null $billing_items_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Billing newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Billing newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Billing query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Billing whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Billing whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Billing whereMonthlyFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Billing whereMonthlyMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Billing whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Billing whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Billing extends Model
{
    protected $fillable = [
        'name',
        'monthly_fee',
        'monthly_min'
    ];

    public function billingItems()
    {
        return $this->hasMany('App\BillingItem');
    }
}
