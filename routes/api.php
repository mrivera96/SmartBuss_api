<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route as Route;
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


Route::post('/create','UserController@create');
Route::get('/read','UserController@read');
Route::post('/update','UserController@update');
Route::post('/delete','UserController@delete');
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
