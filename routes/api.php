<?php

use App\Http\Controllers\DelayReportController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => '/v1'], function () {

    Route::post('/orders/{order}/delay-reports', [DelayReportController::class, 'store']);

    Route::post('/delay-reports/assign', [DelayReportController::class, 'assign']);

    Route::get('/delay-reports/current-week', [DelayReportController::class, 'getCurrentWeekDelayReports']);
});
