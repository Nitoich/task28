<?php

use Illuminate\Http\Request;
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

Route::post('/login', [\App\Http\Controllers\api\v1\AuthController::class, 'login']);
Route::post('/register', [\App\Http\Controllers\api\v1\AuthController::class, 'register']);

Route::middleware('jwt_auth')->group(function () {
    Route::resource('cars', \App\Http\Controllers\api\v1\CarController::class, [
        'only' => [
            'index',
            'show',
            'update',
            'destroy',
            'store'
        ]
    ]);

    Route::resource('shares', \App\Http\Controllers\api\v1\ShareAccessController::class, [
        'only' => [
            'store',
            'destroy'
        ]
    ]);

    Route::resource('users.cars', \App\Http\Controllers\api\v1\UserShareAccessController::class, [
        'only' => [
            'index'
        ]
    ]);
});
