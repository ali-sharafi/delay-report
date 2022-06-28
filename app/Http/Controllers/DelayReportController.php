<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignDelayReportRequest;
use App\Http\Requests\StoreDelayReportRequest;
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

    public function store(Order $order, StoreDelayReportRequest $request)
    {
        $response = $this->delayReportService->create($order);

        return $this->successReponse($response);
    }

    public function assign(AssignDelayReportRequest $request)
    {
        $response = $this->delayReportService->assignDelayToAgent($request->agent);

        return $this->successReponse($response);
    }

    public function getCurrentWeekDelayReports()
    {
        $startDate = Carbon::now()->subDays(7)->format('Y-m-d');
        $endDate = now()->format('Y-m-d');

        $response = $this->delayReportService->findDelays($startDate, $endDate);

        return $this->successReponse($response);
    }
}
