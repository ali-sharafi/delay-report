<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BaseController extends Controller
{
    /**
     * @var
     * 
     * Responses statuses
     */
    const SUCCESS = 'Success',
        ERROR = 'Error',
        ERROR_MESSAGE = 'Some Error occured';

    public function __construct(protected Request $request)
    {
    }

    /**
     * Send a success response to client
     * 
     * @param static::SUCCESS $status
     * @param array $data
     * @param \Illuminate\Http\Response::HTTP_OK
     * 
     * @return \Illuminate\Http\Response
     */
    public function successReponse($status = self::SUCCESS, $data = [], $statusCode = Response::HTTP_OK)
    {
        return response()->json([
            'status' => $status,
            'data' => $data
        ], $statusCode);
    }

    /**
     * Send a success response to client
     * 
     * @param static::ERROR $status
     * @param string $message
     * @param \Illuminate\Http\Response::HTTP_BAD_REQUEST
     * 
     * @return \Illuminate\Http\Response
     */
    public function errorResponse($status = self::ERROR, $message = self::ERROR_MESSAGE, $statusCode = Response::HTTP_BAD_REQUEST)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
        ], $statusCode);
    }
}
