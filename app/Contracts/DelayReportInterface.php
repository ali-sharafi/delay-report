<?php

namespace App\Contracts;

use App\Models\Order;

interface DelayReportInterface
{
    public function create(Order $order): string;
    public function createNewOrderDeliveryTime(Order $order): int;
    public function addDelayReortToQueue(Order $order): void;
}
