<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class CustomerRegistration
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $code;
    public $customer;
    public $phoneNumber;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $customer, $phoneNumber, $code)
    {
        $this->customer    = $customer;
        $this->phoneNumber = $phoneNumber;
        $this->code        = $code;

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
