<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::GET('/v1/user/create','UserController@create');
Route::POST('/v1/user/create','UserController@create');
Route::GET('/v1/user/delete','UserController@delete');
Route::POST('/v1/user/delete','UserController@delete');
Route::GET('/v1/user/pwd/change','UserController@change');
Route::POST('/v1/user/pwd/change','UserController@change');
Route::GET('/v1/user/login','UserController@login');
Route::POST('/v1/user/login','UserController@login');