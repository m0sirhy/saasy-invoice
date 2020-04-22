<?php

namespace App\Mail;

use App\Invoice;
use App\Payment;
use App\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PaymentRefund extends Mailable
{
    use Queueable, SerializesModels;

    public $payment;

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
    public function __construct(Payment $payment, Invoice $invoice)
    {
        $this->payment = $payment;
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
            ->markdown('emails.payments.refund')
            ->subject('Your Refund Has Been Processed By ' . $this->company);
    }
}
