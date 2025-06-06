<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('products')->group(function () {
    Route::get('/', 'App\Http\Controllers\ProductController@index')->name('products.index');
    Route::post('/', 'App\Http\Controllers\ProductController@store')->name('products.store');
});
Route::prefix('orders')->group(function () {
    Route::post('/', 'App\Http\Controllers\OrderController@store')->name('orders.store');
});
Route::prefix('analytics')->group(function () {
    Route::get('/', 'App\Http\Controllers\AnalyticsController@index')->name('analytics.index');
});
