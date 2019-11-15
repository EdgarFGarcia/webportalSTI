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

Route::group(['middleware' => ['preventbackhistory']], function () {

    Route::group(['middleware' => ['checkislogin']], function () {
        Route::get('/', 'apiController@index');
        Route::get('/login', 'apiController@index')->name('login');
    });
    
    Route::group(['middleware' => ['checkisuser']], function () {
        Route::get('main', 'pageController@index');
        Route::get('verifyhome', 'pageController@verifyhome');
        Route::get('announcement', 'pageController@announcement');
        Route::get('messages', 'pageController@messages');
    });

});

Route::get('register', 'pageController@register');