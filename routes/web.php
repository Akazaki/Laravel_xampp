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

// Route::get('/helo', function () {
//     return view('helo',['message' => 'Hello!']);
// });
//Route::controller('hello', 'HelloController');
Route::resource('hello', 'HelloController');

Route::get('/contact', 'ContactController@form');
Route::post('/contact/confirm', 'ContactController@confirm');
Route::post('/contact/process', 'ContactController@process');