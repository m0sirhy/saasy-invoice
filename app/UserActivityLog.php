<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\UserActivityLog
 *
 * @property int $id
 * @property int $user_id
 * @property string $message
 * @property int|null $invoice_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User $client
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserActivityLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserActivityLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserActivityLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserActivityLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserActivityLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserActivityLog whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserActivityLog whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserActivityLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserActivityLog whereUserId($value)
 * @mixin \Eloquent
 * @property-read \App\Invoice|null $invoice
 * @property-read \App\User $user
 */
class UserActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'message',
        'invoice_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
