<?php

namespace App\Services;

use App\Contracts\DelayReportInterface;
use App\Events\OrderDelayed;
use App\Models\DelayReport;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class DelayReportService  implements DelayReportInterface
{
    public function __construct(protected OrderService $orderService)
    {
    }

    /**
     * Find stored delays by date period
     * 
     * @param string $startDate
     * @param string $endDate
     * 
     * @return mixed
     */
    public function findDelays(string $startDate, string $endDate): mixed
    {
        return DelayReport::with(['vendor:name,id'])
            ->dateBetween($startDate, $endDate)
            ->groupBy('vendor_id')
            ->orderBy('delay_time', 'Desc')
            ->get(['vendor_id', DB::raw('SUM(delay_time) as delay_time')]);
    }

    /**
     * Assign first item in queue to agent
     * 
     * @param int $agentID
     * @return mixed
     */
    public function assignDelayToAgent(int $agentID): mixed
    {
        $item = Redis::lPop(static::REDIS_DELAY_KEY);
        $response = ['data' => []];

        if ($item) {
            $order = $this->orderService->findOrder($item);
            $order->agent_id = $agentID;
            $order->save();
            $response = ['data' => $order];
        }

        return $response;
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
        OrderDelayed::dispatch($order, $order->delivery_at);

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
        Redis::rpush(static::REDIS_DELAY_KEY, $order->id);
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
