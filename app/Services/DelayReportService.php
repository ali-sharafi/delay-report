<?php

namespace App\Services;

use App\Contracts\DelayReportInterface;
use App\Models\Order;
use Illuminate\Support\Facades\Redis;

class DelayReportService  implements DelayReportInterface
{
    /**
     * Create new delay report for an order
     * 
     * @param \App\Models\Order $order
     * 
     * @return void
     */
    public function create(Order $order): void
    {
        Redis::rpush('delay_report_list', $order->id);
    }
}
