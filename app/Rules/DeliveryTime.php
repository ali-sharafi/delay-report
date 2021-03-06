<?php

namespace App\Rules;

use App\Services\OrderService;
use Illuminate\Contracts\Validation\Rule;

class DeliveryTime implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $value['delivery_at'] < now()->format('Y-m-d H:i:s');
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('delay_report.delivery_time_not_expired');
    }
}
