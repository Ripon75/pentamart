<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
// Event
use App\Events\OrderCreate;
use App\Events\ProductSearch;
use App\Events\OrderStatusChange;
use App\Events\ManualOrderCreate;
use App\Events\CustomerRegistration;
use App\Events\PasswordRecoveryAttempted;
// Listeners
use App\Listeners\NotifyUser;
use App\Listeners\StoreSearchLog;
use App\Listeners\AttachCustomerRole;
use App\Listeners\CreateCustomerCart;
use App\Listeners\SendActivationCode;
use App\Listeners\SendOrderSubmitSMS;
use App\Listeners\SetOrderStatusSubmit;
use App\Listeners\SendPasswordRecoveryCode;
use App\Listeners\SetManualOrderStatusSubmit;

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
            // SendActivationCode::class,
            AttachCustomerRole::class,
            CreateCustomerCart::class,
        ],
        PasswordRecoveryAttempted::class => [
            SendPasswordRecoveryCode::class
        ],
        ProductSearch::class => [
            StoreSearchLog::class
        ],
        OrderCreate::class => [
            SetOrderStatusSubmit::class,
            SendOrderSubmitSMS::class
        ],
        ManualOrderCreate::class => [
            SetManualOrderStatusSubmit::class
        ],
        OrderStatusChange::class => [
            NotifyUser::class
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
