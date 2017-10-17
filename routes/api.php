<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::resource('fileup', 'FileupController');
// Route::post('fileup', 'FileupController@index');
//Route::group(['middleware' => 'ajaxOnly'], function () {
	// WOW
	//Route::post('wow', 'WowController@index');

	// Route::get('/wow/login', 'WowController@login');// ログインページ
	Route::post('/wow/signin', 'WowController@signIn');// ログイン
	//Route::get('/wow/register', 'WowController@register');// ユーザー登録ページ
	Route::post('/wow/signup', 'WowController@signUp');// ユーザー登録
	Route::get('/wow/getcurrentuser',  'WowController@getCurrentUser');

	Route::group(['middleware' => 'jwt.auth'], function(){// ログインチェックMiddleware
		// Route::get('/wow', 'WowController@index');// トップ
		// Route::get('/wow/dashboard', 'WowController@dashboard');// トップ
		Route::get('/wow/signout',  'AuthenticateController@signOut')->middleware('jwt.refresh');

		//記事一覧
		Route::post('/wow/postList/', 'WowController@postList');
	});
//});