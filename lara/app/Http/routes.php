<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', ['as' => 'posts', 'uses' => 'PostController@index']);

Route::get('blog/{slug}', 'BlogController@showPost');  

Route::resource('posts', 'PostController');
Route::resource('blog', 'BlogController');


Route::post('admin/blog/{id}/edit', 'admin\BlogController@edit');
Route::post('admin/blog/{id}/update', 'admin\BlogController@update');


Route::group(['prefix'=>'admin'],function(){
    Route::any('/','admin\DashboardController@index');
    Route::resource('home', 'admin\DashboardController');
    Route::resource('blog','admin\BlogController');
});




