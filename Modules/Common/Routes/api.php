<?php

use Illuminate\Support\Facades\Route;

Route::group(
    [
        'prefix' => 'common'
    ],
    function () {
        Route::get('email/verify/{id}', 'VerificationController@verify')->name('verification.verify');
        Route::get('email/resend', 'VerificationController@resend')->name('verification.resend');
        Route::get('is-verified', 'VerificationController@isVerified');
    }
);
