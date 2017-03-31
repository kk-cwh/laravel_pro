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


    /*角色相关路由*/
    // 新增页面视图
    Route::get('/role/create', 'RoleController@create');
    // 新增
    Route::post('/role', 'RoleController@store');
    // 查询列表
    Route::get('/role', 'RoleController@index');
    // 查看详情
    Route::get('/role/{id}', 'RoleController@show');
    // 修改页面视图
    Route::get('/role/{id}/edit', 'RoleController@edit');
    // 修改信息
    Route::put('/role/{id}', 'RoleController@update');
    // 删除信息
    Route::delete('/role/{id}', 'RoleController@destroy');


    /*用户相关路由*/
    // 新增页面视图
    Route::get('/user/create', 'UserController@create');
    // 新增
    Route::post('/user', 'UserController@store');
    // 查询列表
    Route::get('/user', 'UserController@index');
    // 查看详情
    Route::get('/user/{id}', 'UserController@show');
    // 修改页面视图
    Route::get('/user/{id}/edit', 'UserController@edit');
    // 修改信息
    Route::put('/user/{id}', 'UserController@update');
    // 删除信息
    Route::delete('/user/{id}', 'UserController@destroy');


    /*权限相关路路由*/
    Route::get('/access/create', 'AccesController@create');
    // 新增
    Route::post('/access', 'AccesController@store');
    // 查询列表
    Route::get('/access', 'AccesController@index');
    // 查看详情
    Route::get('/access/{id}', 'AccesController@show');
    // 修改页面视图
    Route::get('/access/{id}/edit', 'AccesController@edit');
    // 修改信息
    Route::put('/access/{id}', 'AccesController@update');
    // 删除信息
    Route::delete('/access/{id}', 'AccesController@destroy');

    /*商品分类相关路路由*/
    Route::get('/cate/create', 'CateController@create');
    // 新增
    Route::post('/cate', 'CateController@store');
    // 查询列表
    Route::get('/cate', 'CateController@index');
    // 查看详情
    Route::get('/cate/{id}', 'CateController@show');
    // 修改页面视图
    Route::get('/cate/{id}/edit', 'CateController@edit');
    // 修改信息
    Route::put('/cate/{id}', 'CateController@update');
    // 删除信息
    Route::delete('/cate/{id}', 'CateController@destroy');

    /*商品相关路路由*/
    Route::get('/product/create', 'ProductController@create');
    // 新增
    Route::post('/product', 'ProductController@store');
    // 查询列表
    Route::get('/product', 'ProductController@index');
    // 查看详情
    Route::get('/product/{id}', 'ProductController@show');
    // 修改页面视图
    Route::get('/product/{id}/edit', 'ProductController@edit');
    // 修改信息
    Route::put('/product/{id}', 'ProductController@update');
    // 删除信息
    Route::delete('/product/{id}', 'ProductController@destroy');


    Route::get('/login', 'UserController@loginView');
    Route::post('/user/login', 'UserController@login');
});
