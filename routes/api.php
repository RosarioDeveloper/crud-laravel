<?php

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

Route::prefix('users')->group(function () {
  Route::get('', 'UserController@index');
  Route::get('/{id}', 'UserController@show');
  Route::post('register', 'UserController@register');
  Route::put('update', 'UserController@update');
  Route::delete('/{id}', 'UserController@delete');
});
