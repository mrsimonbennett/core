<?php
/** @var Router $router */
use FullRent\Core\Application\Http\Controllers\CompanyController;
use Illuminate\Routing\Router;

$router->post('companies', CompanyController::class . '@createCompany');
$router->get('companies/{id}', CompanyController::class . '@show');