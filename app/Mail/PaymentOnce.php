<?php

namespace App\Mail;

use App\Payment;
use App\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PaymentOnce extends Mailable
{
    use Queueable, SerializesModels;

    public $payment;

    public $company;

    public $url;

    public $setting;

    public $email;

    /**
     * Create a new message instance.
     *
     * @param App\Invoice $invoice
     * @return void
     */
    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
        $this->setting = Setting::first();
        $this->company = $this->setting->company;
        $this->url = $this->setting->website;
        $this->email = $this->setting->email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->setting->email, $this->setting->company)
            ->markdown('emails.payments.one-time')
            ->subject('A Payment For ' . $this->company . ' Has Been Processed');
    }
}
