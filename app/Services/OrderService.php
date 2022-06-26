<?php

namespace App\Services;

use App\Contracts\OrderInterface;
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
    public function canAddDelayReportToOrder(Order $order): bool
    {
        return true;
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
