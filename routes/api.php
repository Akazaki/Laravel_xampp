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
	//Route::post('wow', 'Wow\WowController@index');

	// Route::get('/wow/login', 'Wow\WowController@login');// ログインページ
	Route::post('/wow/signin', 'Wow\WowController@signIn');// ログイン
	//Route::get('/wow/register', 'Wow\WowController@register');// ユーザー登録ページ
	Route::post('/wow/signup', 'Wow\WowController@signUp');// ユーザー登録
	Route::get('/wow/getcurrentuser',  'Wow\WowController@getCurrentUser');// ユーザー情報取得

	Route::group(['middleware' => 'jwt.auth'], function(){// ログインチェックMiddleware
		// Route::get('/wow', 'Wow\WowController@index');// トップ
		// Route::get('/wow/dashboard', 'Wow\WowController@dashboard');// トップ
		Route::get('/wow/signout',  'AuthenticateController@signOut')->middleware('jwt.refresh');
		//記事一覧
		Route::post('/wow/postList/', 'Wow\PostsController@postList');
		//記事編集
		Route::post('/wow/postEdit/', 'Wow\PostsController@postEdit');
		//記事保存
		Route::post('/wow/postDoneEdit/', 'Wow\PostsController@postDoneEdit');

		Route::post('/wow/fileup/', 'FileupController@index');

		// マスターデータ取得
		Route::post('/wow/getMasterData/', 'Wow\WowController@getMasterData');

		// メニューデータ取得
		Route::post('/wow/getMenuData/', 'Wow\WowController@getMenuData');
	});
//});