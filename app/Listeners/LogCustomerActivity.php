<?php

namespace App\Listeners;

use App\Events\CustomerActivity;
use App\Models\ActivityLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogCustomerActivity
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
     * @param  \App\Events\CustomerActivity  $event
     * @return void
     */
    
     public function handle(CustomerActivity $event)
    {
        ActivityLog::create([
            'customer_id' => $event->customer->id,
            'activity' => $event->activity,
        ]);
    }
}
