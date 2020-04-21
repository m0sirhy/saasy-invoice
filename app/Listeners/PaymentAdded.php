<?php

namespace App\Listeners;

use App\Events\PaymentAdded as PA;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PaymentAdded
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PaymentAdded  $event
     * @return void
     */
    public function handle(PA $event)
    {
        $event->invoice->balance -= $event->amount;
        if ($event->invoice->balance == 0) {
            $event->invoice->invoice_status_id = PAID;
        }
        $event->invoice->save();
        $paid = $event->invoice->client->payments
            ->where('payment_type', '!=', 2)
            ->sum('balance');
        $event->invoice->client->update([
            'balance' => $event->invoice->client->invoices->sum('balance'),
            'total_paid' => $paid,
        ]);
    }
}
