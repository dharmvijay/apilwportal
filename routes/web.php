<?php

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


$router->get('api/users', 'IThemeController@syncUser');
$router->get('api/test', 'TestController@index');


$router->get('api/vehicle-type', 'VehicletypeController@index');
$router->post('api/vehicle-type', 'VehicletypeController@store');
$router->get('api/vehicle-type/{id}', 'VehicletypeController@show');
$router->put('api/vehicle-type/{id}', 'VehicletypeController@update');
$router->delete('api/vehicle-type/{id}', 'VehicletypeController@destroy');

$router->get('api/vehicle', 'VehicleController@index');
$router->get('api/vehicle/type', 'VehicleController@create');
$router->get('api/vehicle/{id}/edit', 'VehicleController@edit');
$router->post('api/vehicle', 'VehicleController@store');
$router->get('api/vehicle/{id}', 'VehicleController@show');
$router->put('api/vehicle/{id}', 'VehicleController@update');
$router->delete('api/vehicle/{id}', 'VehicleController@destroy');

