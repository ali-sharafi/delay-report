<?php

namespace App\Services;

use App\Contracts\OrderInterface;
use App\Enum\TripStatusEnum;
use App\Models\Order;
use Carbon\Carbon;

class OrderService implements OrderInterface
{
    /**
     * Find an order by id
     * 
     * @param int $orderID
     * 
     * @return \App\Models\Order
     */
    public function findOrder(int $orderID): Order
    {
        return Order::find($orderID);
    }
    
    /**
     * Check an order to add new delay report
     * 
     * @param \App\Models\Order $order
     * 
     * @return bool
     */
    public function isNeedNewDelayTime(Order $order): bool
    {
        return isset($order->trip) &&
            in_array($order->trip->status, [
                TripStatusEnum::ASSIGNED,
                TripStatusEnum::AT_VENDOR,
                TripStatusEnum::PICKED
            ]);
    }

    /**
     * Find delay time to delivery for an order
     * 
     * @param \App\Models\Order $order
     * 
     * @return mixed
     */
    public function findOrderDelayTime(Order $order): string
    {
        $delayTimeEstimatorService = new DelayTimeEstimatorService();
        $delayTime = $delayTimeEstimatorService->estimate($order);

        if (empty($delayTime)) return $order->delivery_at;

        $this->saveOrderDelayTime($order, $delayTime);

        return $order->delivery_at;
    }

    /**
     * Save new order delay time into DB
     * 
     * @param \App\Models\Order $order
     * @param int $delayTime
     * 
     * @return void
     */
    private function saveOrderDelayTime(Order $order, int $delayTime): void
    {
        $order->delivery_time = $delayTime;
        $order->delivery_at = Carbon::now()->addMinutes($delayTime);
        $order->save();
    }
}
