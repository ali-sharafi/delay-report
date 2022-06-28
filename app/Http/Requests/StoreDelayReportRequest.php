<?php

namespace App\Http\Requests;

use App\Rules\DeliveryTime;
use App\Rules\UniqueDelayReport;

class StoreDelayReportRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->mergeIfMissing(['order' => $this->order]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'order' => ['required', new DeliveryTime(), new UniqueDelayReport()]
        ];
    }
}
