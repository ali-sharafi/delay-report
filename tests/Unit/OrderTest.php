<?php

namespace Tests\Unit;

use App\Contracts\DelayReportInterface;
use App\Enum\OrderStatusEnum;
use App\Events\OrderStatusChanged;
use App\Models\Agent;
use App\Models\Order;
use App\Services\DelayReportService;
use App\Services\OrderService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Redis;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_can_update_an_order_status()
    {
        $order = Order::factory()->create();

        $agent = Agent::factory()->create();

        $service = app()->make(OrderService::class);

        $service->updateOrderStatus($order, OrderStatusEnum::ASSIGNED_AGENT, $agent->id);

        $freshOrder = $order->fresh();

        $this->assertEquals(OrderStatusEnum::ASSIGNED_AGENT->value, $freshOrder->status);

        $this->assertEquals($agent->id, $freshOrder->agent_id);
    }
}
