<?php
/** @var Router $router */
use Illuminate\Routing\Router;


$router->group([],
    function (Router $router) {

        $router->get('auth/login',['uses' => 'Auth\AuthLoginController@getLogin']);
        $router->post('auth/login',['uses' => 'Auth\AuthLoginController@postLogin']);

        $router->group(['middleware' => 'auth'],
            function (Router $router) {
                $router->get('/', ['uses' => 'DashboardController@index']);
            }
        );
    }
);