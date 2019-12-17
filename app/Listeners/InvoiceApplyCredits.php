<?php

namespace App\Listeners;

use App\Credit;
use App\Setting;
use App\Events\ApplyCreditPayment;
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
        if ($applyCredits->auto_credits != 1) {
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
                $credit->balance -= $event->invoice->balance;
                $event->invoice->balance = 0;
                $credit->save();
                $event->invoice->save();
                event(new ApplyCreditPayment($event->invoice, $amount));
                break;
            }
            $amount = $credit->balance;
            $event->invoice->balance = $credit->balance;
            $credit->balance = 0;
            $credit->completed = 1;
            $credit->save();
            $event->invoice->save();
            event(new ApplyCreditPayment($event->invoice, $amount));
        }
    }
}
