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

Route::get('/', 'PostsController@index')->name('index');
Route::get('/bbs', 'PostsController@index')->name('index');

// Route::get('/bbs/list?page={page}', 'PostsController@index');

Route::get('/bbs/create', 'PostsController@create')->name('create');
Route::post('/bbs/store', 'PostsController@store')->name('store');

Route::get('/bbs/edit/{post}', 'PostsController@edit')->name('edit');
Route::put('/bbs/update/{post}', 'PostsController@update')->name('update');

Route::get('/bbs/{post}', 'PostsController@show')->name('show');

Route::delete('/bbs/delete/{post}', 'PostsController@destroy')->name('delete');

Route::get('/category/{id}', 'PostsController@showCategory')->name('category');

Route::post('/comment/store/{post}', 'CommentsController@store')->name('c_store');
Route::delete('/comment/delete/{comment}', 'CommentsController@destroy')->name('c_delete');
