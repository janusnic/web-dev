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


Route::group(['prefix'=>'admin', 'namespace' => 'Admin', 'middleware' => 'auth'],function(){
    Route::any('/','DashboardController@index');

    Route::resource('index', 'DashboardController');
    Route::resource('categories','CategoriesController');
    Route::resource('articles','ArticlesController');
    Route::resource('tags','TagsController');
    Route::resource('users','UsersController');
});

Route::get('login', 'Admin\AuthController@getLogin');
Route::post('login', 'Admin\AuthController@postLogin');
Route::get('logout', 'Admin\AuthController@logout');

Route::group(['namespace' => 'Home'], function () {

    Route::resource('/', 'HomeController@index');

    Route::get('tags', 'TagsController@index');
    Route::get('tags/{slug}', 'TagsController@show');

    Route::get('categories', 'CategoriesController@index');
    Route::get('categories/{slug}', 'CategoriesController@show');

    Route::get('articles', 'ArticlesController@index');
    Route::get('{slug}', 'ArticlesController@show');
});

