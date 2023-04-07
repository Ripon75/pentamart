<?php

namespace App\Listeners;

use App\Events\ManualOrderCreate;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SetManualOrderStatusSubmit
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
     * @param  \App\Events\ManualOrderCreate  $event
     * @return void
     */
    public function handle(ManualOrderCreate $event)
    {
        $order = $event->order;
        $orderDatetime = $event->orderDatetime;
        if ($order->ref_code) {
            $order->setStatus('delivered', $orderDatetime);
        } else {
            $order->setStatus('submitted', $orderDatetime);
        }
    }
}
