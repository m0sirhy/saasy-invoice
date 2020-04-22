<?php

namespace App\Mail;

use App\Invoice;
use App\Payment;
use App\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PaymentAdd extends Mailable
{
    use Queueable, SerializesModels;

    public $amount;

    public $invoice;

    public $client;

    public $company;

    public $url;

    public $setting;
    /**
     * Create a new message instance.
     *
     * @param App\Invoice $invoice
     * @param $amount
     * @return void
     */
    public function __construct(Invoice $invoice, $amount)
    {
        $this->amount = $amount;
        $this->invoice = $invoice;
        $this->client = $invoice->client;
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
            ->markdown('emails.payments.added')
            ->subject('A Payment For ' . $this->company . ' Has Been Processed');
    }
}
