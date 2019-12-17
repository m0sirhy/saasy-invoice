<?php

namespace App\Listeners;

use App\Events\AddPayment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NewPayment
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  AddPayment  $event
     * @return void
     */
    public function handle(AddPayment $event)
    {
        //
    }
}
