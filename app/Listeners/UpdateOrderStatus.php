<?php

namespace App\Listeners;

use App\Events\OrderStatusChanged;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateOrderStatus
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(protected OrderService $orderService)
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\OrderStatusChanged  $event
     * @return void
     */
    public function handle(OrderStatusChanged $event)
    {
        $this->orderService->updateOrderStatus($event->order, $event->status, $event->agent);
    }
}
