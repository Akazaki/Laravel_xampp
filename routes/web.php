<?php

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/helo', function () {
//     return view('helo',['message' => 'Hello!']);
// });
//Route::controller('hello', 'HelloController');
// Route::resource('hello', 'HelloController');

Route::get('/contact', 'ContactController@form');
Route::post('/contact/confirm', 'ContactController@confirm');
Route::post('/contact/complete', 'ContactController@complete');

//Route::resource('/wow', 'WowController');

/* ログイン画面の表示 */
// Route::get('wow/login', 'Auth/AuthController@getLogin');
// /* ログイン処理 */
// Route::post('wow/login', 'Auth/AuthController@postLogin');
// /* ログアウト */
// Route::get('wow/logout', 'Auth/AuthController@getLogout');
// /* ユーザー登録画面の表示 */
// Route::get('wow/register', 'Auth/AuthController@getRegister');
// /* ユーザー登録処理 */
// Route::post('wow/register', 'Auth/AuthController@postRegister');

// Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
