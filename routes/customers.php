<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerInfoController;
use App\Http\Controllers\CustomerOrderController;
use App\Http\Controllers\CustomerAddressController;
use App\Http\Controllers\CustomerOrderStatusController;


Route::group(['middleware' => 'guest'], function () {
    Route::post('signup', [UserController::class, 'customerSignup']);
});



Route::group(['middleware' => 'auth:api'], function () {
    Route::get('profile', [CustomerInfoController::class, 'getCustomerProfile']);
    Route::post('update-profile', [CustomerInfoController::class, 'updateProfile']);
    Route::post('/upload-rofile-picture', [CustomerInfoController::class, 'uploadProfilePicture']);
    Route::resource('addresses', CustomerAddressController::class);
    Route::resource('orders/statuses', CustomerOrderStatusController::class);
    Route::resource('orders', CustomerOrderController::class);
});

// Route::group(['prefix' => 'user'], function () { //These Routes will be moved to Producers.
//     Route::resource('', UserController::class);
//     Route::post('/profile/update', [UserController::class, 'update']);
//     Route::post('/upload-rofile-picture', [UserController::class, 'uploadProfilePicture']);
// });