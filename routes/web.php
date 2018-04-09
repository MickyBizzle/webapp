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

Route::get('view_previous', 'ViewPreviousController@index')->name('view_previous');
Route::get('show_experiment/{id}', 'ViewPreviousController@showExperiment')->name('show_experiment');
Route::post('update_title', 'ViewPreviousController@updateTitle')->name('update_title');
Route::get('delete_experiment/{id}', 'ViewPreviousController@delete')->name('delete_experiment');
Route::post('update_checked/{id}', 'ViewPreviousController@updateChecked')->name('update_checked');


Route::post('start_record', 'AddNewController@startRecord');
Route::post('stop_record', 'AddNewController@stopRecord');
Route::post('add_emotion', 'AddNewController@addEmotion');

Route::post('get_data', 'AddNewController@getData');
Route::post('add_data', 'AddDataController@add');

// Auth::routes();
//
// Route::get('/home', 'HomeController@index')->name('home');
//
// Auth::routes();
//
// Route::get('/home', 'HomeController@index')->name('home');
