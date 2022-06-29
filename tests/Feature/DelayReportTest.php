<?php

namespace Tests\Feature;

use App\Contracts\DelayReportInterface;
use App\Models\Agent;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Redis;
use Tests\TestCase;

class DelayReportTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_can_add_new_delay_report()
    {
        $order = Order::factory()->create([
            'delivery_time' => 10,
            'delivery_at' => Carbon::now()->subMinutes(5)
        ]);

        $this->postJson("/api/v1/orders/{$order->id}/delay-reports", [])
            ->assertStatus(200);

        $this->assertDatabaseCount('delay_reports', 1);

        $this->assertEquals(1, Redis::llen(DelayReportInterface::REDIS_DELAY_KEY));
    }

    /** @test */
    public function test_can_not_add_delay_report_before_delivery_time()
    {
        $order = Order::factory()->create();

        $this->postJson("/api/v1/orders/{$order->id}/delay-reports", [])
            ->assertStatus(422)
            ->assertExactJson([
                'status' => 'Error',
                'message' => __('delay_report.delivery_time_not_expired')
            ]);
    }

    /** @test */
    public function test_can_not_add_a_delay_report_twice()
    {
        $order = Order::factory()->create([
            'delivery_time' => 10,
            'delivery_at' => Carbon::now()->subMinutes(5)
        ]);

        $this->postJson("/api/v1/orders/{$order->id}/delay-reports", []);

        $this->postJson("/api/v1/orders/{$order->id}/delay-reports", [])
            ->assertStatus(422)
            ->assertExactJson([
                'status' => 'Error',
                'message' => __('delay_report.order_in_queue_already')
            ]);
    }

    /** @test */
    public function test_can_assign_a_delay_report_to_agent()
    {
        $agent = Agent::factory()->create();
        $order = Order::factory()->create([
            'delivery_time' => 10,
            'delivery_at' => Carbon::now()->subMinutes(5)
        ]);

        $this->postJson("/api/v1/orders/{$order->id}/delay-reports", []);

        $this->postJson("/api/v1/delay-reports/assign", [
            'agent' => $agent->id
        ])
            ->assertStatus(200)
            ->assertJson([
                'status' => 'Success',
                'data' => $order->toArray()
            ]);

        $this->assertEquals(0, Redis::llen(DelayReportInterface::REDIS_DELAY_KEY));
    }

    /** @test */
    public function test_can_not_assign_delay_report_when_agent_is_busy()
    {
        $agent = Agent::factory()->create();
        $order = Order::factory(2)->create([
            'delivery_time' => 10,
            'delivery_at' => Carbon::now()->subMinutes(5)
        ]);

        $this->postJson("/api/v1/orders/{$order[0]->id}/delay-reports", []);
        $this->postJson("/api/v1/orders/{$order[1]->id}/delay-reports", []);

        $this->postJson("/api/v1/delay-reports/assign", [
            'agent' => $agent->id
        ]);

        $this->postJson("/api/v1/delay-reports/assign", [
            'agent' => $agent->id
        ])
            ->assertStatus(422)
            ->assertExactJson([
                'status' => 'Error',
                'message' => __('delay_report.agent_has_order')
            ]);
    }

    /** @test */
    public function test_can_not_reassign_an_order_to_agents()
    {
        $agent = Agent::factory()->create();
        $order = Order::factory()->create([
            'delivery_time' => 10,
            'delivery_at' => Carbon::now()->subMinutes(5)
        ]);

        $this->postJson("/api/v1/orders/{$order->id}/delay-reports", []);

        $this->postJson("/api/v1/delay-reports/assign", [
            'agent' => $agent->id
        ]);

        $anotherAgent = Agent::factory()->create();

        $this->postJson("/api/v1/delay-reports/assign", [
            'agent' => $anotherAgent->id
        ])
            ->assertStatus(200)
            ->assertExactJson([
                'status' => 'Success',
                'data' => []
            ]);
    }

    /** @test */
    public function test_can_get_report()
    {
        $order = Order::factory()->create([
            'delivery_time' => 10,
            'delivery_at' => Carbon::now()->subMinutes(5)
        ]);

        $this->postJson("/api/v1/orders/{$order->id}/delay-reports", []);

        $this->getJson("/api/v1/delay-reports/current-week")
            ->assertStatus(200)
            ->assertJson([
                'status' => 'Success',
                'data' => [
                    [
                        'vendor_id' => $order->vendor_id
                    ]
                ]
            ]);
    }
}
