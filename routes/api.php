<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\FoodController;
use App\Http\Controllers\API\TransactionController;

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
Route::post('/user/registration', [UserController::class, 'store']);

Route::post('/auth/signin', [AuthController::class, 'signin']);

Route::resource('/food', FoodController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [UserController::class, 'index']);
    Route::post('/user/{id}', [UserController::class, 'update']);
    Route::post('/user/{id}/address', [UserController::class, 'updateAddress']);

    Route::get('/transaction', [TransactionController::class, 'index']);
    Route::get('/transaction/{id}', [TransactionController::class, 'show']);

    Route::get('/auth/signout', [AuthController::class, 'signout']);
});
