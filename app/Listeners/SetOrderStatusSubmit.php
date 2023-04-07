<?php

namespace App\Listeners;

use App\Events\OrderCreate;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SetOrderStatusSubmit
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
     * @param  \App\Events\OrderCreate  $event
     * @return void
     */
    public function handle(OrderCreate $event)
    {
        $order = $event->order;
        $orderDatetime = $event->orderDatetime;

        $order->setStatus('submitted', $orderDatetime);
    }
}
