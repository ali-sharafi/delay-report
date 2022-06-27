<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\DelayReportService;
use App\Services\OrderService;

class DelayReportController extends BaseController
{
    public function store(Order $order, OrderService $orderService, DelayReportService $delayReportService)
    {
        if ($orderService->isNeedNewDelayTime($order)) {
            $deliveryTime = $orderService->findOrderDelayTime($order);

            $message = "Your order will devliver at $deliveryTime";
            return $this->successReponse(static::SUCCESS, $message);
        }

        $delayReportService->create($order);

        return $this->successReponse();
    }
}
