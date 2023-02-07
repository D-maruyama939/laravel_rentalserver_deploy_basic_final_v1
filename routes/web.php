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

Auth::routes();

// 投稿関連
Route::resource('posts', 'PostController')->only([
    'index','create','store','edit','update','destroy'
]);

// ユーザー関連
Route::resource('users', 'UserController')->only([
    'show'
]);
// 登録完了画面
Route::get('users/{user}/completion', 'UserController@completion')->name('users.completion');

// フォロー関連
Route::resource('follows', 'FollowController')->only([
    'index','store','destroy'
]);

// プロフィール関連
Route::resource('profile','ProfileController')->only([
    'edit','update',
]);

// お気に入り関連
Route::resource('favorites', 'FavoriteController')->only([
    'index'
]);