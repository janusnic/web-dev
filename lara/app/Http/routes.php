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
/*
Route::get('/', function () {
    return view('welcome',['records'=>0]);
});
*/
Route::get('/', ['as' => 'posts', 'uses' => 'PostController@index']);

Route::get('/hey', 'GreetingController@index');

Route::resource('posts', 'PostController');

Route::get('blog', 'BlogController@index');            // При запросе к http://lara.com/blog будет вызван метод index()
                                                        // Класса BlogController

Route::get('blog/{slug}', 'BlogController@showPost');  // При запросе к http://lara.com/blog/что-нибудь будет вызва метод showPost()
                                                        // Класса BlogController

Route::get('/hay', function () {
    return view('greeting', ['name' => 'Janus']);
});

Route::get('/hell', function () {
    $data = ['name' => 'Janus Nic!'];
    return view('hello.greeting', $data);
});

Route::get('/hell1', function () {
    // Используя стандартный подход
    $view = view('greeting')->with('name', 'Еще раз Janus Nic!');
    return $view;
});

Route::get('/hell2', function () {
    // Используя "магические" методы
    $view = view('greeting')->withName('И еще раз Janus Nic!');

    return $view;
});


