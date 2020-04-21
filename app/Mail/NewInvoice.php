<?php

namespace App\Mail;

use App\Client;
use App\Invoice;
use App\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewInvoice extends Mailable
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
     * @param App\Invoice $invoice
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
            ->markdown('emails.invoices.sendnew')
            ->subject('A New Invoice From ' . $this->company);
    }
}
