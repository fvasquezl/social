<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

//Statuses routes
Route::get('statuses', 'StatusesController@index')->name('statuses.index');
Route::post('statuses', 'StatusesController@store')
    ->name('statuses.store')
    ->middleware('auth');

//Statuses likes routes
Route::post('statuses/{status}/likes', 'StatusLikesController@store')
    ->name('statuses.likes.store')
    ->middleware('auth');

Route::delete('statuses/{status}/likes', 'StatusLikesController@destroy')
    ->name('statuses.likes.destroy')
    ->middleware('auth');

//Status Comment routes
Route::post('statuses/{status}/comments','StatusCommentsController@store')
    ->name('statuses.comments.store')
    ->middleware('auth');

//Comments likes routes
Route::post('comments/{comment}/likes','CommentLikeController@store')
    ->name('comments.likes.store')
    ->middleware('auth');

Route::delete('comments/{comment}/likes','CommentLikeController@destroy')
    ->name('comments.likes.destroy')
    ->middleware('auth');

//User routes
Route::get('@{user}','UsersController@show')
    ->name('users.show');

Auth::routes();


