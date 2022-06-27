<?php

namespace App\Contracts;

use App\Models\Order;

interface DelayReportInterface
{
    public function create(Order $order): void;
}
