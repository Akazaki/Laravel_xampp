<?php

// Route::get('/', function () {
//     return view('welcome');
// });

// お問い合わせフォーム
Route::get('/contact', 'ContactController@form');
Route::post('/contact/confirm', 'ContactController@confirm');
Route::post('/contact/complete', 'ContactController@complete');

// WOW
Route::get('/wow/login', 'WowController@login');// ログインページ
Route::post('/wow/signin', 'WowController@signin');// ログイン
Route::get('/wow/register', 'WowController@register');// ユーザー登録ページ
Route::post('/wow/signup', 'WowController@signup');// ユーザー登録

Route::group(['middleware' => 'wowauth'], function(){// ログインチェックMiddleware
	Route::get('/wow', 'WowController@index');// トップ
	Route::get('/wow/dashboard', 'WowController@dashboard');// トップ
	Route::get('/wow/signout', 'WowController@signout');// ログアウト
});

// Auth::routes();
