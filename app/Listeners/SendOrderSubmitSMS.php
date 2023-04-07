<?php

namespace App\Listeners;

use App\Events\OrderCreate;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Classes\SMSGateway;

class SendOrderSubmitSMS
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
        $orderId     = $event->order->id;
        $phoneNumber = $event->order->user->phone_number;
        if ($orderId && $phoneNumber) {
            $SMSGateway = new SMSGateway();
            $SMSGateway->sendOrderSubmitSMS($phoneNumber, $orderId);
        }
    }
}
