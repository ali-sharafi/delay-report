<?php

namespace Tests\Unit;

use App\Models\Agent;
use App\Models\Order;
use App\Services\AgentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AgentServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $agentService;

    public function setUp(): void
    {
        parent::setUp();

        $this->agentService = app()->make(AgentService::class);
    }

    /** @test */
    public function test_an_agent_has_order_return_false()
    {
        $agent = Agent::factory()->create();

        $result = $this->agentService->hasActiveOrder($agent->id);

        $this->assertFalse($result);
    }

    /** @test */
    public function test_an_agent_has_order_return_true()
    {
        $agent = Agent::factory()->create();

        Order::factory()->create(['agent_id' => $agent->id]);

        $result = $this->agentService->hasActiveOrder($agent->id);

        $this->assertTrue($result);
    }
}
