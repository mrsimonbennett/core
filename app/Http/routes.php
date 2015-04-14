<?php
/** @var Router $router */
use FullRent\Core\Application\Http\Controllers\ApplicationController;
use FullRent\Core\Application\Http\Controllers\Auth\AuthController;
use FullRent\Core\Application\Http\Controllers\CompanyController;
use FullRent\Core\Application\Http\Controllers\ContractsController;
use FullRent\Core\Application\Http\Controllers\PropertiesController;
use FullRent\Core\Application\Http\Controllers\UserController;
use Illuminate\Routing\Router;

/**
 * Companies
 */
$router->post('companies', CompanyController::class . '@createCompany');
$router->get('companies/exists/{domain}', CompanyController::class . '@checkExists');
$router->get('companies/{domain}', CompanyController::class . '@show');
/*
 * Properties
 */
$router->post('properties/accept-applications', PropertiesController::class . '@acceptApplication');
$router->post('properties/close-applications', PropertiesController::class . '@closeApplication');

$router->get('properties/{id}/history', PropertiesController::class . '@getHistory');


$router->post('properties', PropertiesController::class . '@listNewProperty');
$router->get('properties', PropertiesController::class . '@index');
$router->get('properties/{id}', PropertiesController::class . '@show');

/**
 * Contracts
 */
$router->post('contracts', ContractsController::class . '@draftContract');


/**
 * Users
 */
$router->resource('users', UserController::class);

/*
 * Auth
 */
$router->group(['prefix' => 'auth'],
    function () use ($router) {
        $router->post('login', ['uses' => AuthController::class . '@postLogin']);
        $router->put('token', ['uses' => AuthController::class . '@putToken']);
    });


$router->group(['prefix' => 'applications'],
    function () use ($router) {
        $router->get('for-property/{propertyId}',ApplicationController::class. '@forProperty');

        $router->post('{propertyId}/create-account',ApplicationController::class . '@createAccount');
        $router->post('{propertyId}/{applicationId}/personal',ApplicationController::class . '@personal');
        $router->post('{propertyId}/{applicationId}/residential',ApplicationController::class . '@residential');
        $router->post('{propertyId}/{applicationId}/finish',ApplicationController::class . '@finish');

        $router->post('{propertyId}/{applicationId}/reject',ApplicationController::class . '@reject');
        $router->post('{propertyId}/{applicationId}/approve',ApplicationController::class . '@approve');

        $router->post('{propertyId}/for-user',ApplicationController::class . '@forUser');
        $router->get('{propertyId}/{applicationId}',ApplicationController::class . '@showApplication');

    }
);