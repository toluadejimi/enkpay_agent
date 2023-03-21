<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterationController;
use App\Http\Controllers\DeviceOrderController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;








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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//Registration
Route::post('verify-phone', [RegisterationController::class, 'phone_verification']);
Route::post('resend-otp', [RegisterationController::class, 'resend_otp']);
Route::post('verify-otp', [RegisterationController::class, 'verify_otp']);
Route::post('register', [RegisterationController::class, 'register']);


//Device Order
Route::post('order-device', [DeviceOrderController::class, 'order_device']);
Route::get('bank-details', [DeviceOrderController::class, 'bank_details']);
Route::get('all-pickup-location', [DeviceOrderController::class, 'all_pick_up_location']);
Route::post('state-pickup', [DeviceOrderController::class, 'state_pick_up_location']);
Route::post('lga-pickup', [DeviceOrderController::class, 'lga_pick_up_location']);



//Login
Route::post('login', [LoginController::class, 'login']);

//dashboard
Route::group(['middleware' => ['auth:api','acess']], function(){

    Route::post('cash-out', [LoginController::class, 'hood']);

    Route::get('user-info', [LoginController::class, 'user_info']);







});











