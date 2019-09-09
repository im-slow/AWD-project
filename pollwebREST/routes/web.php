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

//Routes for resource user
$router->post('login', 'UsersController@login');
$router->post('signin', 'UsersController@signin');
//$router->post('testAdmin', 'UsersController@testAdmin');
//$router->post('test', 'UserController@test');

//API senza Auth
$router->group(['prefix' => 'api/v1'], function() use ($router) {

  //Routes for resource poll
  $router->get('poll', 'PollsController@all');
  $router->get('poll/{id}', 'PollsController@get');

  //Routes for resource question
  $router->get('poll/{idpoll}/question', 'QuestionsController@all');
  $router->get('poll/{idpoll}/question/{id}', 'QuestionsController@get');


});

//API con Auth
$router->group(['prefix' => 'api/v1', 'middleware' => 'auth'], function () use ($router) {

    //Routes for resource user
    $router->get('logout', 'UsersController@LogOut');
    $router->put('updateRole', 'UsersController@updateRole');
    $router->delete('remove/{id}', 'UsersController@remove');

    //Routes for resource poll
    $router->post('poll', 'PollsController@add');
    $router->put('poll/{id}', 'PollsController@put');
    $router->delete('poll/{id}', 'PollsController@remove');

    //Routes for resource question
    $router->post('poll/{idpoll}/question', 'QuestionsController@add');
    $router->put('poll/{idpoll}/question/{id}', 'QuestionsController@put');
    $router->delete('poll/{idpoll}/question/{id}', 'QuestionsController@remove');

    //Routes for resource answer
    $router->get('poll/{idpoll}/question/{idquestion}/answer', 'AnswersController@get');

    //Routes for resource instance
    $router->get('poll/{idpoll}/instance', 'InstancesController@get');
    $router->post('poll/{idpoll}/instance', 'InstancesController@add');

});
