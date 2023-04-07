<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProductSearch
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $searchKey;
    public $resultCount;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($searchKey, $resultCount)
    {
        $this->searchKey   = $searchKey;
        $this->resultCount = $resultCount;
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
