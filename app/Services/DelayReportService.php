<?php

namespace App\Services;

use App\Contracts\DelayReportInterface;
use App\Models\Order;
use Illuminate\Support\Facades\Redis;

class DelayReportService  implements DelayReportInterface
{
    public function __construct(protected OrderService $orderService)
    {
    }
    /**
     * Create new delay report for an order
     * 
     * @param \App\Models\Order $order
     * 
     * @return string
     */
    public function create(Order $order): string
    {
        $response = __('delay_report.delay_report_created');

        if ($this->orderService->isNeedNewDelayTime($order)) {
            $deliveryTime = $this->createNewOrderDeliveryTime($order);
            $response = __('delay_report.new_delivery_time', ['time' => $deliveryTime]);
        } else $this->addDelayReortToQueue($order);

        return $response;
    }

    /**
     * Add new delay report to queue
     * 
     * @param \App\Models\Order
     * 
     * @return void
     */
    public function addDelayReortToQueue(Order $order): void
    {
        Redis::rpush('delay_report_list', $order->id);
    }

    /**
     * Create new delivery time to an order
     * 
     * @param \App\Models\Order $order
     * 
     * @return int
     */
    public function createNewOrderDeliveryTime(Order $order): int
    {
        $deliveryTime = $this->orderService->findOrderDelayTime($order);

        return $deliveryTime;
    }
}
