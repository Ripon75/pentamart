<?php

namespace App\Listeners;

use App\Models\Role;
use App\Events\CustomerRegistration;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AttachCustomerRole
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
        $user = $event->customer;
        if(!$user->hasRole('customer')) {
            $user->attachRole('customer');
        }
    }
}
