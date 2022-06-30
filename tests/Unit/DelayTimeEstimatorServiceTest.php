<?php

namespace Tests\Unit;

use App\Models\Order;
use App\Services\DelayTimeEstimatorService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DelayTimeEstimatorServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $estimatorService;

    public function setUp(): void
    {
        parent::setUp();

        $this->estimatorService = app()->make(DelayTimeEstimatorService::class);
    }

    /** @test */
    public function test_estimator_works()
    {
        $order = Order::factory()->create();

        $result = $this->estimatorService->estimate($order);

        $this->assertIsNumeric($result);
    }
}
