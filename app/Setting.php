<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Setting
 *
 * @property int $id
 * @property string $company
 * @property string $website
 * @property string $email
 * @property string $phone
 * @property string $address
 * @property string $address2
 * @property string $city
 * @property string $state
 * @property string $zipcode
 * @property string $country
 * @property int $auto_credits
 * @property int $remind_days1
 * @property int $remind_days2
 * @property int $remind_days3
 * @property int $remind_after1
 * @property int $remind_after2
 * @property int $remind_after3
 * @property int $remind_enable1
 * @property int $remind_enable2
 * @property int $remind_enable3
 * @property string $api_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting whereAddress2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting whereApiToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting whereAutoCredits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting whereWebsite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting whereZipcode($value)
 * @mixin \Eloquent
 */
class Setting extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company',
        'website',
        'email',
        'phone',
        'address',
        'address2',
        'city',
        'state',
        'zipcode',
        'country',
        'auto_credits',
        'api_token',
        'phone',
        'email',
        'remind_days1',
        'remind_days2',
        'remind_days3',
        'remind_after1',
        'remind_after2',
        'remind_after3',
        'remind_enable1',
        'remind_enable2',
        'remind_enable3'
    ];
}
