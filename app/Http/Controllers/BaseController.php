<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function __construct(protected Request $request)
    {
    }

    public function successReponse($status = 'Success', $data = [], $statusCode = 200)
    {
        return response()->json([
            'status' => $status,
            'data' => $data
        ], $statusCode);
    }

    public function errorResponse($status = 'Error', $message = 'Some Error occured', $statusCode = 400)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
        ], $statusCode);
    }
}
