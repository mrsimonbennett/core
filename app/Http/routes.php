<?php
/** @var Router $router */
use Illuminate\Routing\Router;


$router->group(['middleware' => 'company'],
    function (Router $router) {


        $router->group(['middleware' => 'guest'],
            function (Router $router) {
                $router->get('auth/login', ['uses' => 'Auth\AuthLoginController@getLogin']);
                $router->post('auth/login', ['uses' => 'Auth\AuthLoginController@postLogin']);
            });
        $router->group(['middleware' => 'auth'],
            function (Router $router) {
                $router->get('/', ['uses' => 'DashboardController@index']);


                /**
                 * Properties
                 */
                $router->get('/properties', ['uses' => 'Properties\PropertiesController@index']);
                $router->get('/properties/{propertyId}', ['uses' => 'Properties\PropertiesController@show']);
                $router->put('/properties/{propertyId}', ['uses' => 'Properties\PropertiesController@update']);
                $router->get('/properties/{propertyId}/edit', ['uses' => 'Properties\PropertiesController@edit']);

                /**
                 * Tenancies
                 */
                $router->get('/tenancies/{tenancyId}',['uses' => 'Tenancies\TenanciesController@show']);



            }
        );
    }
);