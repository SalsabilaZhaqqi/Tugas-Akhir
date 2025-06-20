<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MonitoringController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('monitoring')->group(function () {
    Route::get('/history', [MonitoringController::class, 'getHistory']);
    Route::get('/latest', [MonitoringController::class, 'getLatest']);
    Route::get('/status', [MonitoringController::class, 'getStatus']);
    Route::get('/export', [MonitoringController::class, 'exportData']);
    Route::get('/current-data', [DashboardController::class, 'getCurrentData']);
});

// Alternative routes for backwards compatibility
Route::get('/api/monitoring/history', [MonitoringController::class, 'getHistory']);
Route::get('/api/monitoring/latest', [MonitoringController::class, 'getLatest']);
Route::get('/api/monitoring/export', [MonitoringController::class, 'exportData']);
