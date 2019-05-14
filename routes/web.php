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
    return redirect()->route('login');;
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/comments', 'CommentController@index');
Route::post('/comments', 'CommentController@create');

Route::get('/profile/edit', 'ProfileController@index');
Route::post('/profile/edit', 'ProfileController@update')->name('image.upload.post');

Route::get('/profile/id={id}', 'ProfileController@show');
Route::get('/profile', 'ProfileController@show');

Route::get('/get_regions', 'ResidenceController@getRegions');
Route::get('/get_city', 'ResidenceController@getCitys');
Route::get('/get_countrys', 'ResidenceController@getCountrys');

Auth::routes(['verify' => true]);