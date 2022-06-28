<?php

namespace App\Contracts;

use App\Models\Order;

interface DelayReportInterface
{
    const REDIS_DELAY_KEY = 'delay_report_list';

    public function create(Order $order): string;
    public function createNewOrderDeliveryTime(Order $order): int;
    public function addDelayReortToQueue(Order $order): void;
    public function assignDelayToAgent(int $agentID): mixed;
    public function findCurrentWeekDelays(): mixed;
}
