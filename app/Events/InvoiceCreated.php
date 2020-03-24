<?php

namespace App\Events;

use App\Invoice;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InvoiceCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $invoice;

    public $mail;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Invoice $invoice, $mail = null)
    {
        $this->invoice = $invoice;
        $this->mail = $mail;
    }
}
