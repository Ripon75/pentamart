<?php

namespace App\Listeners;

use App\Events\CustomerRegistration;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Cart;

class CreateCustomerCart
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
        $customerId = $event->customer->id;
        $cartObj = new Cart();
        $cartObj->createCustomerCart($customerId);
    }
}
