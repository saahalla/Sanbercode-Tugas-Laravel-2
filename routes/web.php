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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('route-1', function(){
    return 'masuk ke Route 1 Email Verified';
})->middleware(['auth', 'email_verified']);

Route::get('route-2', function(){
    return 'masuk ke Route 2 Admin';
})->middleware(['auth', 'email_verified', 'admin']);
