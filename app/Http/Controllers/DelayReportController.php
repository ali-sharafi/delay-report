<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\DelayReportService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DelayReportController extends BaseController
{
    public function __construct(protected Request $request, protected DelayReportService $delayReportService)
    {
        parent::__construct($request);
    }

    public function store(Order $order)
    {
        $response = $this->delayReportService->create($order);

        return $this->successReponse(static::SUCCESS, ['message' => $response]);
    }

    public function assign()
    {
        $this->request->validate(['agent' => 'required']);

        $response = $this->delayReportService->assignDelayToAgent($this->request->agent);

        return $this->successReponse(static::SUCCESS, $response);
    }

    public function getCurrentWeekDelayReports()
    {
        $startDate = Carbon::now()->subDays(7)->format('Y-m-d');
        $endDate = now()->format('Y-m-d');

        $response = $this->delayReportService->findDelays($startDate, $endDate);

        return $this->successReponse(static::SUCCESS, ['data' => $response]);
    }
}
