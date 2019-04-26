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
    return 'By Mada Tech Co.';
});


$router->group(['prefix' => 'api'], function () use ($router) {
    $router->post('login','UserController@login');
    $router->post('signup','UserController@signup');
    $router->post('verfiy','UserController@verfiy');
    $router->post('updatelocation','UserController@updateLocation');
    $router->post('order','OrderController@store');
    $router->get('userorders/{uid}','OrderController@userOrder');
    $router->get('locations/{uid}','LocationController@list');
    $router->get('meals/{province}','MealController@list');
    $router->get('search/{category}/{province}','MealController@search');
    $router->get('resList/{province}','ResController@resList');
    $router->post('addtofav','FavController@store');
    $router->get('myfav/{uid}','FavController@list');
    
});

$router->group(['prefix' => 'resapi'], function () use ($router) {
    $router->post('login','ResController@login');
    $router->get('orders/{uid}/{status}','OrderController@resOrder');
    $router->get('penorders/{uid}','OrderController@penOrders');
    $router->get('meals/{uid}','MealController@reslist');
    $router->post('updatemeal','MealController@update');
    $router->post('addmeal','MealController@store');
    $router->post('delmeal','MealController@delete');
    $router->post('updateorder','OrderController@update');
    $router->get('account/{uid}/{fromdate}/{todate}','OrderController@account');
    
});

$router->group(['prefix' => 'admins'], function () use ($router) {
    $router->post('addres','ResController@store');
    $router->post('addresloc','LocationController@store');
    $router->post('search','ResController@search');
    $router->get('account/{uid}/{fromdate}/{todate}','OrderController@account');  
    
});


