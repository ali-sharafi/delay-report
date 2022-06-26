<?php

namespace App\Contracts;

use App\Models\Order;

interface OrderInterface
{
    public function canAddDelayReportToOrder(Order $order): bool;

    public function findOrderDelayTime(Order $order): mixed;
}
