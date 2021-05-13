<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
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

Route::resource('products', ProductController::class)->only("index", "show");
Route::post('orders/get', [OrderController::class, "findByEmail"]);
Route::resource('orders', OrderController::class)->only("store");
// Route::resource('users', UserController::class);

Route::post('login', [UserController::class, "authenticate"]);

Route::group(['middleware' => ['jwt.auth'], 'prefix' => 'admin'], function () {
    Route::post('products/image', [ProductController::class, "image"]);
    Route::get('logout', [UserController::class, "logout"]);
    Route::resource('users', UserController::class);
    Route::resource('products', ProductController::class);
    Route::resource('orders', OrderController::class);
});
