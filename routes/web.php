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

Route::get('doctor/index', 'DoctorController@index')->name('index');
Route::get('doctor', 'DoctorController@index')->name('index');

Route::post('doctor/add', 'DoctorController@add')->name('add');

Route::post('doctor/edit/{id}', 'DoctorController@edit')->name('edit');

Route::delete('doctor/delete/{id}', 'DoctorController@delete')->name('delete');
