<?php

namespace App\Services;

use App\Contracts\DelayTimeEstimatorInterface;
use App\Models\Order;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DelayTimeEstimatorService implements DelayTimeEstimatorInterface
{
    /**
     * Estimate new delay time for order
     * 
     * @param \App\Models\Order $order
     * 
     * @return mixed
     */
    public function estimate(Order $order): int|null
    {
        try {
            $response = Http::get('https://run.mocky.io/v3/122c2796-5df4-461c-ab75-87c1192b17f7');

            $responseBody = $response->json('data');

            return $responseBody->eta;
        } catch (Exception $e) {
            Log::debug($e);
            return null;
        }
    }
}
