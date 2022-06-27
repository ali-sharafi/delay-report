<?php

namespace App\Services;

use App\Contracts\OrderInterface;
use App\Enum\TripStatusEnum;
use App\Models\Order;

class OrderService implements OrderInterface
{
    /**
     * Check an order to add new delay report
     * 
     * @param \App\Models\Order $order
     * 
     * @return bool
     */
    public function isNeedNewDelayTime(Order $order): bool
    {
        return isset($order->trip) &&
            in_array($order->trip->status, [
                TripStatusEnum::ASSIGNED,
                TripStatusEnum::AT_VENDOR,
                TripStatusEnum::PICKED
            ]);
    }

    /**
     * Find delay time to delivery for an order
     * 
     * @param \App\Models\Order $order
     * 
     * @return mixed
     */
    public function findOrderDelayTime(Order $order)
    {
        # code...
    }
}
