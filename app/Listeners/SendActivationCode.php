<?php

namespace App\Listeners;

use App\Events\CustomerRegistration;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Classes\SMSGateway;

class SendActivationCode
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
     * @param  \App\Events\CustomerRegistration  $event
     * @return void
     */
    public function handle(CustomerRegistration $event)
    {
        $code        = $event->code;
        $phoneNumber = $event->phoneNumber;

        if ($code && $phoneNumber) {
            $SMSGateway = new SMSGateway();
            $SMSGateway->sendActivationCode($phoneNumber, $code);
        }
    }
}
