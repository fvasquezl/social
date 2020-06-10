<?php

use Illuminate\Support\Facades\Route;

Route::get('statuses','StatusesController@index')->name('statuses.index');

Route::post('statuses','StatusesController@store')
    ->name('statuses.store')
    ->middleware('auth');

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
Route::view('/','welcome');
