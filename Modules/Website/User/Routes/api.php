<?php

use Illuminate\Support\Facades\Route;
use Modules\Website\User\Http\Controllers\AuthController;

Route::group([
    'prefix' => 'website/user',
], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);

    Route::group([
        'middleware' => 'auth:client'
    ], function () {
        Route::apiResource('babies', BabyController::class);
        Route::apiResource('partners', PartnerController::class)->only('index', 'store');
    });
});
