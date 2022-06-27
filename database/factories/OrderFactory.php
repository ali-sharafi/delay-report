<?php

namespace Database\Factories;

use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $deliveryTime = rand(10, 50);
        $vendor = Vendor::factory()->create();
        return [
            'delivery_time' => $deliveryTime,
            'delivery_at' => Carbon::now()->addMinutes($deliveryTime),
            'vendor_id' => $vendor->id
        ];
    }
}
