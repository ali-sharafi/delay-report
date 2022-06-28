<?php

namespace App\Contracts;

interface AgentInterface
{
    public function hasActiveOrder(int $agentID): bool;
}
