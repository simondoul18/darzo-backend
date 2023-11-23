<?php

use App\Http\Controllers\CountriesController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\ProductCategoriesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\TemporaryFileUploadController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['middleware' => 'auth:api'], function () {
    Route::put('update_password', [UserController::class, 'updatePassword']);
    Route::resource('/user', UserController::class);

    Route::get('tags/paginated', [TagsController::class, 'paginated']);
    Route::apiResource('tags', TagsController::class);

    Route::group(['prefix' => 'units'], function () {
        Route::apiResource('', UnitController::class);
    });

    Route::group(['prefix' => 'currencies'], function () {
        Route::apiResource('', CurrencyController::class);
    });

    Route::group(['prefix' => 'temp-media'], function () {
        Route::post('', [TemporaryFileUploadController::class, 'store']);
    });

    Route::group(['prefix' => 'countries'], function () {
        Route::resource('', CountriesController::class);
    });
});

Route::group(['prefix' => 'categories'], function () {
    Route::apiResource('', ProductCategoriesController::class);
});

Route::group(['prefix' => 'products'], function () {
    Route::get('', [ProductController::class, 'index']);
    Route::get('/{uuid}/{slug?}', [ProductController::class, 'show']);
});
