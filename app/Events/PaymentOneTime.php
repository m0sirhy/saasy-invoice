<?php

namespace App\Events;

use App\Invoice;
use App\Payment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PaymentOneTime
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $payment;

    public $email;

    /**
     * Create a new event instance.
     *
     * @param Payment $payment
     * @param String $email
     * @return void
     */
    public function __construct(Payment $payment, $email)
    {
        $this->payment = $payment;
        $this->email = $email;
    }
}
