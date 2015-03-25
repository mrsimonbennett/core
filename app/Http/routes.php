<?php
/** @var Router $router */
use FullRent\Core\Application\Http\Controllers\CompanyController;
use FullRent\Core\Application\Http\Controllers\ContractsController;
use FullRent\Core\Application\Http\Controllers\PropertiesController;
use Illuminate\Routing\Router;

/**
 * Companies
 */
$router->post('companies', CompanyController::class . '@createCompany');
$router->get('companies/{id}', CompanyController::class . '@show');

/*
 * Properties
 */
$router->post('properties', PropertiesController::class . '@listNewProperty');

/**
 * Contracts
 */
$router->post('contracts',ContractsController::class . '@draftContract');
