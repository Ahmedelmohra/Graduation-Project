<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\clientsController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\walletController;
use App\Http\Controllers\RechargeController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\ReciptsController;

use App\Http\Controllers\AuthController;


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
Route::post('/test' , [TestController::class , 'store'])->name('test.store');

//CLIENTS
Route::get('/clients', [clientsController::class, 'index']);
Route::get('/clients/{id}', [clientsController::class, 'show']);
Route::post('/clients', [clientsController::class, 'store']);
Route::post('/clients/{id}', [clientsController::class, 'update']);
Route::get('/clients/{id}/payments', [clientsController::class, 'payments']);
Route::get('/clients/{id}/recipts', [clientsController::class, 'recipts']);
Route::get('/clients/{id}/wallet', [clientsController::class, 'wallet']);


//PAYMENT
Route::get('/payments', [PaymentsController::class, 'index']);
Route::get('/payments/{id}', [PaymentsController::class, 'show']);
Route::post('/payments', [PaymentsController::class, 'store']);  

//OTP
Route::get('/otps', [OtpController::class, 'index']);
Route::get('/otps/{id}', [OtpController::class, 'show']);
Route::post('/otps', [OtpController::class, 'store']);  

//RECIPTS
Route::get('/recipts', [ReciptsController::class, 'index']);
Route::get('/recipts/{id}', [ReciptsController::class, 'show']);
Route::post('/recipts', [ReciptsController::class, 'store']);  

//COMPANY
Route::get('/comp', [CompaniesController::class, 'index']);
Route::get('/comp/{id}', [CompaniesController::class, 'show']);
Route::post('/comp', [CompaniesController::class, 'store']);
Route::get('/comp/{id}/recipts', [CompaniesController::class, 'recipts']);


//WALLET
Route::get('/wallets', [walletController::class, 'index']);
Route::get('/wallets/{id}', [walletController::class, 'show']);
Route::post('/wallets', [walletController::class, 'store']); 


//RECHARGE INFO
Route::get('/recharge', [RechargeController::class, 'index']);
Route::get('/recharge/{id}', [RechargeController::class, 'show']);
Route::post('/recharge', [RechargeController::class, 'store']); 





//AuthintcTION
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);







