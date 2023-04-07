<?php

namespace App\Listeners;

use App\Events\OrderStatusChange;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyUser
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
     * @param  \App\Events\OrderStatusChange  $event
     * @return void
     */
    public function handle(OrderStatusChange $event)
    {
        //
    }
}
