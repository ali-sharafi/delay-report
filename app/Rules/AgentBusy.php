<?php

namespace App\Rules;

use Facades\App\Services\AgentService;
use Illuminate\Contracts\Validation\Rule;

class AgentBusy implements Rule
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
        return !(AgentService::hasActiveOrder($value));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('delay_report.agent_has_order');
    }
}
