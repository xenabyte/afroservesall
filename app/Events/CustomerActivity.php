<?php

namespace App\Events;

use App\Models\Customer;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CustomerActivity
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $customer;
    public $activity;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Customer $customer, $activity)
    {
        //
        $this->customer = $customer;
        $this->activity = $activity;
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
