<?php

namespace App\Services;

use App\Contracts\DelayTimeEstimatorInterface;
use App\Models\Order;

class DelayTimeEstimatorService implements DelayTimeEstimatorInterface
{
    /**
     * Estimate new delay time for order
     * 
     * @param \App\Models\Order $order
     * 
     * @return mixed
     */
    public function estimate(Order $order): mixed
    {
        return 'Estimated';
    }
}
