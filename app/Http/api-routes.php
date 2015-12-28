<?php
$router->group(['prefix' => 'api'],
    function ($router) {

        /**
         * Companies
         */
        $router->group(['prefix' => 'companies'],
            function () use ($router) {
                $router->post('', 'Api\CompanyController@createCompany');
                $router->get('exists/{domain}', 'Api\CompanyController@checkExists');
                $router->get('{domain}', 'Api\CompanyController@show');

                $router->post('{id}/direct-debit/authorization_url', 'Api\CompanyDirectDebit@authorizationUrl');
                $router->post('{id}/direct-debit/access_token', 'Api\CompanyDirectDebit@accessToken');
                $router->post('invite', 'Api\CompanyController@invite');

                $router->put('{id}/name', 'Api\CompanyController@putName');
                $router->put('{id}/domain', 'Api\CompanyController@putDomain');

            }
        );

        /**
         * Companies
         */
        $router->group(['prefix' => 'companies'],
            function () use ($router) {
                $router->post('', 'Api\CompanyController@createCompany');
                $router->get('exists/{domain}', 'Api\CompanyController@checkExists');
                $router->get('{domain}', 'Api\CompanyController@show');

                $router->get('{id}/direct-debit/authorization_url', 'Api\CompanyDirectDebit@authorizationUrl');
                $router->post('{id}/direct-debit/access_token', 'Api\CompanyDirectDebit@accessToken');
                $router->post('invite', 'Api\CompanyController@invite');

                $router->post('{id}/subscription', 'Api\CompanyController@subscription');


            }
        );
        /*
         * Properties
         */
        $router->group(['prefix' => 'properties'],
            function () use ($router) {
                $router->get('{id}/history', 'Api\PropertiesController@getHistory');
                $router->post('', 'Api\PropertiesController@listNewProperty');
                $router->get('', 'Api\PropertiesController@index');
                $router->get('{id}', 'Api\PropertiesController@show');
                $router->put('{id}', 'Api\PropertiesController@update');

                $router->post('{id}/photos', 'Api\PropertiesController@attachPhotos');
                $router->delete('{id}/photo/{imageId}', 'Api\PropertiesController@removeImage');

                /**
                 * Contracts
                 */

            }
        );



        /**
         * Users
         */
        $router->get('users/me', 'Api\UserController@me');

        $router->resource('users', 'Api\UserController');
        $router->post('users/{id}/remember-token', 'Api\UserController@rememberMe');
        $router->put('users/{id}/basic', 'Api\UserController@basicDetails');
        $router->put('users/{id}/email', 'Api\UserController@updateEmail');
        $router->put('users/{id}/password', 'Api\UserController@updatePassword');

        $router->get('users/settings/{userId}', 'Api\User\SettingsController@viewSettings');
        $router->put('users/settings/{userId}', 'Api\User\SettingsController@updateSettings');

        /*
         * Auth
         */
        $router->group(['prefix' => 'auth'],
            function () use ($router) {
                $router->post('login', ['uses' => 'Api\Auth\AuthController@postLogin']);
                $router->put('token', ['uses' => 'Api\Auth\AuthController@putToken']);
                $router->post('password/email', ['uses' => 'Api\Auth\PasswordController@email']);
                $router->post('password/reset/{token}', ['uses' => 'Api\Auth\PasswordController@reset']);

                $router->post('invited/{token}', ['uses' => 'Api\Auth\AuthController@invited']);

            }
        );

        /*
        * Auth
        */
        $router->group(['prefix' => 'tenancies'],
            function () use ($router) {
                $router->post('draft', ['uses' => 'Api\Tenancy\TenanciesController@draft']);
                $router->get('{propertyId}/drafts', ['uses' => 'Api\Tenancy\TenanciesController@getPropertiesDraftTenancies']);
                $router->get('/', ['uses' => 'Api\Tenancy\TenanciesController@index']);

                $router->get('{tenancyId}',['uses' => 'Api\Tenancy\TenanciesController@getTenancyById']);
                $router->post('{tenancyId}/invite-email',['uses' => 'Api\Tenancy\TenanciesController@inviteByEmail']);



                $router->post('{tenancyId}/rentbook',['uses' => 'Api\Tenancy\TenanciesRentBookController@addPayment']);
                $router->get('{tenancyId}/rentbook/{paymentId}',['uses' => 'Api\Tenancy\TenanciesRentBookController@getRentPayment']);
                $router->put('{tenancyId}/rentbook/{paymentId}',['uses' => 'Api\Tenancy\TenanciesRentBookController@updateRentPayment']);
                $router->delete('{tenancyId}/rentbook/{paymentId}',['uses' => 'Api\Tenancy\TenanciesRentBookController@removeRentPayment']);



            }
        );
        $router->any('/gocardless/webhook', 'Api\GoCardless\GoCardlessWebHooksController@hook');

    }
);

