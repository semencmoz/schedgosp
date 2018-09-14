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

Route::resource('/roles','rolesController');
Route::resource('/depts','deptsController');
Route::resource('/listings','listingsController');
Route::resource('/quotas','quotasController');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
