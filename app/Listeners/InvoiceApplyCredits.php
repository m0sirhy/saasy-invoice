<?php

namespace App\Listeners;

use App\Credit;
use App\Setting;
use App\Payment;
use App\Events\PaymentAdded;
use App\Events\InvoiceCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class InvoiceApplyCredits
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
     * @param  InvoiceCreated  $event
     * @return void
     */
    public function handle(InvoiceCreated $event)
    {
        $applyCredits = Setting::where('id', 1)->first();
        if (is_null($applyCredits) || $applyCredits->auto_credits != 1) {
            return;
        }
        $credits = Credit::where('client_id', $event->invoice->client_id)
            ->where("balance", ">", 0)
            ->get();
        foreach ($credits as $credit) {
            if ($event->invoice->balance == 0) {
                break;
            }
            if ($credit->balance > $event->invoice->balance) {
                $amount = $event->invoice->balance;
                $this->addPayment($event, $amount);
                event(new PaymentAdded($event->invoice, $amount));
                break;
            }
            $this->addPayment($event, $amount);
            $amount = $credit->balance;
            event(new PaymentAdded($event->invoice, $amount));
        }
    }

    public function addPayment($event, $amount)
    {
        Payment::create([
            'invoice_id' => $event->invoice->id,
            'client_id' => $event->invoice->client_id,
            'amount' => $amount,
            'refunded' => '0',
            'auth_code' => '',
            'payment_type' => 2,
            'payment_at' => now()
        ]);
    }
}
