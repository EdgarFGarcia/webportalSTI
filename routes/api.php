<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// login
Route::post('loginAttempt', 'apiController@login');
Route::get('logout', 'apiController@logout');

// register account
Route::post('registerAccount', 'apiController@registerAccount');
// verify account
Route::post('verifyUser', 'apiController@verifyUser');

// get head count
Route::get("getHeadCount", "apiController@getHeadCount");
Route::get("registeredCountGet", "apiController@registeredCountGet");
Route::get("getHeadCountNonVerified", "apiController@getHeadCountNonVerified");

// announcement count
Route::get("pendingRequestCount", "apiController@pendingRequestCount");
Route::get("postedRequestCount", "apiController@postedRequestCount");
Route::post("sendNotification", "apiController@sendNotification");

// get pending requets
Route::get("getPendingRequests", "apiController@getPendingRequests");

// send announcement
Route::post("sendAnnouncement", "apiController@sendAnnouncement");
Route::post("requestNotification", "apiController@requestNotification");

// verify user
Route::get("registerdUserNotVerified", "apiController@registerdUserNotVerified");
Route::post("validateUser", "apiController@validateUser");
Route::get("editUser", "apiController@editUser");
Route::post("saveEditedUser", "apiController@saveEditedUser");

// student notification
Route::get("tableStudents", "apiController@tableStudents");