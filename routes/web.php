<?php


Route::get('/',     'Pub\PublicController@index');
Route::get('/home', 'Pub\PublicController@home');

Route::get('/logout', function () {Auth::logout(); return redirect('/'); });

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    //тут роуты только для админа + авторизация
    Route::get('/control',     'Control\ControlController@index');
    Route::get('/user',        'User\UserController@index');
    Route::get('/admin_panel', 'Admin\AdminController@index');
});
