<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Invoice;
use App\Client;

class NewInvoice extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice;

    public $client;
    /**
     * Create a new message instance.
     *
     * @param App\Invoice $invoice
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
        return $this->markdown('emails.invoices.sendnew')->subject('A New Invoice From Saasy-Invoice');
    }
}