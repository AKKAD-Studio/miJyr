<?php

 
define('reCAPTCHA', '6LeqBRcUAAAAADYKB6BNDQWKdDCxMwQHGOrDe399'); //Секретный ключ reCAPTCHA

// VK 
define('VK_CLIENT_ID',      '5924607'); 
define('VK_CLIENT_SECRET',  'ccW7sYKI1juh3h0g6kaJ'); 
define('VK_REDIRECT_URI',   'http://'.$_SERVER['HTTP_HOST'].'/auth/vkontakte');
 
// FB 
define('FB_CLIENT_ID',      '1789656138023406'); 
define('FB_CLIENT_SECRET',  '8602c8f951f178cf4105c0a5a90b86fc'); 
define('FB_REDIRECT_URI',   'http://'.$_SERVER['HTTP_HOST'].'/auth/facebook');

 


/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| our application. We just need to utilize it! We'll simply require it
| into the script here so that we don't have to worry about manual
| loading any of our classes later on. It feels nice to relax.
|
*/

require __DIR__.'/../bootstrap/autoload.php';

/*
|--------------------------------------------------------------------------
| Turn On The Lights
|--------------------------------------------------------------------------
|
| We need to illuminate PHP development, so let us turn on the lights.
| This bootstraps the framework and gets it ready for use, then it
| will load up this application so that we can run it and send
| the responses back to the browser and delight our users.
|
*/

$app = require_once __DIR__.'/../bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request
| through the kernel, and send the associated response back to
| the client's browser allowing them to enjoy the creative
| and wonderful application we have prepared for them.
|
*/

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);
