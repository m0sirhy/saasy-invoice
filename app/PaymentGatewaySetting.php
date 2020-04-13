<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\PaymentGatewaySetting
 *
 * @property int $id
 * @property int $payment_gateway_id
 * @property string $username
 * @property string $key
 * @property string $public_key
 * @property int $test_mode
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PaymentGatewaySetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PaymentGatewaySetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PaymentGatewaySetting query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PaymentGatewaySetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PaymentGatewaySetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PaymentGatewaySetting whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PaymentGatewaySetting wherePaymentGatewayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PaymentGatewaySetting wherePublicKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PaymentGatewaySetting whereTestMode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PaymentGatewaySetting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PaymentGatewaySetting whereUsername($value)
 * @mixin \Eloquent
 */
class PaymentGatewaySetting extends Model
{
    protected $fillable = [
        'payment_gateway_id',
        'username',
        'key',
        'public_key',
        'test_mode'
    ];

    public function paymentGateway()
    {
        $this->belongsTo(PaymentGateway::class);
    }
}
