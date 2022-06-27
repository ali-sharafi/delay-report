<?php

namespace App\Contracts;

use App\Models\Order;

interface OrderInterface
{
    public function isNeedNewDelayTime(Order $order): bool;

    public function findOrderDelayTime(Order $order): mixed;

    public function findOrder(int $orderID): Order;
}
