<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\DelayReportService;
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

        return $this->successReponse($response);
    }
}
