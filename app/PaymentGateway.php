<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\PaymentGateway
 *
 * @property int $id
 * @property string $name
 * @property string $library
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PaymentGateway newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PaymentGateway newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PaymentGateway query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PaymentGateway whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PaymentGateway whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PaymentGateway whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PaymentGateway whereLibrary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PaymentGateway whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PaymentGateway whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PaymentGateway extends Model
{
    protected $fillable = [
        'name',
        'library',
        'active'
    ];
}
