<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;

use App\Http\Controllers\API\AreaController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\AccParentController;
use App\Http\Controllers\API\AccTypeController;
use App\Http\Controllers\API\AccountsController;
use App\Http\Controllers\API\CuurencyController;

use App\Http\Controllers\API\VouchersController;
use App\Http\Controllers\API\VouchersDetailController;

use App\Http\Controllers\API\CashBookController;
use App\Http\Controllers\API\LedgerController;

// For AuthController Fucntions Calling. 1- Signup, 2- Login
Route::post('signup', [AuthController::class, 'signup']);
Route::post('login', [AuthController::class, 'login']);

// For Group Function Calling Same Resource like Sanctum
Route::middleware('auth:sanctum')->group(function()
{
    Route::post('logout', [AuthController::class, 'logout']);

    Route::apiResource('posts', PostController::class);
    Route::apiResource('currency', CuurencyController::class);
    Route::apiResource('area', AreaController::class);
    Route::apiResource('accType', AccTypeController::class);
    Route::apiResource('accParent', AccParentController::class);
    Route::apiResource('accounts', AccountsController::class);
    
    Route::apiResource('vouchers', VouchersController::class);
    Route::apiResource('vouchersDetail', VouchersDetailController::class);

    Route::apiResource('cashbook', CashBookController::class);
    Route::apiResource('acledger', LedgerController::class);

});
