<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ClientActivityLog
 *
 * @property int $id
 * @property int $client_id
 * @property string $message
 * @property int $invoice_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClientActivityLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClientActivityLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClientActivityLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClientActivityLog whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClientActivityLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClientActivityLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClientActivityLog whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClientActivityLog whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClientActivityLog whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ClientActivityLog extends Model
{
    protected $fillable = [
        'client_id',
        'message',
        'invoice_id'
    ];

    public function client()
    {
        $this->belongsTo(Client::class);
    }

    public function invoice()
    {
        $this->belongsTo(Invoice::class);
    }
}
