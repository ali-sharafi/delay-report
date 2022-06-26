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
}
