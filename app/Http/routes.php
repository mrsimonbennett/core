<?php
/** @var Router $router */
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
$router->get('companies/exists/{domain}',CompanyController::class.'@checkExists');
$router->get('companies/{domain}', CompanyController::class . '@show');
/*
 * Properties
 */
$router->post('properties', PropertiesController::class . '@listNewProperty');

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
        $router->post('login',['uses' => AuthController::class .'@postLogin']);
        $router->put('token',['uses' => AuthController::class .'@putToken']);
    });
