<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\DelayReportService;

class DelayReportController extends BaseController
{
    public function store(Order $order, DelayReportService $delayReportService)
    {
        $response = $delayReportService->create($order);

        return $this->successReponse(static::SUCCESS, ['message' => $response]);
    }
}
