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

//ログイン前：最初のページ
//TasksControllerでreturnまでの処理を書いている
//「TasksControllerのindex内の処理を行う」ということ
Route::get('/', 'TasksController@index');

//ログイン前：新規登録ページ
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup.get');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

//ログイン前：ログイン認証ページ
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout.get');


// 意味は？
// Route::group(['middleware' => ['auth']], function () {
//     Route::resource('users', 'UsersController', ['only' => ['index', 'show']]);
//     Route::resource('microposts', 'MicropostsController', ['only' => ['store', 'destroy']]);
// });


//ログイン後：タスク関連機能
Route::resource('tasks', 'TasksController');
