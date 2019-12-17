<?php

namespace App\Listeners;

use App\Payment;
use App\Events\ApplyCreditPayment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NewCreditPayment
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
     * @param  ApplyCreditPayment  $event
     * @return void
     */
    public function handle(ApplyCreditPayment $event)
    {
        Payment::create([
            'invoice_id' => $event->invoice->id,
            'client_id' => $event->invoice->client_id,
            'amount' => $event->amount,
            'refunded' => '0',
            'auth_code' => '',
            'payment_type' => 'credit',
            'payment_at' => now()
        ]);
        if ($event->invoice->balance == 0) {
            $event->invoice->invoice_status_id = 6;
            $event->invoice->save();
        }
    }
}
