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

Route::get('/',               'Pub\PublicController@index');
Route::get('/auth/vkontakte', 'Pub\SociosController@vkontakte');
Route::get('/auth/facebook',  'Pub\SociosController@facebook');

Route::get('/logout', function () {Auth::logout(); return redirect('/'); });


Auth::routes(); 


Route::group(['middleware' => 'auth'], function () {
    //тут роуты только для админа + авторизация
    Route::get('/control',     'Control\ControlController@index');
    Route::get('/user',        'User\UserController@index');
    Route::get('/admin_panel', 'Admin\AdminController@index');
});

Route::get('/home', 'Pub\PublicController@home');
