<?php

namespace Tests\Unit;

use App\Contracts\DelayReportInterface;
use App\Enum\OrderStatusEnum;
use App\Events\OrderStatusChanged;
use App\Models\Order;
use App\Services\DelayReportService;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Redis;
use Tests\TestCase;

class DelayReportServiceTest extends TestCase
{
    protected $delayReportService;

    public function setUp(): void
    {
        parent::setUp();

        $this->delayReportService = app()->make(DelayReportService::class);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_can_add_delay_to_queue()
    {
        Event::fake();

        $order = Order::factory()->create();

        $this->delayReportService->addDelayReortToQueue($order);

        $itemsInQueue = Redis::llen(DelayReportInterface::REDIS_DELAY_KEY);

        $this->assertEquals(1, $itemsInQueue);

        Event::assertDispatched(function (OrderStatusChanged $event) use ($order) {
            return $event->order->id === $order->id && $event->status == OrderStatusEnum::DELAY_QUEUE;
        });
    }

    /** @test */
    public function test_can_create_new_order_delivery_time()
    {
        $order = Order::factory()->create();

        $deliveryTime = $this->delayReportService->createNewOrderDeliveryTime($order);

        $this->assertEquals($order->fresh()->delivery_at, $deliveryTime);
    }
}
