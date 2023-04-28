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

// 初期画面（HOME画面）
Route::get('/', 'PostController@index');

// ログイン・サインアップ関連
Auth::routes();

// 投稿関連
Route::resource('posts', 'PostController')->only([
    'index','store','edit','update','destroy'
]);
// 投稿のスポット数を入力する画面
Route::get('/posts/create/send_number_of_spots', 'PostController@create_send_number_of_spots')->name('posts.create_send_number_of_spots');
// createメイン画面
Route::get('/posts/create/main', 'PostController@create_main')->name('posts.create_main');
// お気に入りの追加・削除処理
Route::patch('/posts/{post}/toggle_favorite', 'PostController@toggleFavorite')->name('posts.toggle_favorite');
// 検索画面
Route::get('/posts/search_form', 'PostController@search_form')->name('posts.search_form');

// ユーザー関連
Route::resource('users', 'UserController')->only([
    'show'
]);
// 登録完了画面
Route::get('completion', 'UserController@completion')->name('users.completion');

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