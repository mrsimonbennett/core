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
$router->group(['prefix' => 'properties'],
    function () use ($router) {
        $router->post('accept-applications', PropertiesController::class . '@acceptApplication');
        $router->post('close-applications', PropertiesController::class . '@closeApplication');
        $router->get('{id}/history', PropertiesController::class . '@getHistory');
        $router->post('', PropertiesController::class . '@listNewProperty');
        $router->get('', PropertiesController::class . '@index');
        $router->get('{id}', PropertiesController::class . '@show');

        /**
         * Contracts
         */
        $router->get('{id}/contracts', ContractsController::class . '@index');

    }
);
$router->group(['prefix' => 'contracts/{id}'],
    function () use ($router) {
        $router->get('', ContractsController::class . '@show');

        $router->post('dates', ContractsController::class . '@saveDates');
        $router->post('rent', ContractsController::class . '@saveRent');
        $router->post('documents', ContractsController::class . '@saveDocuments');
        $router->post('lock', ContractsController::class . '@lockContract');
        $router->post('landlord-sign',ContractsController::class . '@landlordSignContract');

        $router->post('tenant-upload-id',ContractsController::class . '@tenantUploadIdDocument');
        $router->post('tenant-upload-earnings',ContractsController::class . '@tenantUploadEarningsDocument');
        $router->post('tenant-sign-contract',ContractsController::class . '@tenantSignContract');


    }
);


        $router->get('/tenants/{id}/contracts', \FullRent\Core\Application\Http\Controllers\Tenant\ContractsController::class . '@getTenantsContracts');



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
        $router->get('for-property/{propertyId}', ApplicationController::class . '@forProperty');

        $router->post('{propertyId}/create-account', ApplicationController::class . '@createAccount');
        $router->post('{propertyId}/{applicationId}/personal', ApplicationController::class . '@personal');
        $router->post('{propertyId}/{applicationId}/residential', ApplicationController::class . '@residential');
        $router->post('{propertyId}/{applicationId}/finish', ApplicationController::class . '@finish');

        $router->post('{propertyId}/{applicationId}/reject', ApplicationController::class . '@reject');
        $router->post('{propertyId}/{applicationId}/approve', ApplicationController::class . '@approve');

        $router->post('{propertyId}/for-user', ApplicationController::class . '@forUser');
        $router->get('{propertyId}/{applicationId}', ApplicationController::class . '@showApplication');

    }
);