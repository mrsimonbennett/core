<?php
/** @var Router $router */
use Illuminate\Routing\Router;

$router->group([],
    function ($router) {

        /**
         * Companies
         */
        $router->group(['prefix' => 'companies'],
            function () use ($router) {
                $router->post('', 'CompanyController@createCompany');
                $router->get('exists/{domain}', 'CompanyController@checkExists');
                $router->get('{domain}', 'CompanyController@show');

                $router->get('{id}/direct-debit/authorization_url', 'CompanyDirectDebit@authorizationUrl');
                $router->post('{id}/direct-debit/access_token', 'CompanyDirectDebit@accessToken');
                $router->post('invite', 'CompanyController@invite');

                $router->put('{id}/name', 'CompanyController@putName');
                $router->put('{id}/domain', 'CompanyController@putDomain');

            }
        );

        /**
         * Companies
         */
        $router->group(['prefix' => 'companies'],
            function () use ($router) {
                $router->post('', 'CompanyController@createCompany');
                $router->get('exists/{domain}', 'CompanyController@checkExists');
                $router->get('{domain}', 'CompanyController@show');

                $router->get('{id}/direct-debit/authorization_url', 'CompanyDirectDebit@authorizationUrl');
                $router->post('{id}/direct-debit/access_token', 'CompanyDirectDebit@accessToken');
                $router->post('invite', 'CompanyController@invite');

                $router->post('{id}/subscription', 'CompanyController@subscription');


            }
        );
        /*
         * Properties
         */
        $router->group(['prefix' => 'properties'],
            function () use ($router) {
                $router->get('{id}/history', 'PropertiesController@getHistory');
                $router->post('', 'PropertiesController@listNewProperty');
                $router->get('', 'PropertiesController@index');
                $router->get('{id}', 'PropertiesController@show');
                $router->put('{id}', 'PropertiesController@update');

                $router->post('{id}/photos', 'PropertiesController@attachImage');

                /**
                 * Contracts
                 */
                $router->get('{id}/contracts', 'ContractsController@index');

            }
        );


        $router->get('/tenants/{id}/contracts', 'Tenant\ContractsController@getTenantsContracts');

        /**
         * Users
         */
        $router->get('users/me', 'UserController@me');

        $router->resource('users', 'UserController');
        $router->post('users/{id}/remember-token', 'UserController@rememberMe');
        $router->put('users/{id}/basic', 'UserController@basicDetails');
        $router->put('users/{id}/email', 'UserController@updateEmail');
        $router->put('users/{id}/password', 'UserController@updatePassword');

        /*
         * Auth
         */
        $router->group(['prefix' => 'auth'],
            function () use ($router) {
                $router->post('login', ['uses' => 'Auth\AuthController@postLogin']);
                $router->put('token', ['uses' => 'Auth\AuthController@putToken']);
                $router->post('password/email', ['uses' => 'Auth\PasswordController@email']);
                $router->post('password/reset/{token}', ['uses' => 'Auth\PasswordController@reset']);

                $router->post('invited/{token}', ['uses' => 'Auth\AuthController@invited']);

            }
        );

        /*
        * Auth
        */
        $router->group(['prefix' => 'tenancies'],
            function () use ($router) {
                $router->post('draft', ['uses' => 'TenanciesController@draft']);
                $router->get('{propertyId}/drafts', ['uses' => 'TenanciesController@getPropertiesDraftTenancies']);

                $router->get('{tenancyId}',['uses' => 'TenanciesController@getTenancyById']);

            }
        );

    });

$router->any('/gocardless/webhook', 'GoCardless\GoCardlessWebHooksController@hook');
