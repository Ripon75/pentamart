<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
// Event
use App\Events\OrderCreate;
use App\Events\ProductSearch;
use App\Events\CustomerRegistration;
// Listeners
use App\Listeners\StoreSearchLog;
use App\Listeners\CreateCustomerCart;
use App\Listeners\SendOrderSubmitSMS;
use App\Listeners\SetOrderStatusSubmit;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        CustomerRegistration::class => [
            CreateCustomerCart::class
        ],
        ProductSearch::class => [
            StoreSearchLog::class
        ],
        OrderCreate::class => [
            SetOrderStatusSubmit::class,
            // SendOrderSubmitSMS::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
