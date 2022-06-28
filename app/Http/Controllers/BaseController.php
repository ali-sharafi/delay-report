<?php

namespace App\Http\Controllers;

use App\Traits\ResponseHandler;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    use ResponseHandler;

    public function __construct(protected Request $request)
    {
    }
}
