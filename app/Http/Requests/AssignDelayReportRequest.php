<?php

namespace App\Http\Requests;

use App\Models\Agent;
use App\Rules\AgentBusy;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AssignDelayReportRequest extends BaseRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'agent' => [
                'required',
                Rule::exists(Agent::class, 'id'),//This should be replaced when the authentication part is added and get agent id through the signed-in user
                new AgentBusy()
            ]
        ];
    }
}
