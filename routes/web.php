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

Route::get('/', 'HomeController@index')->name('home');

Route::get('add_new', 'AddNewController@show')->name('add_new');

Route::get('view_previous', 'ViewPreviousController@show')->name('view_previous');

Route::post('start_record', 'AddNewController@startRecord');
Route::get('stop_record', 'AddNewController@stopRecord');

Route::post('add_data', 'AddDataController@add');
