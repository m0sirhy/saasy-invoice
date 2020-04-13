<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use App\Traits\Uuids;

/**
 * App\Client
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $address
 * @property string|null $address2
 * @property string|null $city
 * @property string|null $state
 * @property string|null $zipcode
 * @property float $balance
 * @property float $total_paid
 * @property string $crm_id
 * @property string|null $terms_accepted_at
 * @property string $uuid
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $active
 * @property-read \App\ClientToken $clientToken
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Credit[] $credits
 * @property-read int|null $credits_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Invoice[] $invoices
 * @property-read int|null $invoices_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Payment[] $payments
 * @property-read int|null $payments_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereAddress2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereCrmId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereTermsAcceptedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereTotalPaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereZipcode($value)
 * @mixin \Eloquent
 * @property string|null $notes
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereTermsAcceptedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ClientActivityLog[] $activity
 * @property-read int|null $activity_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereActive($value)
 */
class Client extends Model implements AuthenticatableContract
{
    protected $guard = 'client';

    use Uuids, Authenticatable;

    protected $fillable = [
        'name',
        'email',
        'address',
        'address2',
        'city',
        'state',
        'zipcode',
        'balance',
        'total_paid',
        'crm_id',
        'terms_accepted_at',
        'deleted_at',
        'invoice_key',
        'uuid',
        'id',
        'notes',
        'active'
    ];

    protected $mapUuid = 'uuid';

    public function credits()
    {
        return $this->hasMany(Credit::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function clientToken()
    {
        return $this->hasOne(ClientToken::class);
    }

    public function activity()
    {
        return $this->hasMany(ClientActivityLog::class);
    }
}
