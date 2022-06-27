<?php

namespace App\Contracts;

use App\Models\Order;

interface DelayTimeEstimatorInterface
{
    public function estimate(Order $order): int|null;
}
