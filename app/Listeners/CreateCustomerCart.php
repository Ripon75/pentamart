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
        $userId = $event->user->id;
        $cartObj = new Cart();
        $cartObj->createCustomerCart($userId);
    }
}
