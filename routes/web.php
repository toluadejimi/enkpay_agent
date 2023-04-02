<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\LoginController;







Route::post('sign-in', [LoginController::class,'login']);

Route::get('login', [AuthenticatedSessionController::class,'login']);


Route::get('verify', [LoginController::class,'verify_page']);

Route::post('verify-now', [LoginController::class,'pin_verify']);


Route::get('transaction', [DashboardController::class,'index']);


Route::get('welcome', [AuthenticatedSessionController::class,'login']);







Route::get('/', function () {
    return view('welcome');
});



// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

//  require __DIR__.'/auth.php';


Route::group(['middleware' => ['auth']], function()

{
    Route::get('logout', [LoginController::class,'logout']);
    Route::post('pin-verify-now', [LoginController::class,'pin_verify_now']);
    Route::post('pin-request', [LoginController::class,'pin_request']);



    //Dashboard
    Route::get('agent-dashboard', [DashboardController::class,'agent_dashboard']);


    //banktransfer
    Route::post('bank-transfer-now', [TransactionController::class,'bank_transfer']);
    Route::get('bank-transfer', [TransactionController::class,'bank_transfer_view']);
    Route::get('transfer-preview', [TransactionController::class,'transfer_preview']);
    Route::post('pay-now', [TransactionController::class,'pay_now']);







    //Transaction Table
    Route::get('search', 'TransactionController@search');











});
