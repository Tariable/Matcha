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
Route::get('/photos/create', 'PhotoController@create')->middleware('verified');
Route::post('/photos', 'PhotoController@store');
Route::get('/photos/{user}', 'PhotoController@show');
Route::delete('/photos/{photo}', 'PhotoController@destroy');
Route::get('/lastPhoto/{user}', 'PhotoController@showTheLastOne');

Route::get('/profiles/create', 'ProfileController@create')->middleware('verified')->middleware('firstTime');
Route::post('/profiles', 'ProfileController@store');
Route::get('/profiles/{id}/edit', 'ProfileController@edit');
Route::put('/profiles/{id}', 'ProfileController@update');
Route::delete('/profiles/{id}', 'ProfileController@destroy');

Route::get('/preferences/create', 'PreferenceController@create')->middleware('verified')->middleware('firstTime');
Route::post('/preferences', 'PreferenceController@store');


Route::get('/like/{id}', 'LikeController@like');
Route::get('/ban/{id}', 'BanController@ban');

Route::get('/recs', 'RecommendationController@getData')->middleware('verified');
Route::get('/recss', 'RecommendationController@getRecs')->middleware('verified');

