<?php

namespace App\Listeners;

use Auth;
use App\UserActivityLog;
use App\Events\InvoiceViewed;
use App\Events\InvoiceCreated;
use App\Events\InvoiceDeleted;
use App\Events\InvoiceUpdated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserActivityLogEntry
{
    /**
     * Handle the event.
     *
     * @param  InvoiceCreated  $event
     * @return void
     */
    public function invoiceCreated(InvoiceCreated $event)
    {
        $userId = 99999999;
        if (Auth::check()) {
            $userId = Auth::id();
        }
        UserActivityLog::create([
            'message' => 'created invoice',
            'user_id' => $userId,
            'invoice_id' => $event->invoice->id
        ]);
    }

    /**
     * Handle the event.
     *
     * @param  InvoiceViewed  $event
     * @return void
     */
    public function invoiceViewed(InvoiceViewed $event)
    {
        $userId = 99999999;
        if (Auth::check()) {
            $userId = Auth::id();
        }
        UserActivityLog::create([
            'message' => 'viewed invoice',
            'user_id' => $userId,
            'invoice_id' => $event->invoice->id
        ]);
    }

    /**
     * Handle the event.
     *
     * @param  InvoiceUpdated  $event
     * @return void
     */
    public function invoiceUpdated(InvoiceUpdated $event)
    {
        $userId = 99999999;
        if (Auth::check()) {
            $userId = Auth::id();
        }
        UserActivityLog::create([
            'message' => 'updated invoice',
            'user_id' => $userId,
            'invoice_id' => $event->invoice->id
        ]);
    }

    /**
     * Handle the event.
     *
     * @param  InvoiceDeleted  $event
     * @return void
     */
    public function invoiceDeleted(InvoiceDeleted $event)
    {
        $userId = 99999999;
        if (Auth::check()) {
            $userId = Auth::id();
        }
        UserActivityLog::create([
            'message' => 'deleted invoice',
            'user_id' => $userId,
            'invoice_id' => $event->invoice->id
        ]);
    }
}
