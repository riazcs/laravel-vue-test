<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
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

Route::namespace('App\Http\Controllers')->group(function () {
    Route::post('login', 'LoginController@login');
    Route::get('logout/{id}', 'LoginController@logout');
    Route::resource('products', ProductController::class)->except('destroy');
    Route::post('products/delete', 'ProductController@destroy');
});
