<?php
/** @var Router $router */
use Illuminate\Routing\Router;


$router->group(['middleware' => ['guest', 'company']],
    function (Router $router) {
        $router->get('auth/login', ['uses' => 'Auth\AuthLoginController@getLogin']);
        $router->post('auth/login', ['uses' => 'Auth\AuthLoginController@postLogin']);

        $router->get('/auth/invited/{token}', 'Auth\AuthInvitedController@getInvitedForm');
        $router->post('/auth/invited/{token}', 'Auth\AuthInvitedController@postInvitedForm');

        $router->get('/auth/password-reset', 'Auth\AuthPasswordController@getResetPasswordForm');
        $router->post('/auth/password-reset', 'Auth\AuthPasswordController@postResetPassword');

        $router->get('/auth/password-reset/{token}/', 'Auth\AuthPasswordController@getResetWithTokenForm');
        $router->post('/auth/password-reset/{token}/', 'Auth\AuthPasswordController@postResetWithTokenForm');
    });


$router->group(['middleware' => ['auth', 'company']],
    function (Router $router) {
        $router->get('/', ['uses' => 'DashboardController@index']);


        /**
         * Properties
         */
        $router->get('/properties', ['uses' => 'Properties\PropertiesController@index']);
        $router->get('/properties/create', ['uses' => 'Properties\PropertiesController@create']);
        $router->post('/properties', ['uses' => 'Properties\PropertiesController@listProperty']);

        $router->get('/properties/{propertyId}', ['uses' => 'Properties\PropertiesController@show']);
        $router->put('/properties/{propertyId}', ['uses' => 'Properties\PropertiesController@update']);
        $router->get('/properties/{propertyId}/edit', ['uses' => 'Properties\PropertiesController@edit']);

        /**
         * Tenancies
         */
        $router->get('/tenancies', ['uses' => 'Tenancies\TenanciesController@index']);
        $router->get('/tenancies/draft', ['uses' => 'Tenancies\TenanciesController@draft']);

        $router->get('/tenancies/{tenancyId}', ['uses' => 'Tenancies\TenanciesController@show']);
        $router->get('/tenancies/{tenancyId}/invite', ['uses' => 'Tenancies\TenanciesInviteController@getInviteForm']);
        $router->post('/tenancies/{tenancyId}/invite-email', 'Tenancies\TenanciesInviteController@postInviteViaEmail');

        /**
         * Tenancies Rent Book
         */
        $router->get('/tenancies/{tenancyId}/rentbook/add', 'Tenancies\RentBook\TenanciesRentBookController@add');
        $router->post('/tenancies/{tenancyId}/rentbook', 'Tenancies\RentBook\TenanciesRentBookController@addPayment');

        $router->get('/tenancies/{tenancyId}/rentbook/{rentPaymentId}/change',
                     'Tenancies\RentBook\TenanciesRentBookController@change');
        $router->put('/tenancies/{tenancyId}/rentbook/{rentPaymentId}',
                     'Tenancies\RentBook\TenanciesRentBookController@updateRentPayment');
        $router->get('/tenancies/{tenancyId}/rentbook/{rentPaymentId}/delete',
                     'Tenancies\RentBook\TenanciesRentBookController@deleteRentPayment');


    }
);
