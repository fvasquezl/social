<?php

use Illuminate\Support\Facades\Route;

Route::view('/','welcome');

//Statuses routes
Route::get('statuses','StatusesController@index')->name('statuses.index');
Route::post('statuses','StatusesController@store')
    ->name('statuses.store')
    ->middleware('auth');

//Statuses likes
Route::post('statuses{status}/likes','StatusLikesController@store')->name('statuses.likes.store');

Auth::routes();


