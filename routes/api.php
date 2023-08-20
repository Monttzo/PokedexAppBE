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

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    /**
     * User routes
     */
    Route::post('login', 'App\Http\Controllers\AuthController@login')->name('login');
    Route::post('logout', 'App\Http\Controllers\AuthController@logout');
    Route::post('refresh', 'App\Http\Controllers\AuthController@refresh');
    Route::post('me', 'App\Http\Controllers\AuthController@me');
    Route::post('register', 'App\Http\Controllers\AuthController@register');
    Route::put('update', 'App\Http\Controllers\AuthController@update');
    /**
     * Post routes
     */
    Route::get('/favorite','App\Http\Controllers\FavoriteController@index');
    Route::post('/favorite/create','App\Http\Controllers\FavoriteController@store');
    Route::put('/favorite/update/{id}','App\Http\Controllers\FavoriteController@update');
    Route::delete('/favorite/delete/{id}','App\Http\Controllers\FavoriteController@destroy');
    Route::get('/favorite/myFavs', 'App\Http\Controllers\FavoriteController@myFavs');
});
