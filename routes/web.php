<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Clear Cache facade value:
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    return '<h1>Cache facade value cleared</h1>';
});

//Reoptimized class loader:
Route::get('/optimize', function() {
    $exitCode = Artisan::call('optimize');
    return '<h1>Reoptimized class loader</h1>';
});

//Route cache:
Route::get('/route-cache', function() {
    $exitCode = Artisan::call('route:cache');
    return '<h1>Routes cached</h1>';
});

//Clear Route cache:
Route::get('/route-clear', function() {
    $exitCode = Artisan::call('route:clear');
    return '<h1>Route cache cleared</h1>';
});

//Clear View cache:
Route::get('/view-clear', function() {
    $exitCode = Artisan::call('view:clear');
    return '<h1>View cache cleared</h1>';
});

//Clear Config cache:
Route::get('/config-cache', function() {
    $exitCode = Artisan::call('config:cache');
    return '<h1>Clear Config cleared</h1>';
});


Route::group([
    'as' => 'passport.',
    'prefix' => config('passport.path', 'oauth'),
    'namespace' => 'Laravel\Passport\Http\Controllers',
], function () {
    // Passport routes...
});



Route::post('sign-in', [AuthenticatedSessionController::class,'signin']);



Route::get('/', function () {
    return view('welcome');
});



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

 require __DIR__.'/auth.php';


Route::group(['middleware' => ['auth']], function()

{
    Route::get('logout', [AuthenticatedSessionController::class,'logout']);
    Route::get('pin-verify', [AuthenticatedSessionController::class,'pin_verify']);
    Route::post('pin-verify-now', [AuthenticatedSessionController::class,'pin_verify_now']);
    Route::post('pin-request', [AuthenticatedSessionController::class,'pin_request']);



    //Dashboard
    Route::get('agent-dashboard', [DashboardController::class,'agent_dashboard']);


    //banktransfer
    Route::post('bank-transfer-now', [TransactionController::class,'bank_transfer']);
    Route::get('bank-transfer', [TransactionController::class,'bank_transfer_view']);



    //Transaction Table
    Route::get('transaction', [TransactionController::class,'transactions']);
    Route::get('search', 'TransactionController@search');











});
