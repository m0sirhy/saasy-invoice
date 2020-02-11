<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Invoice;
use App\Client;

class OverdueInvoice extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice;

    public $client;

    /**
     * Create a new message instance.
     *
     * @param Invoice $invoice
     * @param Client $client
     * @return void
     */
    public function __construct(Invoice $invoice, Client $client)
    {
        $this->invoice = $invoice;
        $this->client = $client;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.invoices.sendoverdue')->subject('Overdue Invoice From SaasyInvoice');
    }
}
