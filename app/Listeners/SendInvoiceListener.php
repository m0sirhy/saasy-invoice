<?php

namespace App\Listeners;

use Log;
use Mail;
use App\Client;
use App\Mail\NewInvoice;
use App\Mail\OverdueInvoice;
use App\Events\InvoiceOverdue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendInvoiceListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Send an Invoice if $mail is set
     *
     * @param mixed $event
     * @return void
     *
     */
    public function sendInvoice($event)
    {
        $client = Client::where('id', $event->invoice->client_id)->first();
        if ($event->mail == 1 && $client != null) {
            Mail::to($client->email)->send(new NewInvoice($event->invoice, $client));
            if ($event->invoice->invoice_status_id == DRAFT) {
                $event->invoice->invoice_status_id = SENT;
                $event->invoice->save();
            }
        }
    }

    /**
     * Send an Invoice if the Invoice is overdue
     *
     * @param App\Events\InvoiceOverdue $event
     * @return void
     *
     */
    public function overdueInvoice(InvoiceOverdue $event)
    {
        $client = Client::where('id', $event->invoice->client_id)->first();
        if ($client != null) {
            Mail::to($client->email)->send(new OverdueInvoice($event->invoice, $client));
        }
    }
}
