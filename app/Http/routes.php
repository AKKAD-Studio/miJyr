<?php
 

Route::get('/', function () {return view('enter');});
 


//Роуты для авторизованных пользователей
Route::group(['middleware' => 'auth'], function () { 
 
        //тут роуты только для админа + авторизация
        Route::get('/control', 'Control\ControlController@index');
        // Put all your routes inside here.
		
         Route::post('/control/ajax/',  'Control\ControlController@adminAJAX' );
         Route::post('/control/post/',  'Control\ControlController@adminPOST' );
   

});



// Authentication routes...
Route::get('/auth/login', 'Auth\LoginController@getLogin');
Route::post('/auth/login', 'Auth\AuthController@postLogin');
Route::get('/auth/logout', 'Auth\AuthController@getLogout');

Route::get('/login', 'Auth\AuthController@getLogin');
Route::post('/login', 'Auth\AuthController@postLogin');
Route::get('/logout', 'Auth\AuthController@getLogout');

// Registration routes...
//Route::get('/register', 'Auth\AuthController@getRegister');
//Route::post('/register', 'Auth\AuthController@postRegister');

// Роуты запроса ссылки для сброса пароля
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Роуты сброса пароля
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');
