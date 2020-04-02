<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        'App\Events\InvoiceCreated' => [
            'App\Listeners\InvoiceApplyCredits',
            'App\Listeners\UserActivityLogEntry@invoiceCreated',
            'App\Listeners\SendInvoiceListener@sendInvoice',
        ],
        'App\Events\InvoiceViewed' => [
            'App\Listeners\UserActivityLogEntry@invoiceViewed',
        ],
        'App\Events\InvoiceUpdated' => [
            'App\Listeners\UserActivityLogEntry@invoiceUpdated',
            'App\Listeners\SendInvoiceListener@sendInvoice',
        ],
        'App\Events\InvoiceDeleted' => [
            'App\Listeners\UserActivityLogEntry@invoiceDeleted',
        ],
        'App\Events\InvoiceOverdue' => [
            'App\Listeners\SendInvoiceListener@overdueInvoice',
        ],
        'App\Events\PaymentAdded' => [
            'App\Listeners\PaymentAdded',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
