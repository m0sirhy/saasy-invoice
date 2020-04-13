<?php

namespace App\Listeners;

use Auth;
use App\ClientActivityLog;
use App\Events\Client\ClientInvoiceViewed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ClientActivityLogEntry
{

    /**
     * Handle the event.
     *
     * @param  ClientInvoiceViewed  $event
     * @return void
     */
    public function handle(ClientInvoiceViewed $event)
    {
        $userId = 99999999;
        if (Auth::check()) {
            $userId = Auth::id();
        }
        ClientActivityLog::create([
            'message' => 'viewed invoice',
            'client_id' => $userId,
            'invoice_id' => $event->invoice->id
        ]);
    }
}
