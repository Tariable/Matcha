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

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->middleware('verified')->name('home');

Route::get('/photos/{user}', 'PhotoController@show')->middleware('verified');
Route::get('/photos/create', 'PhotoController@create')->middleware('verified');
Route::post('/photos', 'PhotoController@store')->middleware('verified');
Route::delete('/photos/{photo}', 'PhotoController@destroy')->middleware('verified');
Route::get('/lastPhoto/{user}', 'PhotoController@showTheLastOne')->middleware('verified');

Route::get('/profiles/create', 'ProfileController@create')->middleware('verified')->middleware('firstTime');
Route::post('/profiles', 'ProfileController@store')->middleware('verified');
Route::get('/profiles/edit', 'ProfileController@edit')->middleware('verified');
Route::post('/profiles/{id}', 'ProfileController@update')->middleware('verified');
Route::delete('/profiles/{id}', 'ProfileController@destroy')->middleware('verified');

Route::get('/preferences/create', 'PreferenceController@create')->middleware('verified')->middleware('firstTime');
Route::post('/preferences', 'PreferenceController@store');
Route::get('/preferences/edit', 'PreferenceController@edit');
Route::post('/preferences/{id}', 'PreferenceController@update');

Route::get('/ban/{id}', 'BanController@ban');
Route::get('/like/{id}', 'LikeController@like');

Route::get('/recs', 'RecommendationController@getData')->middleware('verified');
Route::get('/recss', 'RecommendationController@getRecs')->middleware('verified');

