<?php

namespace App\Services;

use App\Contracts\AgentInterface;
use App\Models\Order;

class AgentService implements AgentInterface
{
    /**
     * Check order table to find does have any active order or not
     * 
     * @param int $agentID
     * 
     * @return bool
     */
    public function hasActiveOrder(int $agentID): bool
    {
        return Order::forAgent($agentID)->count() > 0;
    }
}
