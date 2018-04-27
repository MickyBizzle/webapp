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

Route::get('ml_test', 'MlController@index')->name('ml_test');
Route::get('ml_train', 'MlController@train')->name('ml_train');
Route::get('batch_test', 'MlController@batch_test')->name('batch_test');
Route::POST('ml_predict', 'MlController@predict')->name('ml_predict');

Route::get('/', 'HomeController@index')->name('home');

Route::get('add_new', 'AddNewController@show')->name('add_new');

Route::get('view_previous', 'ViewPreviousController@index')->name('view_previous');
Route::post('view_previous/update_checked', 'ViewPreviousController@updateChecked')->name('update_checked');
Route::post('view_previous/update_title', 'ViewPreviousController@updateTitle')->name('update_title');
Route::post('view_previous/update_option', 'ViewPreviousController@updateOption')->name('update_option');
Route::post('view_previous/update_media', 'ViewPreviousController@updateMedia')->name('update_media');

Route::get('show_experiment/{id}', 'ViewPreviousController@showExperiment')->name('show_experiment');
Route::get('delete_experiment/{id}', 'ViewPreviousController@delete')->name('delete_experiment');


Route::post('start_record', 'AddNewController@startRecord');
Route::post('stop_record', 'AddNewController@stopRecord');
Route::post('add_emotion_and_media', 'AddNewController@addEmotionAndMedia');
Route::post('add_media', 'AddNewController@addMedia');

Route::post('get_data', 'AddNewController@getData');
Route::post('add_data', 'AddDataController@add');

// Auth::routes();
//
// Route::get('/home', 'HomeController@index')->name('home');
//
// Auth::routes();
//
// Route::get('/home', 'HomeController@index')->name('home');
