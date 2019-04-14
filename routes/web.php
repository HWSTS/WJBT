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


$router->group(['prefix' => 'api'], function () use ($router) {
    $router->post('login','UserController@login');
    $router->post('signup','UserController@signup');
    $router->post('verfiy','UserController@verfiy');
    $router->post('order','OrderController@store');
    $router->get('userorders/{uid}','OrderController@userOrder');
    $router->get('locations/{uid}','LocationController@list');
    $router->get('meals/{province}','MealController@list');
    $router->get('search/{category}','MealController@search');
    $router->get('resList/{province}','ResController@resList');
    $router->post('addtofav','FavController@store');
    $router->get('myfav/{uid}','FavController@list');
    
});

$router->group(['prefix' => 'resapi'], function () use ($router) {
    $router->post('login','UserController@login');
    $router->get('orders/{uid}/{status}','OrderController@resOrder');
    $router->get('meals/{uid}','MealController@reslist');
    $router->post('updatemeal','MealController@update');
    $router->post('addmeal','MealController@store');
    $router->post('delmeal','MealController@delete');
    
});
