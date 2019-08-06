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


Route::post('/create/user','UserController@create');
Route::post('/create/category','CategoryController@create');
Route::get('/read/category','CategoryController@read');
Route::get('/readall/user','UserController@readAll');
Route::get('/readbyid/user','UserController@readById');
Route::post('/update/user','UserController@update');
Route::post('/delete/user','UserController@delete');
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
