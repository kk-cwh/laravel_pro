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

Route::group(['prefix' => 'home', 'namespace' => 'Admin'], function () {
    Route::get('/', 'HomeController@index');
    Route::get('/page1', 'HomeController@page1');
    Route::get('/page2', 'HomeController@page2');
    Route::get('/page3', 'HomeController@page3');

    Route::get('/role', 'RoleController@lists');
    Route::post('/role', 'RoleController@save');
    Route::put('/role', 'RoleController@modify');
    Route::put('/role/access', 'RoleController@modify');

    Route::get('/user', 'UserController@lists');
    Route::post('/user', 'UserController@save');
    Route::put('/user', 'UserController@modify');
    Route::put('/user/role', 'UserController@setUserRole');

    Route::get('/access', 'AccessController@lists');
    Route::post('/access', 'AccessController@save');
    Route::put('/access', 'AccessController@modify');
    Route::put('/access/role', 'AccessController@delAccess');


    Route::get('/login', 'UserController@login');
});
