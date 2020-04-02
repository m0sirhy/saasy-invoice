<?php

namespace App\Events;

use App\Invoice;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class InvoiceCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $invoice;
    public $mail;
    
    /**
     * Create a new event instance.
     *
     * @param Invoice $invoice
     * @param integer $mail
     * @return void
     */
    public function __construct(Invoice $invoice, $mail = 0)
    {
        $this->invoice = $invoice;
        $this->mail = $mail;
    }
}
