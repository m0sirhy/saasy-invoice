<?php

namespace App\Mail;

use App\Client;
use App\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OverdueInvoice extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice;

    public $client;

    public $company;

    public $url;

    public $setting;

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
        $this->setting = Setting::first();
        $this->company = $this->setting->company;
        $this->url = $this->setting->website;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->setting->email, $this->setting->company)
            ->markdown('emails.invoices.sendoverdue')
            ->subject('Overdue Invoice From' . $this->company);
    }
}
