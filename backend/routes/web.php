<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Http\Controllers\ExampleController;
use Laravel\Lumen\Routing\Router;
use App\Http\Middleware\JwtVerify;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});
$router->post('/api/getUser', ['middleware' => 'jwt','uses' => 'ExampleController@getUser']);
$router->post('/api/KullaniciEkle', 'ExampleController@KullaniciEkle');
$router->post('/api/KullaniciSil', 'ExampleController@KullaniciSil');
$router->post('/api/KullaniciDuzenle', 'ExampleController@KullaniciDuzenle');
$router->post('/api/Login', 'ExampleController@Login');
