<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Client;
use App\Invoice;
use App\Payment;
use Log;

class PaymentForm extends Component
{
    public $invoiceId;
    public $invoices;
    public $amount;
    public $invoiceBalance;
    public $types;
    public $authCode;
    public $paymentType;
    public $paymentDate;
    public $client;
    public $clientText;
    public $clients;
    public $payment;
    public $url;

    public function mount($payment, $types)
    {
        $this->invoices = [];
        if (!is_null($payment->Client)) {
            $this->invoices = Invoice::where('client_id', $payment->Client->id)
                ->pluck('id')
                ->toArray();
        }
        $this->clients = Client::get();
        $this->invoiceId = $payment->invoice_id;
        $this->clientText = 'Credit Card';
        if (!is_null($payment->Client)) {
            $this->clientText = $payment->Client->name . ' - ' . $payment->Client->email;
        }
        $this->amount = money_format('%i', $payment->amount);
        $this->invoiceBalance = 0;
        if (!is_null($payment->Invoice)) {
            $this->invoiceBalance = $payment->Invoice->balance;
        }
        $this->types = $types;
        $this->type = $payment->type;
        $this->authCode = $payment->auth_code;
        $this->paymentType = $payment->payment_type;
        $this->paymentDate = $payment->payment_at->format('Y-m-d');
        if (!is_null($payment->Client)) {
            $this->client = $payment->Client->id;
        }
        $this->payment = $payment->id;
    }

    public function updatedClientText()
    {
        $split = explode('-', $this->clientText);
        $this->client = Client::where('name', trim($split[0]))
            ->where('email', trim($split[1]))
            ->first()
            ->id;
        $this->invoices = Invoice::where('client_id', $this->client)
            ->pluck('id')
            ->toArray();
        $this->invoiceId = 0;
        if (!empty($this->invoices)) {
            $this->invoiceId = $this->invoices[0];
        }
    }

    public function updateInvoiceId()
    {
        $this->url = route('payments.user.charge', ['invoice' => $this->invoiceId]);
    }

    public function submit()
    {
        $this->validate([

        ]);
        $payment = Payment::where('id', $this->payment)
            ->update([
                'payment_type' => $this->paymentType,
                'invoice_id' => $this->invoiceId,
                'amount' => $this->amount,
                'auth_code' => $this->authCode,
                'payment_at' => $this->paymentDate,
                'client_id' => $this->client,
            ]);
        $this->redirect(route('payments'));
    }

    public function render()
    {
        return view('livewire.payment-form');
    }
}
