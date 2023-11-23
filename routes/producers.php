<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProducerOrderController;

Route::group(['middleware' => 'auth:api'], function () {
    Route::resource('orders', ProducerOrderController::class);

    Route::group(['prefix' => 'products'], function () { //These Routes will be moved to Producers.
        Route::get('all', [ProductController::class, 'producerProducts']);
        Route::post('', [ProductController::class, 'store']);
        Route::post('/{uuid}', [ProductController::class, 'update']);
        Route::get('/{uuid}/{slug?}', [ProductController::class, 'show']);
    });
});
