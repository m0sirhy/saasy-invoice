<?php

namespace App\Listeners;

use Auth;
use Mail;
use App\Invoice;
use App\Mail\PaymentAdd;
use App\Mail\PaymentOnce;
use App\Mail\PaymentRefund;
use App\Events\PaymentAdded as PA;
use App\Events\paymentOneTime as POT;
use App\Events\PaymentRefunded as PR;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class PaymentListener
{
    public function paymentAdded(PA $event)
    {
        $event->invoice->balance -= $event->amount;
        if ($event->invoice->balance == 0) {
            $event->invoice->invoice_status_id = PAID;
        }
        $event->invoice->save();
        $paid = $event->invoice->client->payments
            ->where('payment_type', '!=', 2)
            ->sum('amount');
        $event->invoice->client->update([
            'balance' => $event->invoice->client->invoices->sum('balance'),
            'total_paid' => $paid,
        ]);
        Mail::to($event->invoice->client->email)->send(new PaymentAdd($event->invoice, $event->amount));
    }

    public function paymentRefunded(PR $event)
    {
        $invoice = Invoice::where('id', $event->payment->invoice_id)
            ->with('Client')
            ->first();
        Mail::to($invoice->Client->email)->send(new PaymentRefund($event->payment, $invoice));
    }

    public function paymentOneTime(POT $event)
    {
        Mail::to($event->email)->send(new PaymentOnce($event->payment, $event->email));
    }
}
