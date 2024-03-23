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
// Route::get('/home', 'HomeController@index')->name('home');
Route::get('index', 'PostsController@index');
//Auth::routes();


//ログアウト中のページ
Route::get('/login', 'Auth\LoginController@login');
Route::post('/login', 'Auth\LoginController@login');

Route::get('/register', 'Auth\RegisterController@register');
Route::post('/register', 'Auth\RegisterController@register');

Route::get('/added', 'Auth\RegisterController@added');
Route::post('/added', 'Auth\RegisterController@added');

//ログイン中のページ
Route::group(['middleware' => 'auth'], function() {
Route::get('/top','PostsController@index');
// リクエストを指示
Route::post('/top','PostsController@index');

// Route::post('/create','PostsController@create');


Route::post('/create', 'PostsController@postTweet');    // <--- 追加

Route::get('post/{id}/delete', 'PostsController@delete');

Route::post('/update','PostsController@update');
Route::post('posts', 'PostsController@store');

Route::get('/profile','UsersController@profile');
  Route::get('/other-profile/{id}','UsersController@otherProfile')->name('/other-profile');
  Route::get('/search','UsersController@search');
  Route::get('/searchList','UsersController@searchList');
  Route::post('/updateProfile','UsersController@updateProfile');

Route::get('/followerList','FollowsController@followerList');
Route::get('/followList','FollowsController@followList');



Route::post('/follow','FollowsController@follow');
  //フォロー解除
  Route::post('/unFollow','FollowsController@unFollow');
});

Route::get('/logout', 'Auth\LoginController@logout');
