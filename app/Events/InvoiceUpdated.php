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

class InvoiceUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $invoice;

    /**
     * Create a new event instance.
     *
     * @param Invoice $invoice
     * @param int $mail;
     * @return void
     */
    public function __construct(Invoice $invoice, $mail = 0)
    {
        $this->invoice = $invoice;
        $this->mail = $mail;
    }
}
