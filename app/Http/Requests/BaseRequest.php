<?php

namespace App\Http\Requests;

use App\Traits\ResponseHandler;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class BaseRequest extends FormRequest
{
    use ResponseHandler;

    public function failedValidation($validator)
    {
        throw  new HttpResponseException($this->errorResponse($validator->errors()->first(), Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
