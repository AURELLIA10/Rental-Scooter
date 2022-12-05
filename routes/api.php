<?php

use App\Http\Controllers\Api\Admin\ScooterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Admin\TransactionController;
use App\Http\Controllers\Api\User\MyOrderController;
use App\Http\Controllers\Api\User\RentScooterController;
use App\Http\Controllers\Api\User\ScooterController as UserScooterController;

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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::prefix('admin')->group(function () {
        Route::resource('scooter', ScooterController::class);
        Route::resource('transaction', TransactionController::class);
    });

    Route::get('my-order', [MyOrderController::class, 'index']);
    Route::post('process-payment', [MyOrderController::class, 'processPaymentRent']);
    Route::post('rent-scooter/{scooter:slug}', [RentScooterController::class, 'store']);

    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::get('scooter', [UserScooterController::class, 'index']);
Route::get('scooter/{scooter:slug}', [UserScooterController::class, 'show']);
