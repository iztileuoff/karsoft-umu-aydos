<?php

use App\Http\Controllers\Api\V1\Auth\AuthenticationController;
use App\Http\Controllers\Api\V1\Auth\CodeController;
use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\Auth\LogoutController;
use App\Http\Controllers\Api\V1\Auth\UserController;

Route::group([
    'prefix'     => 'auth',
    'as'         => 'auth.',
], function () {
    Route::get('user', UserController::class);
    Route::post('code', CodeController::class);
    Route::post('login', LoginController::class);
    Route::delete('logout', LogoutController::class);
    Route::post('authentication', AuthenticationController::class);
});
