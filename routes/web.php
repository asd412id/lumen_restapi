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

$router->get('/', function() use ($router) {
    return $router->app->version();
});

$router->group(['prefix'=>'api'],function() use($router){
  $router->group(['middleware'=>'token'],function() use($router){
    $router->get('user','UserController@all');
    $router->post('user','UserController@add');
    $router->get('user/{id}','UserController@show');
    $router->get('user/{id}/post','UserController@post');
    $router->put('user/{id}','UserController@update');
    $router->delete('user/{id}','UserController@delete');

    $router->group(['prefix'=>'post'],function() use($router){
      $router->get('/','PostController@all');
      $router->post('/','PostController@add');
      $router->get('{id}','PostController@show');
      $router->put('{id}','PostController@update');
      $router->delete('{id}','PostController@delete');
    });
  });
  $router->post('user/login','UserController@login');
});
