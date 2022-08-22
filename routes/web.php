<?php

use App\Http\Controllers\CheckOutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('Dashboard'                      , [DashboardController::class , 'index'])
    ->name('dashboard');

Route::post('check/login/admin'             , [UserController::class , 'checkLogin'])
    ->name('check.login');

Route::get('Payment/Methods'                , [PaymentMethodController::class , 'index'])
    ->name('payment.methods.all');

Route::get('Payment/Method/create'          , [PaymentMethodController::class , 'create'])
    ->name('payment.method.create');

Route::post('Payment/Method/store'          , [PaymentMethodController::class , 'store'])
    ->name('payment.method.store');

Route::get('Payment/Method/{id}/edit'       , [PaymentMethodController::class , 'edit'])
    ->name('payment.method.edit');

Route::put('Payment/Method/{id}/update'     , [PaymentMethodController::class , 'update'])
    ->name('payment.method.update');

    Route::get('checkout'                   , [CheckOutController::class , 'index'])
    ->name('checkout');

    Route::post('checkout/store'            , [CheckOutController::class , 'store'])
    ->name('checkout.store');


Route::any('payment/cancel' , function(){

})->name('payment.cancel');

Route::any('payment/return' , function(){

})->name('payment.return');
