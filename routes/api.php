<?php

Route::namespace('Auth')->group(function(){
    Route::post('/auth/register', 'RegisterController');
    Route::post('/auth/verification', 'VerificationController');
    Route::post('/auth/regenerate-otp', 'RegenerateOtpController');
    Route::post('/auth/update-password', 'UpdatePasswordController');
    Route::post('/auth/login', 'LoginController');
    Route::post('/auth/logout', 'LogoutController');

});

Route::get('profile', 'Profile\ProfileController');