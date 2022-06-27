<?php

namespace App\Listeners;

use App\Events\OrderDelayed;
use App\Models\DelayReport;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class StoreOrderDelay
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
     * @param  \App\Events\OrderDelayed  $event
     * @return void
     */
    public function handle(OrderDelayed $event)
    {
        DelayReport::create([
            'vendor_id' => $event->order->vendor->id,
            'order_id' => $event->order->id,
            'delay_time' => abs(Carbon::parse($event->lastDeliveryTime)->diffInMinutes(now())),
            'date_at' => now()->format('Y-m-d')
        ]);
    }
}
