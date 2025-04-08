<?php

use Illuminate\Support\Facades\Route;

/*Route::get('/', function () {
    return view('welcome');
});*/
Route::get('/admin', 'App\Http\Controllers\AdminController@index')->name('admin.index');

Route::resource('/brend', 'App\Http\Controllers\BrendController');
Route::resource('/mechanism', 'App\Http\Controllers\MechanismController');
Route::resource('/style', 'App\Http\Controllers\StyleController');
Route::resource('/watch', 'App\Http\Controllers\WatchController');
Route::resource('/photo', 'App\Http\Controllers\PhotoController');

Route::get('photo/create/{id}', 'App\Http\Controllers\PhotoController@showCreatePhoto')->name('photo.showCreate');
Route::get('photo/all/{id}', 'App\Http\Controllers\PhotoController@showAllPhoto')->name('photo.showAll');
Route::post('photo/{idWatch}', 'App\Http\Controllers\PhotoController@addPhotoDb')->name('photo.addDb');
Route::delete('photo/deleteAll/{id}', 'App\Http\Controllers\PhotoController@destroyAll')->name('photo.destroyAll');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
