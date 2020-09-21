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

Route::get('/','AnimalController@index');

Route::put('mobileapp/progress/update','ProgressController@update');

Route::resources([
  'mobileapp/animals' => 'AnimalController',
  'mobileapp/images' => 'ImageController',
  'mobileapp/progress' => 'progressController'
]);

Route::get('mobileapp/images/create/{id}', 'ImageController@create');
Route::get('mobileapp/images/edit/{id}/{animalID}', 'ImageController@edit');
Route::get('mobileapp/images/update', 'ImageController@edit');
Route::get('mobileapp/csv', 'CsvController@index');
Route::post('mobileapp/csv/add', 'CsvController@Upload');

Route::put('mobileapp/animalscsv/edit', 'AnimalController@csvUpload');
Route::get('mobileapp/sponsors','SponsorController@index');
Route::get('mobileapp/sponsors/create','SponsorController@create');
Route::put('mobileapp/sponsors/store','SponsorController@store');
Route::get('mobileapp/sponsors/{id}','SponsorController@edit');
Route::get('mobileapp/sponsors/{id}/delete','SponsorController@destroy');
Route::put('mobileapp/sponsors/update','SponsorController@update');



Route::get('mobileapp/api/data/{id}', 'APIController@index');
Route::get('mobileapp/api/progress/{id}','APIController@progress');
Route::get('mobileapp/api/images/{id}','APIController@gallery');
